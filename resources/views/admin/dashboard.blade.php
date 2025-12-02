@extends('layouts.admin')
@section('title','Admin - Dashboard')
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card app-card p-3 border-0 hover-lift">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4>Rekap Absensi</h4>
            <div>
              <form method="GET" class="d-inline-block me-2">
                <input type="date" name="date" class="form-control form-control-sm d-inline-block" value="{{ request('date') }}">
              </form>
              <a href="{{ route('admin.export', request()->only('date')) }}" class="btn btn-sm btn-outline-success me-2">Export CSV</a>
              <a href="{{ route('admin.export.pdf', request()->only('date')) }}" class="btn btn-sm btn-outline-secondary">Export PDF</a>
            </div>
          </div>

          {{-- Ringkasan will show in the sidebar (ke samping) --}}

          <div class="table-responsive">
            <table class="table table-sm table-hover align-middle">
            <thead>
              <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Masuk</th>
                <th>Pulang</th>
                <th>Lokasi</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach($attendances as $a)
                <tr>
                  <td>{{ $a->date->toDateString() }}</td>
                  <td><a href="{{ route('admin.user.activity', $a->user->id) }}">{{ $a->user->name }}</a></td>
                  <td>{{ $a->user->email }}</td>
                  <td>{{ optional($a->checkin_at)->format('H:i:s') }}</td>
                  <td>{{ optional($a->checkout_at)->format('H:i:s') }}</td>
                  <td>{{ $a->checkin_location }}</td>
                  <td><button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#detailModal" data-id="{{ $a->id }}" data-date="{{ $a->date->toDateString() }}" data-name="{{ $a->user->name }}" data-checkin="{{ optional($a->checkin_at)->format('H:i:s') }}" data-checkout="{{ optional($a->checkout_at)->format('H:i:s') }}" data-location="{{ $a->checkin_location }}" data-report="{{ $a->checkout_report }}">Lihat</button></td>
                </tr>
              @endforeach
            </tbody>
            </table>
          </div>
          <div class="mt-3 d-flex justify-content-between align-items-center">
            <div class="muted small">Menampilkan {{ $attendances->count() }} entri</div>
            <div>{{ $attendances->links() }}</div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <!-- Modal Detail Absensi -->
  <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content border-0">
        <div class="modal-header border-bottom">
          <h5 class="modal-title fw-bold" id="detailModalLabel">Detail Absensi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted">Nama</label>
            <div id="modalName" class="form-control-plaintext"></div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted">Tanggal</label>
            <div id="modalDate" class="form-control-plaintext"></div>
          </div>
          <div class="row mb-3">
            <div class="col-6">
              <label class="form-label fw-bold small text-muted">Waktu Masuk</label>
              <div id="modalCheckin" class="form-control-plaintext"></div>
            </div>
            <div class="col-6">
              <label class="form-label fw-bold small text-muted">Waktu Pulang</label>
              <div id="modalCheckout" class="form-control-plaintext"></div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted">Lokasi</label>
            <div id="modalLocation" class="form-control-plaintext"></div>
          </div>
          <div class="mb-0">
            <label class="form-label fw-bold small text-muted">Laporan Pulang</label>
            <div id="modalReport" class="form-control-plaintext" style="max-height:150px; overflow-y:auto;"></div>
          </div>
        </div>
        <div class="modal-footer border-top">
          <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Tutup</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    document.getElementById('detailModal').addEventListener('show.bs.modal', function(event) {
      const button = event.relatedTarget;
      document.getElementById('modalName').textContent = button.getAttribute('data-name');
      document.getElementById('modalDate').textContent = button.getAttribute('data-date');
      document.getElementById('modalCheckin').textContent = button.getAttribute('data-checkin') || '-';
      document.getElementById('modalCheckout').textContent = button.getAttribute('data-checkout') || '-';
      document.getElementById('modalLocation').textContent = button.getAttribute('data-location') || '-';
      document.getElementById('modalReport').textContent = button.getAttribute('data-report') || '-';
    });
  </script>
@endsection

@section('sidebar')
  <div class="card shadow-sm mb-3 border-0">
    <div class="card-body">
      <h6 class="mb-2 fw-bold">Ringkasan</h6>
      <div class="mb-3">
        <div class="d-flex justify-content-between align-items-center">
          <div class="muted small">Total pengguna</div>
          <div class="fw-bold">{{ $totalUsers ?? 0 }}</div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
          <div class="muted small">Absensi hari ini</div>
          <div class="fw-bold text-success">{{ $todayCount ?? 0 }}</div>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-2">
          <div class="muted small">Izin tertunda</div>
          <div class="fw-bold text-warning">{{ $pendingLeaves ?? 0 }}</div>
        </div>
      </div>

      <div class="d-grid gap-2">
        <a href="{{ route('admin.export') }}" class="btn btn-sm btn-outline-success">Export CSV</a>
        <a href="{{ route('admin.export.pdf') }}" class="btn btn-sm btn-outline-secondary">Export PDF</a>
        <a href="{{ route('leave_requests.index') }}" class="btn btn-sm btn-outline-primary">Lihat Permintaan Izin</a>
      </div>
    </div>
  </div>

  <div class="card border-0 shadow-sm">
    <div class="card-body small muted">
      <strong>Tips:</strong>
      <ul class="mb-0 ps-3 mt-2">
        <li>Gunakan filter tanggal untuk mengekspor data khusus.</li>
        <li>Klik nama pengguna untuk melihat aktivitas per pengguna.</li>
      </ul>
    </div>
  </div>
@endsection
