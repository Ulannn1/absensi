@extends('layouts.app')
@section('title','Absensi Hari Ini')
@section('content')
  <div class="row justify-content-center">
    <div class="col-md-10">
      <div class="card app-card border-0 p-4 hover-lift">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div class="d-flex align-items-center gap-3">
              <div>
                <h4 class="mb-0">Absensi Hari Ini</h4>
                <div class="muted small">{{ now()->toDateString() }}</div>
              </div>

              {{-- student name/avatar removed (not used) --}}
            </div>
            <div>
              @if($attendance && $attendance->checkin_at)
                <span class="badge bg-success small-pill">Masuk: {{ $attendance->checkin_at->format('H:i:s') }}</span>
              @else
                <span class="badge bg-warning text-dark small-pill">Belum absen pagi</span>
              @endif

              @if($attendance && $attendance->checkout_at)
                <span class="badge bg-info small-pill ms-2">Pulang: {{ $attendance->checkout_at->format('H:i:s') }}</span>
              @endif
            </div>
          </div>

          <div class="mb-4">
            <strong>Status:</strong>
            @if($attendance && $attendance->checkin_at)
              <span class="badge bg-success">Masuk: {{ $attendance->checkin_at->format('H:i:s') }}</span>
            @else
              <span class="badge bg-warning text-dark">Belum absen pagi</span>
            @endif

            @if($attendance && $attendance->checkout_at)
              <span class="badge bg-info">Pulang: {{ $attendance->checkout_at->format('H:i:s') }}</span>
            @endif
          </div>

          <div class="row">
            <div class="col-md-6">
              <form method="POST" action="{{ route('attendances.checkin') }}" enctype="multipart/form-data" id="checkin-form">
                @csrf
                <div class="mb-2">
                  <label class="form-label">Lokasi (opsional)</label>
                  <input type="text" name="checkin_location" class="form-control">
                </div>
                <div class="mb-2">
                  <label class="form-label">Foto Selfie</label>
                  <input type="file" name="checkin_photo" class="form-control" id="checkin_photo">
                </div>
                <div class="mb-3">
                  <img id="preview_photo" src="" alt="Preview" class="img-fluid rounded" style="display:none; max-height:200px;">
                </div>
                <button class="btn btn-success">Absen Pagi</button>
              </form>
            </div>

            <div class="col-md-6">
              <form method="POST" action="{{ route('attendances.checkout') }}" id="checkout-form">
                @csrf
                <div class="mb-2">
                  <label class="form-label">Laporan Pekerjaan Hari Ini</label>
                  <textarea name="checkout_report" class="form-control" rows="3"></textarea>
                </div>
                <div class="d-flex gap-2">
                  <button class="btn btn-primary">Absen Pulang</button>
                  <button type="button" class="btn btn-outline-secondary" onclick="document.querySelector('#checkout-form textarea').value='Sudah menyelesaikan tugas A, B dan menyiapkan laporan.'">Contoh Laporan</button>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  <script>
    const photoInput = document.getElementById('checkin_photo');
    const preview = document.getElementById('preview_photo');
    if (photoInput) {
      photoInput.addEventListener('change', e => {
        const file = e.target.files[0];
        if (!file) { preview.style.display = 'none'; preview.src = ''; return; }
        preview.src = URL.createObjectURL(file);
        preview.style.display = 'block';
      });
    }
  </script>
@endsection
