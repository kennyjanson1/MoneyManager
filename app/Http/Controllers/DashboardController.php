<?php
namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Saldo total
        $totalIncome = $user->transactions()->income()->sum('amount');
        $totalExpense = $user->transactions()->expense()->sum('amount');
        $balance = $totalIncome - $totalExpense;

        // Data bulan ini
        $monthlyIncome = $user->transactions()->income()->thisMonth()->sum('amount');
        $monthlyExpense = $user->transactions()->expense()->thisMonth()->sum('amount');

        // Transaksi terbaru
        $recentTransactions = $user->transactions()
            ->with('category')
            ->orderBy('transaction_date', 'desc')
            ->limit(5)
            ->get();

        // Ambil filter period dari request (default: monthly)
        $period = request()->get('period', 'monthly');

        // Tentukan grouping berdasarkan period
        if ($period === 'yearly') {
            $chartData = Transaction::where('user_id', $user->id)
                ->select(
                    DB::raw('YEAR(transaction_date) as period'),
                    DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                    DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
                )
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        } elseif ($period === 'weekly') {
            $chartData = Transaction::where('user_id', $user->id)
                ->select(
                    DB::raw('YEARWEEK(transaction_date, 1) as period'),
                    DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                    DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
                )
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        } elseif ($period === 'daily') {
            $chartData = Transaction::where('user_id', $user->id)
                ->select(
                    DB::raw('DATE(transaction_date) as period'),
                    DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                    DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
                )
                ->where('transaction_date', '>=', now()->subDays(30)) // ambil 30 hari terakhir
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        } else { // default monthly
            $chartData = Transaction::where('user_id', $user->id)
                ->select(
                    DB::raw('DATE_FORMAT(transaction_date, "%Y-%m") as period'),
                    DB::raw('SUM(CASE WHEN type = "income" THEN amount ELSE 0 END) as income'),
                    DB::raw('SUM(CASE WHEN type = "expense" THEN amount ELSE 0 END) as expense')
                )
                ->where('transaction_date', '>=', now()->subMonths(6))
                ->groupBy('period')
                ->orderBy('period')
                ->get();
        }

        // Donut Chart: Expenses by Category
        $expensesByCategory = Transaction::where('user_id', $user->id)
            ->where('type', 'expense')
            ->select('category_id', DB::raw('SUM(amount) as total'))
            ->with('category')
            ->groupBy('category_id')
            ->get()
            ->map(function ($item) {
                return [
                    'label' => $item->category->name ?? 'Unknown',
                    'value' => $item->total,
                ];
            });

        return view('dashboard', compact(
            'balance',
            'totalIncome',
            'totalExpense',
            'monthlyIncome',
            'monthlyExpense',
            'recentTransactions',
            'chartData',
            'expensesByCategory',
            'period' // biar view tahu filter aktif
        ));
    }
}
