@extends('layouts.app')

@section('title', 'Register')

@section('content')
    <h3 class="section__title-login-register">Register</h3>
    <section class="login-register row">
        <div class="register-form col-12 col-md-6">
            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-floating mb-4">
                    <input id="name" name="name" type="text" class="form-control form-control_gray"
                        placeholder="Name *" value="{{ old('name') }}" required value="{{ old('name') }}"
                        autocomplete="name" autofocus>
                    <label for="name">Name *</label>
                    @error('name')
                        <small class="text-invalid">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-floating mb-4">
                    <input id="email" name="email" type="email" class="form-control form-control_gray"
                        placeholder="Email address *" required value="{{ old('email') }}" autocomplete="email">
                    <label for="email">Email address *</label>
                    @error('email')
                        <small class="text-invalid">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-floating mb-4">
                    <input id="password" name="password" type="password" class="form-control form-control_gray"
                        placeholder="Password *" required autocomplete="new-password">
                    <label for="password">Password *</label>
                    @error('password')
                        <small class="text-invalid">{{ $message }}</small>
                    @enderror
                </div>
                <div class="form-floating">
                    <input id="password-confirm" name="password_confirmation" type="password"
                        class="form-control form-control_gray" placeholder="Password *" required
                        autocomplete="new-password">
                    <label for="password-confirm">Password Confirmation *</label>
                </div>
                <div class="my-2 p-2">
                    <p class="m-0">Your personal data will be used to support your experience throughout this website, to
                        manage access to your account, and for other purposes described in our privacy policy.</p>
                </div>
                <button id="registerButton" type="submit" class="btn btn-primary btn-full rounded-md">
                    <span id="registerText">Create account</span>
                    <div id="spinner" class="spinner-border spinner-border-sm visually-hidden" role="status"></div>
                </button>
                <div class="customer-option mt-4 text-center">
                    <span class="text-secondary">Already have an account?</span>
                    <a href="/login" class="btn-text js-show-register">Login</a>
                </div>
            </form>
        </div>
    </section>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('registerForm').addEventListener('submit', function(event) {
                var emailInput = document.getElementById('email');
                var passwordInput = document.getElementById('password');

                if (!emailInput.value || !passwordInput.value) {
                    event.preventDefault();
                    return;
                }

                document.getElementById('spinner').classList.remove('visually-hidden');
                document.getElementById('registerText').innerText = '';
            });
        });
    </script>
@endpush
