@extends('layouts.app')

@section('title', 'Register')

@section('content')
  <div class="container">
    <div class="row justify-content-center py-5">
      <div class="col-md-8 col-lg-6">
        <div class="auth-card card shadow-lg border-0">
          <div class="card-header bg-primary text-white text-center py-4">
            <h2 class="fw-bold mb-0">Create Account</h2>
            <p class="mb-0">Join our community today</p>
          </div>

          <div class="card-body p-5">
            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="mb-4">
                <label for="name" class="form-label text-muted small mb-1">{{ __('Name') }}</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-user text-muted"></i>
                  </span>
                  <input id="name" type="text" class="form-control @error('name') is-invalid @enderror"
                    name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                </div>
                @error('name')
                  <div class="invalid-feedback d-block">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="mb-4">
                <label for="email" class="form-label text-muted small mb-1">{{ __('Email Address') }}</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-envelope text-muted"></i>
                  </span>
                  <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email') }}" required autocomplete="email">
                </div>
                @error('email')
                  <div class="invalid-feedback d-block">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="mb-4">
                <label for="address" class="form-label text-muted small mb-1">{{ __('Shipping Address') }}</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-map-marker-alt text-muted me-1"></i>
                  </span>
                  <textarea id="address" class="form-control @error('address') is-invalid @enderror" name="address" rows="3"
                    required autocomplete="address">{{ old('address') }}</textarea>
                  @error('address')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              </div>
              <div class="mb-4">
                <label for="phone" class="form-label text-muted small mb-1">{{ __('Phone Number') }}</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-phone text-muted"></i>
                  </span>
                  <input id="phone" type="tel" class="form-control @error('phone') is-invalid @enderror"
                    name="phone" value="{{ old('phone') }}" required autocomplete="tel">
                </div>
                  @error('phone')
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                    </span>
                  @enderror
                </div>
              <div class="mb-4">
                <label for="password" class="form-label text-muted small mb-1">{{ __('Password') }}</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-lock text-muted"></i>
                  </span>
                  <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="new-password">
                </div>
                @error('password')
                  <div class="invalid-feedback d-block">
                    {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="mb-4">
                <label for="password-confirm"
                  class="form-label text-muted small mb-1">{{ __('Confirm Password') }}</label>
                <div class="input-group">
                  <span class="input-group-text bg-light border-end-0">
                    <i class="fas fa-lock text-muted"></i>
                  </span>
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required
                    autocomplete="new-password">
                </div>
              </div>

              <div class="form-check mb-4">
                <input class="form-check-input" type="checkbox" required id="terms">
                <label class="form-check-label small text-muted" for="terms">
                  I agree to the <a href="#" class="text-decoration-none text-primary">Terms of Service</a> and
                  <a href="#" class="text-decoration-none text-primary">Privacy Policy</a>
                </label>
              </div>

              <button type="submit" class="btn btn-primary w-100 py-2 mb-3">
                {{ __('Create Account') }}
              </button>
            </form>
          </div>

          <div class="card-footer bg-light text-center py-3">
            <span class="text-muted small">Already have an account?</span>
            <a href="{{ route('login') }}" class="text-decoration-none small fw-bold text-primary">Sign in</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
