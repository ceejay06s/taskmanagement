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
                            @if(file_exists(public_path('storage/'.Auth::user()->id)))
                            <img class="circle" src="{{asset('storage/'.Auth::user()->id)}}" style="width: 10rem; border:1px solid black;" alt="" srcset="">
                            @else
                            <i class="material-icons large">account_circle</i>
                            @endif
                            @if(Auth::user()->email_verified_at)
                            <div class="center-align green-text">
                                <i class="material-icons" style="vertical-align: bottom;">verified_user</i> Verified
                            </div>
                            @else
                            <div class="center-align">
                                <a class="blue-grey-text lighten-1" href="/email/verify">
                                    <i class="material-icons" style="vertical-align: bottom;">offline_pin</i> Verify this Account
                                </a>

                            </div>
                            @endif
                        </div>

                    </div>
                    <div class="row">
                        <div class="input-field col m12">
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