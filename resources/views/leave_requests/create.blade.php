@extends('layouts.app')
@section('title','Ajukan Ketidakhadiran')
@section('content')
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="card app-card border-0 p-4 hover-lift">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Ajukan Ketidakhadiran</h4>
            <small class="muted">Isi formulir berikut</small>
          </div>
          <form method="POST" action="{{ route('leave_requests.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
              <label class="form-label">Tipe</label>
              <select name="type" class="form-select" required>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
                <option value="cuti">Cuti</option>
              </select>
            </div>
            <div class="row">
              <div class="mb-3 col-md-6">
                <label class="form-label">Mulai</label>
                <input type="date" name="start_date" class="form-control" required>
              </div>
              <div class="mb-3 col-md-6">
                <label class="form-label">Selesai</label>
                <input type="date" name="end_date" class="form-control">
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Alasan</label>
              <textarea name="reason" rows="3" class="form-control"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Bukti (opsional)</label>
              <input type="file" name="proof_file" class="form-control">
            </div>
            <div class="d-flex gap-2">
              <button class="btn btn-primary">Kirim Pengajuan</button>
              <a href="{{ route('leave_requests.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
