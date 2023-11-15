@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col m8 push-m2">
            <form class="card" method="POST" enctype="multipart/form-data">
                @csrf
                @if (session('status'))
                <script>
                    M.toast({
                        html: "{{session('status')}}"
                    })
                </script>
                <!-- <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div> -->
                @endif

                <div class="card-content">
                    <div class="card-title">{{ __('Edit Task') }}</div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input value="{{$Todo->id}}" name="todo.id" id="id" type="hidden" class="validate">
                            <input value="{{$Todo->title}}" name="todo.title" id="title" type="text" class="validate">
                            <label for="title">Title</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 ">
                            <textarea name="todo.description" id="description" class="materialize-textarea">{{$Todo->description}}</textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>

                    <div class="row">

                        <div class="input-field col s6 ">
                            <input value="{{date('M d,Y',strtotime($Todo->deadline_datetime))}}" name="todo.deadline.date" type="text" class="datepicker" placeholder="Deadline Date">
                        </div>
                        <div class="input-field col s6 ">
                            <input value="{{date('H:i A',strtotime($Todo->deadline_datetime))}}" name="todo.deadline.time" type="text" class="timepicker" placeholder="Deadline Time">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="todo.status">
                                <option <?= ($Todo->status == 1 ? 'selected' : '') ?> value="1">To Do</option>
                                <option <?= ($Todo->status == 2 ? 'selected' : '') ?> value="2">In Progress</option>
                                <option <?= ($Todo->status == 3 ? 'selected' : '') ?> value="3">Completed</option>
                            </select>
                            <label>Status</label>
                        </div>
                    </div>
                    @if(count($Tasks))
                    <h6>Subtask/s</h6>
                    @foreach($Tasks as $Task_Item)
                    <blockquote class="hoverable">
                        <h5>{{$Task_Item->title}}</h5>
                        <a class="btn-floating right wave-effect tooltipped blue-grey lighten-1" data-position="left" data-tooltip="Edit Task" href="/edittodo/{{$Task_Item->id}}{{($Task_Item->parent_id?'/'.$Task_Item->parent_id:'')}}"><i class="material-icons">mode_edit</i></a>
                        <p>{{$Task_Item->description}}</p>
                        <div>
                            @if($Task_Item->parent_id)
                            <div class="chip tooltipped" data-position="bottom" data-tooltip="Sub-Task">Sub-Task</div>
                            @endif
                            @if($Task_Item->count)
                            <div class="chip tooltipped" data-position="bottom" data-tooltip="Sub-Task">{{$Task_Item->count}} Item/s in List</div>
                            @endif
                            @if($Task_Item->attachment)
                            <div class="chip tooltipped" data-position="bottom" data-tooltip="Attachments">{{$Task_Item->attachment}} Attachment/s</div>
                            @endif
                            <div class="chip  red-text tooltipped" data-position="bottom" data-tooltip="Deadline">{{$Task_Item->deadline_datetime}}</div>
                            @if($Task_Item->status ==1)
                            <div class="chip tooltipped" data-position="bottom" data-tooltip="Status">To Do</div>
                            @elseif($Task_Item->status ==2)
                            <div class="chip blue white-text tooltipped" data-position="bottom" data-tooltip="Status">Pending</div>
                            @elseif($Task_Item->status ==3)
                            <div class="chip green white-text tooltipped" data-position="bottom" data-tooltip="Status">Completed</div>
                            @endif
                        </div>
                    </blockquote>
                    @endforeach
                    @endif
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn blue-grey lighten-1 left">
                                <i class="material-icons ">upload</i>
                                <input id='attach' name="todo.attachments" type="file" placeholder="Upload Attachment">
                            </div>
                            <div class="file-path-wrapper">
                                <input name="todo.attachmentnames" placeholder="Upload Attachment" class="file-path validate" type="text">
                            </div>
                        </div>
                    </div>
                    @if(count($attachments))
                    <h6>Task Attachment/s</h6>
                    <div class="row center-align">
                        @foreach($attachments as $attachment)
                        <div class="col s6 m4 l2 center-align">
                            @if(in_array(explode('.',$attachment->name)[1],array('png','jpg','jpeg')))
                            <a class="dropdown-trigger" data-target='dropdown_{{$attachment->id}}'>
                                <img class="responsive-img materialboxed" src="{{asset('storage/'.$attachment->name);}}" alt="{{asset('storage/'.$attachment->original_name);}}" srcset="">
                                <p>{{$attachment->original_name}}</p>
                            </a>
                            <ul id='dropdown_{{$attachment->id}}' class='dropdown-content' style="width:fit-content !important">
                                <li><a href="/updatetodo/{{$attachment->id}}/8"><i class=" material-icons left">file_download</i>Download</a></li>
                                <li><a href="/updatetodo/{{$attachment->id}}/9"><i class="material-icons left">delete</i>Delete</a></li>
                            </ul>
                            @else
                            <a class="dropdown-trigger" data-target='dropdown_{{$attachment->id}}'>
                                <i class="material-icons large">description</i>
                                <p>{{$attachment->original_name}}</p>
                            </a>
                            <ul id='dropdown_{{$attachment->id}}' class='dropdown-content' style="width:fit-content !important">
                                <li><a href="/updatetodo/{{$attachment->id}}/8"><i class="material-icons left">file_download</i>Download</a></li>
                                <li><a href="/updatetodo/{{$attachment->id}}/9"><i class="material-icons left">delete</i>Delete</a></li>
                            </ul>
                            @endif

                        </div>

                        @endforeach
                    </div>
                    @endif
                    <!-- @if($Todo->type == 1)
                    <a href="/addtodo/{{$Todo->id}}" class="btn wave-effect">Add Item</a>
                    @else
                    <a href="/edittodo/{{$Todo->parent_id}}" class="btn wave-effect">Back</a>
                    @endif -->
                    <div class="fixed-action-btn ">
                        <a class="btn-floating btn-large blue-grey lighten-1">
                            <i class="large material-icons">menu</i>
                        </a>
                        <ul class="">


                            <li><a href="/" class="btn-floating grey darken-4 tooltipped" data-position="left" data-tooltip="Back"><i class="material-icons">arrow_back</i></a></li>

                            <li><a href="/updatetodo/{{$Todo->id}}/5" class="btn-floating green tooltipped" data-position="left" data-tooltip="Remove"><i class="material-icons">remove</i></a></li>
                            <li><a href="/updatetodo/{{$Todo->id}}/6" class="btn-floating blue tooltipped" data-position="left" data-tooltip="Delete"><i class="material-icons">delete_forever</i></a></li>
                            <li> <button type="submit" class="btn-floating red tooltipped" data-position="left" data-tooltip="Save">
                                    <i class="large material-icons">save</i>
                                </button></li>
                            @if($Todo->type == 1)
                            <li><a href="/addtodo/{{$Todo->id}}" class="btn-floating yellow darken-4 tooltipped" data-position="left" data-tooltip="Add Task Item"><i class="material-icons">add</i></a></li>
                            @endif
                        </ul>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>
@endsection