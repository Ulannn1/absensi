<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use App\Models\LeaveRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard(Request $request)
    {
        $query = Attendance::query();
        if ($request->filled('date')) {
            $query->where('date', $request->input('date'));
        }

        $attendances = $query->with('user')->latest('date')->paginate(25);

        // quick stats for sidebar
        $totalUsers = User::count();
        $todayCount = Attendance::where('date', Carbon::today()->toDateString())->count();
        $pendingLeaves = LeaveRequest::where('status', 'pending')->count();

        return view('admin.dashboard', compact('attendances','totalUsers','todayCount','pendingLeaves'));
    }

    public function exportCsv(Request $request)
    {
        $query = Attendance::query();
        if ($request->filled('date')) {
            $query->where('date', $request->input('date'));
        }

        $rows = $query->with('user')->orderBy('date','desc')->get();

        $filename = 'attendance_export_'.now()->format('Ymd_His').'.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$filename}",
        ];

        $columns = ['Date','Name','Email','Checkin At','Checkout At','Checkin Location','Report'];

        $callback = function() use ($rows, $columns) {
            $file = fopen('php://output','w');
            fputcsv($file, $columns);
            foreach ($rows as $r) {
                fputcsv($file, [
                    $r->date->toDateString(),
                    $r->user->name,
                    $r->user->email,
                    optional($r->checkin_at)->toDateTimeString(),
                    optional($r->checkout_at)->toDateTimeString(),
                    $r->checkin_location,
                    $r->checkout_report,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function exportPdf(Request $request)
    {
        $rows = Attendance::with('user')->orderBy('date','desc')->get();

        try {
            // Attempt to use barryvdh/laravel-dompdf if available
            $pdf = app('dompdf.wrapper');
            $html = view('admin.export_pdf', ['rows' => $rows])->render();
            $pdf->loadHTML($html);
            return $pdf->download('attendance_report_'.now()->format('Ymd_His').'.pdf');
        } catch (\Exception $e) {
            return back()->with('info', 'PDF export requires barryvdh/laravel-dompdf – run `composer require barryvdh/laravel-dompdf` to enable.');
        }
    }

    public function showUserActivity($userId, Request $request)
    {
        $user = \App\Models\User::findOrFail($userId);
        $attendances = $user->attendances()->latest('date')->paginate(25);
        return view('admin.user_activity', compact('user','attendances'));
    }
}
