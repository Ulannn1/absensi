@extends('layouts.app')
@section('title','Riwayat Absensi')
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card app-card p-3 border-0 hover-lift">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
              <h4 class="card-title mb-0">Riwayat Absensi</h4>
              {{-- user name removed per request --}}
            </div>
            <div class="d-flex gap-2 align-items-center">
              <input type="search" class="form-control form-control-sm" placeholder="Cari tanggal, nama..." style="width:220px">
              <a class="btn btn-outline-secondary btn-sm" href="#">Export</a>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table table-hover align-middle">
            <thead>
              <tr>
                  <th>Tanggal</th>
                  <th>Masuk</th>
                  <th>Pulang</th>
                  <th>Lokasi</th>
                  <th>Laporan</th>
                </tr>
            </thead>
            <tbody>
              @foreach($attendances as $a)
                <tr>
                  <td class="fw-semibold">{{ $a->date->toDateString() }}</td>
                  <td>{{ optional($a->checkin_at)->format('H:i:s') }}</td>
                  <td>{{ optional($a->checkout_at)->format('H:i:s') }}</td>
                  <td class="muted small">{{ $a->checkin_location }}</td>
                  <td>{{ Str::limit($a->checkout_report, 80) }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
          </div>
          <div class="mt-3 d-flex justify-content-end">{{ $attendances->links() }}</div>
        </div>
      </div>
    </div>
  </div>
@endsection
