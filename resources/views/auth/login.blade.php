@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="container">
  <div class="row justify-content-center py-5">
    <div class="col-md-8 col-lg-6">
      <div class="auth-card card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center py-4">
          <h2 class="fw-bold mb-0">Welcome Back</h2>
          <p class="mb-0">Sign in to continue</p>
        </div>

        <div class="card-body p-5">
          <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="mb-4">
              <label for="email" class="form-label text-muted small mb-1">{{ __('Email Address') }}</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="fas fa-envelope text-muted"></i>
                </span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
              </div>
              @error('email')
                <div class="invalid-feedback d-block">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="mb-4">
              <label for="password" class="form-label text-muted small mb-1">{{ __('Password') }}</label>
              <div class="input-group">
                <span class="input-group-text bg-light border-end-0">
                  <i class="fas fa-lock text-muted"></i>
                </span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                  name="password" required autocomplete="current-password">
              </div>
              @error('password')
                <div class="invalid-feedback d-block">
                  {{ $message }}
                </div>
              @enderror
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
              <div class="form-check">
                <input type="checkbox" class="form-check-input" name="remember" id="remember"
                  {{ old('remember') ? 'checked' : '' }}>
                <label class="form-check-label text-muted small" for="remember">
                  {{ __('Remember Me') }}
                </label>
              </div>
              @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="small text-decoration-none text-primary">
                  Forgot Password?
                </a>
              @endif
            </div>

            <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
              {{ __('Login') }}
            </button>

            <div class="text-center text-muted small mb-3">Or continue with</div>

            <div class="d-grid gap-2">
              <a href="#" class="btn btn-light border py-2 text-muted">
                <i class="fab fa-google me-2"></i> Google
              </a>
            </div>
          </form>
        </div>

        <div class="card-footer bg-light text-center py-3">
          <span class="text-muted small">Don't have an account?</span>
          <a href="{{ route('register') }}" class="text-decoration-none small fw-bold text-primary">Sign up</a>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
