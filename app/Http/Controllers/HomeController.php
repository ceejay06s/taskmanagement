<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Todo;
use App\Models\TodoAttachment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $sort = array(
            'field' => 'updated_at',
            'type' => 'asc'
        );
        $searchTask = null;
        if ($request->isMethod('post')) {
            // var_dump($request->sort);
            if (!is_null($request->search) && !empty($request->search)) {
                $searchTask = $request->search;
            }

            if ($request->sort == 'ascending') {
                $sort = array(
                    'field' => 'created_at',
                    'type' => 'asc'
                );
            } else if ($request->sort == 'descending') {
                $sort = array(
                    'field' => 'created_at',
                    'type' => 'desc'
                );
            }
        }
        $Todo = Todo::where('user_id', Auth::id())->where('type', 1)->whereRaw('status <> 5')->orderBy($sort['field'], $sort['type'])->groupBy('status', 'updated_at')->get()->each(
            function ($test) {
                $test2 = Todo::find($test->id);

                $test->count = Todo::where('parent_id', $test->id)->whereRaw('status <> 5')->count();
                $test->attachment = TodoAttachment::where('todo_id', $test->id)->count();
                $test->title = $test2->title;
                $test->description = $test2->description;
                $test->created_at = $test2->created_at;
                $test->status = $test2->status;

                $test->deadline_datetime = $test2->deadline_datetime;
            }
        );
        if (!is_null($searchTask)) {
            $Todo = Todo::where('title', 'LIKE', '%' . $searchTask . '%')->orWhere('description', 'LIKE', '%' . $searchTask . '%')->where('user_id', Auth::id())->where('type', 1)->whereRaw('status <> 5')->orderBy($sort['field'], $sort['type'])->groupBy('status', 'updated_at')->get()->each(
                function ($test) {
                    $test2 = Todo::find($test->id);

                    $test->count = Todo::where('parent_id', $test->id)->whereRaw('status <> 5')->count();
                    $test->attachment = TodoAttachment::where('todo_id', $test->id)->count();
                    $test->title = $test2->title;
                    $test->description = $test2->description;
                    $test->created_at = $test2->created_at;
                    $test->parent_id = $test2->parent_id;
                    $test->status = $test2->status;

                    $test->deadline_datetime = $test2->deadline_datetime;
                }
            );
        }
        return view('home', ['Todo' => $Todo]);
    }
    public function addtodo($task = null, Request $request)
    {

        if ($request->isMethod('post')) {
            $input = $request->all();

            $ToDo = new Todo;
            $ToDo->title = $input['todo_title'];
            $ToDo->type = 1;
            $ToDo->user_id  = Auth::id();
            if (isset($task)) {

                $ToDo->type = 2;

                $ToDo->parent_id = $task;
            }
            $ToDo->description = $input['todo_description'];
            $ToDo->status = $input['todo_status'];
            if (isset($input['todo_deadline_date'], $input['todo_deadline_time']))
                $ToDo->deadline_datetime = date('Y-m-d H:i:s', strtotime($input['todo_deadline_date'] . ' ' . $input['todo_deadline_time']));
            $ToDo->save();
            $file = $request->file('todo_attachments');
            if (!empty($file)) {
                Storage::disk('local');
                $attachmentname = $file->hashName();
                $originalname = $file->getClientOriginalName();
                $attachmentpath = $request->file('todo_attachments')->storeAs(
                    'public',
                    $attachmentname,
                    'local'
                );

                $attachment = new TodoAttachment;
                $attachment->name = $attachmentname;
                $attachment->original_name = $originalname;
                $attachment->url = $attachmentpath;
                $attachment->todo_id = $ToDo->id;
                $attachment->save();
                Storage::setVisibility($attachmentpath, 'public');
            }
            return redirect()->route('edittodo', ['id' => $ToDo->id, 'item' => $task])->with('status', 'Task Added!');
        }
        return view('addTodo');
    }
    public function edittodo($id, $item = null, Request $request)
    {

        $ToDo = Todo::find($id);
        if ($request->isMethod('post')) {
            $input = $request->all();
            $ToDo->id = $input['todo_id'];
            $ToDo->title = $input['todo_title'];
            $ToDo->parent_id = $item;
            $ToDo->type = (!is_null($item) ? 2 : 1);
            $ToDo->description = $input['todo_description'];
            $ToDo->status = $input['todo_status'];
            if (isset($input['todo_deadline_date'], $input['todo_deadline_time']))
                $ToDo->deadline_datetime = date('Y-m-d H:i:s', strtotime($input['todo_deadline_date'] . ' ' . $input['todo_deadline_time']));
            $ToDo->save();
            $file = $request->file('todo_attachments');
            if (!empty($file)) {
                Storage::disk('local');
                $attachmentname = $file->hashName();
                $originalname = $file->getClientOriginalName();
                $attachmentpath = $request->file('todo_attachments')->storeAs(
                    'public',
                    $attachmentname,
                    'local'
                );
                $attachment = new TodoAttachment;
                $attachment->name = $attachmentname;
                $attachment->original_name = $originalname;
                $attachment->url = $attachmentpath;
                $attachment->todo_id = $id;
                $attachment->save();
                Storage::setVisibility($attachmentpath, 'public');
            }
            return redirect()->route('edittodo', ['id' => $id, 'item' => $item])->with('status', 'Task Edited!');
        }

        $Tasks = Todo::where('parent_id', $id)->whereRaw('status <> 5')->where('user_id', Auth::id())->orderBy('updated_at', 'desc')->groupBy('status', 'updated_at')->get()->each(
            function ($test) {
                $test2 = Todo::find($test->id);
                $test->count = Todo::where('parent_id', $test->id)->whereRaw('status <> 5')->count();
                $test->attachment = TodoAttachment::where('todo_id', $test->id)->count();
                $test->title = $test2->title;
                $test->description = $test2->description;
                $test->status = $test2->status;
                $test->parent_id = $test2->parent_id;
                $test->created_at = $test2->created_at;
                $test->deadline_datetime = $test2->deadline_datetime;
            }

        );
        $attachments = TodoAttachment::where('todo_id', $id)->get();
        return view('editTodo', ['Todo' => $ToDo, 'Tasks' => $Tasks, 'attachments' => $attachments]);
    }

    public function updateTask($task, $type)
    {
        if ($type == 5) //bin
        {
            $Todo = Todo::find($task);
            $Todo->status = 5;
            $Todo->save();
            return redirect()->route('home')->with('status', 'Task moved to bin!');
        } else if ($type == 6) {
            $Todo = Todo::find($task);
            $Todo->delete();
            $Todo = Todo::where('parent_id', $task)->delete();
            $TodoAttachment = TodoAttachment::where('todo_id', $task)->get()->each(
                function ($attachment) {
                    Storage::delete($attachment->url);

                    //var_dump($attachment->url);
                }

            );
            TodoAttachment::where('todo_id', $task)->delete();
            return redirect()->route('home')->with('status', 'Task permanently deleted!');


            //var_dump($TodoAttachment); //->delete();
        } elseif ($type == 8) {
            $TodoAttachment = TodoAttachment::find($task);
            return Storage::download($TodoAttachment->url, $TodoAttachment->original_name);
        } elseif ($type == 9) {
            $TodoAttachment = TodoAttachment::find($task);
            Storage::delete($TodoAttachment->url);
            TodoAttachment::find($task)->delete();
            return redirect()->back();
        }
    }

    function binTodo()
    {
        $sort = array(
            'field' => 'updated_at',
            'type' => 'asc'
        );
        $searchTask = null;
        $Todo = Todo::where('type', 1)->where('status', 5)->where('user_id', Auth::id())->groupBy('status', 'updated_at')->get()->each(
            function ($test) {
                $test2 = Todo::find($test->id);

                $test->count = Todo::where('parent_id', $test->id)->where('status', 5)->count();
                $test->attachment = TodoAttachment::where('todo_id', $test->id)->count();
                $test->title = $test2->title;
                $test->description = $test2->description;
                $test->created_at = $test2->created_at;
                $test->status = $test2->status;

                $test->deadline_datetime = $test2->deadline_datetime;
            }
        );
        // if (!is_null($searchTask)) {
        //     $Todo = Todo::where('title', $searchTask)->orWhere('description', $searchTask)->where('type', 1)->whereRaw('status <> 5')->orderBy($sort['field'], $sort['type'])->groupBy('status', 'updated_at')->get()->each(
        //         function ($test) {
        //             $test2 = Todo::find($test->id);

        //             $test->count = Todo::where('parent_id', $test->id)->whereRaw('status <> 5')->count();
        //             $test->attachment = TodoAttachment::where('todo_id', $test->id)->count();
        //             $test->title = $test2->title;
        //             $test->description = $test2->description;
        //             $test->created_at = $test2->created_at;
        //             $test->parent_id = $test2->parent_id;
        //             $test->status = $test2->status;

        //             $test->deadline_datetime = $test2->deadline_datetime;
        //         }
        //     );
        // }
        return view('bin', ['Todo' => $Todo]);
    }
    public function accounts(Request $request)
    {
        if ($request->isMethod('post')) {
            $user = User::find(Auth::user()->id);
            $user->name = $request->name;
            $user->email = $request->email;

            $file = $request->file('attachments');
            if (!empty($file)) {
                Storage::disk('local');
                $attachmentname = $file->hashName();
                $originalname = $file->getClientOriginalName();
                $attachmentpath = $request->file('attachments')->storeAs(
                    'public',
                    $request->user()->id,
                    'local'
                );
                $user->image = $attachmentname;
                Storage::setVisibility($attachmentpath, 'public');
            }

            $contine = true;
            if (isset($request->password) && !empty($request->password)) {
                $user->password = Hash::make($request->password);
                //$message = 'User Updated';
                if (!Hash::check($request->confirmpassword, $user->password)) {
                    $contine = false;
                }
            }

            if ($contine)
                if ($user->save())
                    return redirect()->route('home')->with('status', 'User Updated');
        }
        //var_dump($request->all());
        return view('accounts');
    }
}
