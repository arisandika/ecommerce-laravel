@extends('layouts.app')

@section('title', 'Login')

@section('content')
    <h3 class="section__title-login-register">Login</h3>
    <section class="login-register row">
        <div class="login-form col-12 col-md-6">
            <form id="loginForm" method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-floating mb-4">
                    <input id="email" name="email" type="email" class="form-control form-control_gray"
                        placeholder="Email address *" required value="{{ old('email') }}" autocomplete="email" autofocus>
                    <label for="email">Email address *</label>
                    @error('email')
                        <small class="text-invalid">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-floating">
                    <input id="password" name="password" type="password" class="form-control form-control_gray"
                        placeholder="Password *" required autocomplete="current-password">
                    <label for="password">Password *</label>
                    @error('password')
                        <small class="text-invalid">{{ $message }}</small>
                    @enderror
                </div>
                <div class="d-flex align-items-center my-2 p-2">
                    <div class="form-check mb-0">
                        <input id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}
                            class="form-check-input form-check-input_fill" type="checkbox">
                        <label class="form-check-label text-secondary" for="remember">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a class="btn-text ms-auto" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>
                <button id="loginButton" type="submit" class="btn btn-primary btn-full rounded-md">
                    <span id="loginText">Login</span>
                    <div id="spinner" class="spinner-border spinner-border-sm visually-hidden" role="status"></div>
                </button>
                <div class="customer-option mt-4 text-center">
                    <span class="text-secondary">No account yet?</span>
                    <a href="/register" class="btn-text js-show-register">Create Account</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('loginForm').addEventListener('submit', function(event) {
                var emailInput = document.getElementById('email');
                var passwordInput = document.getElementById('password');

                if (!emailInput.value || !passwordInput.value) {
                    event.preventDefault();
                    return;
                }

                document.getElementById('spinner').classList.remove('visually-hidden');
                document.getElementById('loginText').innerText = '';
            });
        });
    </script>
@endpush
