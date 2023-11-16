@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
               

                <div class="card-content">
                     <div class="card-title">{{ __('Reset Password') }}</div>
                     @if (session('status'))
                <script>
                    M.toast({
                        html: "{{session('status')}}"
                    })
                </script>
                @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row ">

                            <div class="input-field col s12">
                                <label for="email">{{ __('Email Address') }}</label>
                                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row ">
                            <div class="input-field col m4 push-m8">
                                <button type="submit" class="btn blue-grey lighten-1">
                                    {{ __('Send Password Reset Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
