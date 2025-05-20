<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Student;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Category;
use App\Models\TransferRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $books = Book::count();
        $students = Student::count();
        $authors = Author::count();
        $publishers = Publisher::count();
        $categories = Category::count();

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

        return view('dashboard', compact(
            'books',
            'students',
            'authors',
            'publishers',
            'categories',
            'pendingTransfers',
            'acceptedTransfers',
            'rejectedTransfers',
            'totalTransfers',
            'departmentStats',
            'specializationStats',
            'facultyStats',
            'monthlyStats'
        ));
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