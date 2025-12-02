<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $attendances = $user->attendances()->latest('date')->paginate(15);
        return view('attendances.index', compact('attendances'));
    }

    public function today()
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::firstOrNew(['user_id'=>$user->id,'date'=>$today]);
        return view('attendances.today', compact('attendance'));
    }

    public function checkin(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::firstOrCreate(
            ['user_id' => $user->id, 'date' => $today],
            ['checkin_at' => now()]
        );

        if ($attendance->checkin_at && $attendance->wasRecentlyCreated === false) {
            // already checked in
            return back()->with('info', 'Anda sudah melakukan absen pagi.');
        }

        if ($request->hasFile('checkin_photo')) {
            $path = $request->file('checkin_photo')->store('attendances', 'public');
            $attendance->checkin_photo = $path;
        }

        $attendance->checkin_at = now();
        if ($request->filled('checkin_location')) {
            $attendance->checkin_location = $request->input('checkin_location');
        }
        $attendance->save();

        return back()->with('success', 'Check-in berhasil pada '.now());
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $attendance = Attendance::where('user_id',$user->id)->where('date',$today)->first();

        if (! $attendance) {
            return back()->withErrors(['error'=>'Anda belum melakukan check-in hari ini']);
        }

        if ($attendance->checkout_at) {
            return back()->with('info', 'Anda sudah melakukan absen pulang.');
        }

        if ($request->filled('checkout_report')) {
            $attendance->checkout_report = $request->input('checkout_report');
        }

        $attendance->checkout_at = now();
        $attendance->save();

        return redirect()->route('attendances.index')->with('success', 'Check-out berhasil.');
    }
}
