@extends('layouts.app')
@section('title','Pengajuan Ketidakhadiran')
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card app-card p-3 border-0 hover-lift">
        <div class="card-body">
          <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Pengajuan Ketidakhadiran</h4>
            <a href="{{ route('leave_requests.create') }}" class="btn btn-success btn-sm">Ajukan Baru</a>
          </div>

          <div class="table-responsive">
            <table class="table table-sm table-hover align-middle">
            <thead>
              <tr>
                <th>User</th>
                <th>Tipe</th>
                <th>Periode</th>
                <th>Status</th>
                <th>Bukti</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              @foreach($requests as $r)
                <tr>
                  <td>{{ $r->user->name }}<br><small>{{ $r->user->email }}</small></td>
                  <td>{{ ucfirst($r->type) }}</td>
                  <td>{{ $r->start_date->toDateString() }} @if($r->end_date) - {{ $r->end_date->toDateString() }}@endif</td>
                  <td><span class="badge bg-{{ $r->status === 'approved' ? 'success' : ($r->status === 'rejected' ? 'danger' : 'secondary') }}">{{ $r->status }}</span></td>
                  <td>@if($r->proof_file)<a href="{{ asset('storage/'.$r->proof_file) }}" target="_blank">lihat</a>@endif</td>
                  <td>
                    @if(auth()->user()->isAdmin())
                      <form action="{{ route('leave_requests.updateStatus', $r) }}" method="POST">
                        @csrf
                        <select name="status" class="form-select form-select-sm d-inline-block w-auto">
                          <option value="pending" @if($r->status==='pending') selected @endif>pending</option>
                          <option value="approved" @if($r->status==='approved') selected @endif>approved</option>
                          <option value="rejected" @if($r->status==='rejected') selected @endif>rejected</option>
                        </select>
                        <button class="btn btn-sm btn-primary">Ubah</button>
                      </form>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
          </div>
          <div class="mt-3 d-flex justify-content-end">{{ $requests->links() }}</div>
        </div>
      </div>
    </div>
  </div>
@endsection
