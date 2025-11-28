<!doctype html>
<html>
  <head>
    <meta charset="utf-8" />
    <style>
      body { font-family: DejaVu Sans, sans-serif; }
      table { width:100%; border-collapse: collapse; }
      th, td { border:1px solid #333; padding:6px; font-size:12px }
      th { background:#efefef }
    </style>
  </head>
  <body>
    <h3>Laporan Absensi</h3>
    <table>
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Nama</th>
          <th>Email</th>
          <th>Masuk</th>
          <th>Pulang</th>
          <th>Lokasi</th>
          <th>Laporan</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rows as $r)
        <tr>
          <td>{{ $r->date->toDateString() }}</td>
          <td>{{ $r->user->name }}</td>
          <td>{{ $r->user->email }}</td>
          <td>{{ optional($r->checkin_at)->toDateTimeString() }}</td>
          <td>{{ optional($r->checkout_at)->toDateTimeString() }}</td>
          <td>{{ $r->checkin_location }}</td>
          <td>{{ $r->checkout_report }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </body>
</html>
