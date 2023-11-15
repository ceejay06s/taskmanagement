@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col s12 m4 push-m4">
            <form class="card" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="fixed-action-btn ">
                    <button class="btn-floating btn-large blue-grey lighten-1 tooltipped" type='submit' data-position="left" data-tooltip="Add Task">
                        <i class="large material-icons">save</i>
                    </button>
                </div>
                <div class="card-content">
                    <div class="row">
                        <div class="input-field col s12 center-align">
                            <img class="circle" src="{{asset('storage/'.Auth::user()->id)}}" style="width: 10rem; border:1px solid black;" alt="" srcset="">
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input value="{{ Auth::user()->name }}" name="name" id="title" type="text" class="validate">
                            <label for="title">Name</label>
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col s12 ">
                            <input value="{{ Auth::user()->email }}" name="email" id="email" type="email" class="validate">
                            <label for="email">Email</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 ">
                            <input name="password" id="password" type="password" class="validate">
                            <label for="password">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 ">
                            <input name="confirmpassword" id="confirmpassword" type="password" class="validate">
                            <label for="passconfirmpasswordword">Confirm Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field col s12 ">
                            <div class="btn blue-grey lighten-1 ">
                                <i class="material-icons ">upload</i>
                                <input name="attachments" type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input name="attachmentnames" class="file-path validate" type="text">
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection