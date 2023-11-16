@extends('layouts.app')

@section('content')
<style>
    .datepicker-modal {
        height: fit-content !important;
    }
</style>
<div class="container">
    <div class="row justify-content-center">
        <div class="col m8 push-m2">
            <form class="card" method="POST" enctype="multipart/form-data">
                @csrf


                <div class="card-content">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="card-title">{{ __('add Todo') }}</div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input name="todo.title" required id="title" type="text" class="validate">
                            <label for="title">Title</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12 ">
                            <textarea name="todo.description" required id="description" class="materialize-textarea"></textarea>
                            <label for="description">Description</label>
                        </div>
                    </div>

                    <div class="row">

                        <div class="input-field col s6 ">
                            <input name="todo.deadline.date" required type="text" class="datepicker" placeholder="Deadline Date">
                        </div>
                        <div class="input-field col s6 ">
                            <input name="todo.deadline.time" required type="text" class="timepicker" placeholder="Deadline Time">
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <select name="todo.status" required>
                                <option selected value="1">To Do</option>
                                <option value="2">In Progress</option>
                                <option value="3">Completed</option>
                            </select>
                            <label>Status</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>Attach</span>
                                <input name="todo.attachments" type="file">
                            </div>
                            <div class="file-path-wrapper">
                                <input name="todo.attachmentnames" class="file-path validate" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="fixed-action-btn ">
                        <button type="submit" class="btn-floating btn-large blue-grey lighten-1 ">
                            <i class="large material-icons">save</i>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection