<?php

namespace App\Http\Controllers;

use App\Http\Requests\changePasswordRequest;
use App\Models\auther;
use App\Models\book;
use App\Models\book_issue;
use App\Models\category;
use App\Models\publisher;
use App\Models\student;
use App\Models\TransferRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class dashboardController extends Controller
{
    public function index()
    {
        $books = book::count();
        $students = student::count();
        $authors = auther::count();
        $publishers = publisher::count();
        $categories = category::count();

        // Get the transfer request for the current user
        $transfer_request = null;
        if (auth()->check()) {
            $transfer_request = TransferRequest::where('student_id', auth()->id())
                ->latest()
                ->first();
        }

        // Transfer Statistics
        $pendingTransfers = TransferRequest::where('status', 'pending')->count();
        $acceptedTransfers = TransferRequest::where('status', 'accepted')->count();
        $rejectedTransfers = TransferRequest::where('status', 'rejected')->count();
        $totalTransfers = TransferRequest::count();

        // Department Statistics
        $departmentStats = TransferRequest::selectRaw('current_department as name, count(*) as count')
            ->groupBy('current_department')
            ->get();

        // Specialization Statistics
        $specializationStats = TransferRequest::selectRaw('current_specialization as name, count(*) as count')
            ->groupBy('current_specialization')
            ->get();

        // Faculty Statistics
        $facultyStats = TransferRequest::selectRaw('current_faculty as name, count(*) as count')
            ->groupBy('current_faculty')
            ->get();

        // Monthly Statistics with status breakdown
        $monthlyStats = TransferRequest::selectRaw('
                DATE_FORMAT(created_at, "%Y-%m") as month,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = "accepted" THEN 1 ELSE 0 END) as accepted_count,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_count,
                COUNT(*) as total_count
            ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $data = [
            'books' => $books,
            'students' => $students,
            'authors' => $authors,
            'publishers' => $publishers,
            'categories' => $categories,
            'issued_books' => book_issue::count(),
            'pendingTransfers' => $pendingTransfers,
            'acceptedTransfers' => $acceptedTransfers,
            'rejectedTransfers' => $rejectedTransfers,
            'totalTransfers' => $totalTransfers,
            'departmentStats' => $departmentStats,
            'specializationStats' => $specializationStats,
            'facultyStats' => $facultyStats,
            'monthlyStats' => $monthlyStats,
            'transfer_request' => $transfer_request,
        ];

        // Ajouter les statistiques des demandes de transfert pour les administrateurs
        if (auth()->user()->user_type == 'admin') {
            $data['pendingTransfers'] = TransferRequest::where('status', 'pending')->count();
            $data['acceptedTransfers'] = TransferRequest::where('status', 'accepted')->count();
        }

        return view('dashboard', $data);
    }

    public function change_password_view()
    {
        return view('reset_password');
    }

    public function change_password(Request $request)
    {
        $request->validate([
            'c_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = Auth::user();

        if (password_verify($request->c_password, $user->password)) {
            $user->password = bcrypt($request->password);
            $user->save();
            return redirect()->route("dashboard")->with('success', 'Password changed successfully');
        } else {
            return redirect()->back()->withErrors(['c_password' => 'Old password is incorrect']);
        }
    }

    public function filter(Request $request)
    {
        $query = TransferRequest::query();

        // Apply date range filter
        if ($request->dateRange !== 'all') {
            $now = Carbon::now();
            switch ($request->dateRange) {
                case 'month':
                    $query->where('created_at', '>=', $now->subMonth());
                    break;
                case 'quarter':
                    $query->where('created_at', '>=', $now->subQuarter());
                    break;
                case 'year':
                    $query->where('created_at', '>=', $now->subYear());
                    break;
            }
        }

        // Apply faculty filter
        if ($request->faculty !== 'all') {
            $query->where('current_faculty', $request->faculty);
        }

        // Apply department filter
        if ($request->department !== 'all') {
            $query->where('current_department', $request->department);
        }

        // Apply status filter
        if ($request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Get filtered statistics
        $departmentStats = $query->selectRaw('current_department as name, count(*) as count')
            ->groupBy('current_department')
            ->get();

        $specializationStats = $query->selectRaw('current_specialization as name, count(*) as count')
            ->groupBy('current_specialization')
            ->get();

        $facultyStats = $query->selectRaw('current_faculty as name, count(*) as count')
            ->groupBy('current_faculty')
            ->get();

        $monthlyStats = $query->selectRaw('
                DATE_FORMAT(created_at, "%Y-%m") as month,
                SUM(CASE WHEN status = "pending" THEN 1 ELSE 0 END) as pending_count,
                SUM(CASE WHEN status = "accepted" THEN 1 ELSE 0 END) as accepted_count,
                SUM(CASE WHEN status = "rejected" THEN 1 ELSE 0 END) as rejected_count,
                COUNT(*) as total_count
            ')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $statusStats = [
            'pending' => $query->where('status', 'pending')->count(),
            'accepted' => $query->where('status', 'accepted')->count(),
            'rejected' => $query->where('status', 'rejected')->count()
        ];

        return response()->json([
            'departmentStats' => $departmentStats,
            'specializationStats' => $specializationStats,
            'facultyStats' => $facultyStats,
            'monthlyStats' => $monthlyStats,
            'statusStats' => $statusStats
        ]);
    }
}
