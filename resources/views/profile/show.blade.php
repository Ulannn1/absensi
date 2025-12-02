@extends('layouts.app')
@section('title','Profil Saya')
@section('content')
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card app-card border-0 p-4 hover-lift">
        <div class="card-body">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="me-2">
              @if($user->photo)
                <img src="{{ asset('storage/'.$user->photo) }}" class="rounded-circle" width="96" height="96">
              @else
                <div class="bg-secondary text-white rounded-circle d-inline-flex justify-content-center align-items-center" style="width:96px;height:96px">{{ strtoupper(substr($user->name,0,1)) }}</div>
              @endif
            </div>
            <div>
              <h5 class="mb-0">{{ $user->name }}</h5>
              <div class="small muted">{{ $user->email }}</div>
            </div>
          </div>
          <hr />
          <form method="POST" enctype="multipart/form-data" action="{{ route('profile.update') }}">
            @csrf
            <div class="mb-3 text-center">
              @if($user->photo && isset($photoExists) && $photoExists)
                <img src="{{ asset('storage/'.$user->photo) }}" class="rounded-circle" width="120" height="120" alt="Profil">
              @elseif($user->photo && isset($photoExists) && ! $photoExists)
                {{-- Photo path exists in DB but file missing on disk — show placeholder and hint --}}
                <div class="bg-warning text-dark rounded-circle d-inline-flex justify-content-center align-items-center" style="width:120px;height:120px">?</div>
                <div class="mt-2 small text-danger">Foto tidak ditemukan di server. Pastikan `php artisan storage:link` telah dijalankan.</div>
              @else
                <div class="bg-secondary text-white rounded-circle d-inline-flex justify-content-center align-items-center" style="width:120px;height:120px">{{ strtoupper(substr($user->name,0,1)) }}</div>
              @endif
            </div>
            <div class="mb-3">
              <label class="form-label">Nama</label>
              <input name="name" value="{{ old('name',$user->name) }}" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Foto Profil</label>
              <input type="file" name="photo" class="form-control">
              @if($errors->has('photo'))
                <div class="invalid-feedback d-block">{{ $errors->first('photo') }}</div>
              @endif
              <div class="form-text muted small">Jenis file: jpg, png. Maks 50MB.</div>
            </div>
            <div class="d-flex gap-2 justify-content-end">
              <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary">Kembali</a>
              <button class="btn btn-primary">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
