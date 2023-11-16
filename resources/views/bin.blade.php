@extends('layouts.app')

@section('content')

<?php
$task = [];
foreach ($Todo as $taskitems) {
    $task[$taskitems->status][] = $taskitems;
}
?>

<div class="container-fluid">
    
    <div class="row justify-content-center">
        
        <div class="col s12 l4 push-l4">
            <h6>Trash</h6>
            @if(isset($task[5]))
            <ul class="collapsible popout" style="max-height: 500px; background: white; overflow: auto;">
                @foreach($task[5] as $Task_Item)
                <li>
                    <blockquote class="collapsible-header blue-grey lighten-5" style="border-color: black; border-bottom: 0px;">
                        {{$Task_Item->title}}
                    </blockquote>
                    <div class="collapsible-body collapsible-body_custom " style="padding-top: 0px !important;">
                        <div class="truncate">{{$Task_Item->description}}</div>
                        <hr>
                        <a class="btn-floating small right wave-effect tooltipped" href="/updatetodo/{{$Task_Item->id}}/6" data-position="left" data-tooltip="Permanent Delete">
                            <i class="material-icons">delete_forever</i>
                        </a>
                        <div>
                            @if($Task_Item->count)
                            <div class="chip tooltipped" data-position="bottom" data-tooltip="Sub-Task">{{$Task_Item->count}} Item/s in List</div>
                            @endif
                            @if($Task_Item->attachment)
                            <div class="chip tooltipped" data-position="bottom" data-tooltip="Attachments">{{$Task_Item->attachment}} Attachment/s</div>
                            @endif
                            <div class="chip tooltipped" data-position="bottom" data-tooltip="Date-Time Created">{{date('M d, Y H:i A',strtotime($Task_Item->created_at))}}</div>
                            <div class="chip  red-text tooltipped" data-position="bottom" data-tooltip="Deadline">{{date('M d, Y H:i A',strtotime($Task_Item->deadline_datetime))}}</div>
                            
                            @if($Task_Item->status ==1)
                            <div class="chip tooltipped" data-position="bottom" data-tooltip="Status">To Do</div>
                            @elseif($Task_Item->status ==2)
                            <div class="chip blue white-text tooltipped" data-position="bottom" data-tooltip="Status">Pending</div>
                            @elseif($Task_Item->status ==3)
                            <div class="chip green white-text tooltipped" data-position="bottom" data-tooltip="Status">Completed</div>
                            @endif
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @endif
        </div>
    </div>
</div>

@endsection