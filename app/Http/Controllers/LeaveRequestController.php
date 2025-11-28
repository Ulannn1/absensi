<?php

namespace App\Http\Controllers;

use App\Models\LeaveRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class LeaveRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if ($user->isAdmin()) {
            $requests = LeaveRequest::latest()->paginate(20);
        } else {
            $requests = $user->leaveRequests()->latest()->paginate(20);
        }
        return view('leave_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('leave_requests.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'type' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date',
            'reason' => 'nullable|string',
            'proof_file' => 'nullable|file|max:2048'
        ]);

        if ($request->hasFile('proof_file')) {
            $data['proof_file'] = $request->file('proof_file')->store('leave_proofs','public');
        }

        $data['user_id'] = Auth::id();
        $data['status'] = 'pending';

        LeaveRequest::create($data);

        return redirect()->route('leave_requests.index')->with('success', 'Pengajuan ketidakhadiran disimpan.');
    }

    public function updateStatus(LeaveRequest $leaveRequest, Request $request)
    {
        $request->validate(['status' => 'required|in:pending,approved,rejected']);
        $leaveRequest->status = $request->input('status');
        $leaveRequest->save();
        return back()->with('success', 'Status diubah.');
    }
}
