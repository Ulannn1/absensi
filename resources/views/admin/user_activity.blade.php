@extends('layouts.admin')
@section('title','Aktivitas User')
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card app-card p-3 border-0 hover-lift">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Aktivitas {{ $user->name }}</h4>
            <div class="muted small">Total: {{ $attendances->total() }}</div>
          </div>
          <div class="table-responsive">
            <table class="table table-sm table-hover align-middle">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Masuk</th>
                <th>Pulang</th>
                <th>Laporan</th>
              </tr>
            </thead>
            <tbody>
              @foreach($attendances as $a)
                <tr>
                  <td>{{ $a->date->toDateString() }}</td>
                  <td>{{ optional($a->checkin_at)->format('H:i:s') }}</td>
                  <td>{{ optional($a->checkout_at)->format('H:i:s') }}</td>
                  <td>{{ Str::limit($a->checkout_report, 120) }}</td>
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
