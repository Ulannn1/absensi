@extends('layouts.app')

@section('title', 'Login')

@section('content')
  <div class="row justify-content-center align-items-center min-vh-75">
    <div class="col-md-6 col-lg-4">
      <div class="card app-card border-0 overflow-hidden">
        <div class="card-body p-4 p-md-5">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="card-title mb-0">Selamat datang</h4>
            <small class="muted">Masuk untuk melanjutkan</small>
          </div>

          <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input name="email" type="email" value="{{ old('email') }}" class="form-control form-control-lg" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input name="password" type="password" class="form-control form-control-lg" required>
            </div>

            <div class="row mb-3 align-items-center">
              <div class="col-auto">
                <div class="form-check">
                  <input name="remember" type="checkbox" class="form-check-input" id="remember">
                  <label class="form-check-label small muted" for="remember">Ingat saya</label>
                </div>
              </div>
              <div class="col text-end">
                <a href="#" class="small">Lupa password?</a>
              </div>
            </div>

            <div class="d-grid gap-2 mb-3">
              <button class="btn btn-primary btn-lg">Masuk</button>
            </div>

            <div class="text-center small muted">atau masuk dengan</div>
            <div class="d-flex gap-2 justify-content-center mt-3">
              <button type="button" class="btn btn-outline-secondary btn-sm"><i class="bi bi-google"></i> Google</button>
              <button type="button" class="btn btn-outline-secondary btn-sm"><i class="bi bi-github"></i> GitHub</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
