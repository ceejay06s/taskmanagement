@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col m8 push-m2">
            <div class="card">
                <div class="card-content">
                    <div class="card-title">{{ __('Verify Your Email Address') }}</div>
                     @if (session('resent'))
                        <script>
                            M.toast({
                                html: " {{ __('A fresh verification link has been sent to your email address.') }}"
                            })
                        </script>
                    @endif
                    {{ __('Before proceeding, please check your email for a verification link.') }}
                    {{ __('If you did not receive the email') }},
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn blue-grey lighten-1">{{ __('click here to request another') }}</button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
