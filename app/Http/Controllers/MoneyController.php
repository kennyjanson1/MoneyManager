<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

class MoneyController extends Controller
{
    public function index()
    {
        // Contoh data dummy
        $balance = 83172.64;
        $monthlyIncome = 16281.48;
        $monthlyExpense = 6638.72;

        // Chart data contoh (Jan–Dec)
        $chartData = collect([
            ['month' => '2025-01', 'income' => 12000, 'expense' => 7000],
            ['month' => '2025-02', 'income' => 14000, 'expense' => 6000],
            ['month' => '2025-03', 'income' => 13000, 'expense' => 8000],
            ['month' => '2025-04', 'income' => 15000, 'expense' => 7200],
            ['month' => '2025-05', 'income' => 16000, 'expense' => 6700],
            ['month' => '2025-06', 'income' => 16281.48, 'expense' => 6638.72],
        ]);

        $expensesByCategory = [
            ['label' => 'Entertainments', 'value' => 46],
            ['label' => 'Platform', 'value' => 56],
            ['label' => 'Shopping', 'value' => 48],
            ['label' => 'Food & Health', 'value' => 63],
        ];

        return view('dashboard', compact(
            'balance', 'monthlyIncome', 'monthlyExpense', 'chartData', 'expensesByCategory'
        ));
    }
}
