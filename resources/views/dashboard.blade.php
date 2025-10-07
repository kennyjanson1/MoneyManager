{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <div class="min-h-screen py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header Welcome --}}
        <div class="gradient-card rounded-3xl shadow-2xl p-6 mb-8 fade-in">
            <div class="flex justify-between items-center">
                <!-- Halo Admin Test (center) -->
                <h1 class="text-3xl font-bold text-gray-800 text-center flex-1">
                    Halo, <span class="text-green-600">{{ auth()->user()->name }}</span>! 👋
                </h1>

                <!-- Tanggal di kanan -->
                <p class="text-gray-600 whitespace-nowrap">
                    {{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}
                </p>
            </div>
        </div>
            {{-- Summary Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                {{-- Balance Card --}}
                <div class="balance-card rounded-3xl shadow-2xl p-6 transform transition hover:scale-105 fade-in">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="text-sm opacity-90 mb-2">💼 Total Saldo</div>
                            <div class="text-4xl font-bold">
                                Rp {{ number_format($balance, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="text-5xl">💰</div>
                    </div>
                    <div class="text-sm opacity-75 mt-4">Saldo Akhir Anda</div>
                </div>

                {{-- Income Card --}}
                <div class="income-card rounded-3xl shadow-2xl p-6 transform transition hover:scale-105 fade-in" style="animation-delay: 0.1s">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="text-sm opacity-90 mb-2">📈 Total Pemasukan</div>
                            <div class="text-4xl font-bold">
                                Rp {{ number_format($totalIncome, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="text-5xl">💵</div>
                    </div>
                    <div class="text-sm opacity-75 mt-4">Bulan Ini: Rp {{ number_format($monthlyIncome, 0, ',', '.') }}</div>
                </div>

                {{-- Expense Card --}}
                <div class="expense-card rounded-3xl shadow-2xl p-6 transform transition hover:scale-105 fade-in" style="animation-delay: 0.2s">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <div class="text-sm opacity-90 mb-2">📉 Total Pengeluaran</div>
                            <div class="text-4xl font-bold">
                                Rp {{ number_format($totalExpense, 0, ',', '.') }}
                            </div>
                        </div>
                        <div class="text-5xl">💸</div>
                    </div>
                    <div class="text-sm opacity-75 mt-4">Bulan Ini: Rp {{ number_format($monthlyExpense, 0, ',', '.') }}</div>
                </div>
            </div>

            {{-- Add Transaction Button --}}
            <div class="mb-8">
                <a href="{{ route('transactions.create') }}" 
                    class="btn-gradient inline-flex items-center px-8 py-4 rounded-2xl font-bold text-lg shadow-xl transform transition hover:scale-105">
                    ➕ Tambah Transaksi Hari Ini
                </a>
            </div>

            {{-- Chart Section --}}
            <div class="gradient-card rounded-3xl shadow-2xl p-6 mb-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-6">📊 Grafik 6 Bulan Terakhir</h3>
                <div class="bg-white rounded-2xl p-4">
                    <canvas id="transactionChart" class="w-full" height="80"></canvas>
                </div>
            </div>

            {{-- Recent Transactions --}}
            <div class="gradient-card rounded-3xl shadow-2xl p-6">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-2xl font-bold text-gray-800">📜 Transaksi Terbaru</h3>
                    <a href="{{ route('transactions.index') }}" 
                        class="text-purple-600 hover:text-purple-800 font-semibold flex items-center">
                        Lihat Semua 
                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
                
                @if($recentTransactions->isEmpty())
                    <div class="text-center py-16">
                        <div class="text-7xl mb-4">📭</div>
                        <p class="text-gray-500 text-lg mb-4">Belum ada transaksi</p>
                        <a href="{{ route('transactions.create') }}" 
                            class="btn-gradient inline-block px-6 py-3 rounded-xl font-semibold">
                            Tambah Transaksi Pertama
                        </a>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($recentTransactions as $transaction)
                            <div class="transaction-item rounded-2xl p-5 flex justify-between items-center border border-gray-100">
                                <div class="flex items-center">
                                    <div class="w-14 h-14 rounded-xl {{ $transaction->type == 'income' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center text-3xl mr-4">
                                        {{ $transaction->category->icon }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-800 text-lg">{{ $transaction->category->name }}</div>
                                        <div class="text-sm text-gray-500">
                                            {{ $transaction->transaction_date->format('d M Y') }}
                                        </div>
                                        @if($transaction->description)
                                            <div class="text-sm text-gray-400 mt-1">{{ $transaction->description }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-xl {{ $transaction->type == 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $transaction->type == 'income' ? '+' : '-' }} Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('transactionChart');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($chartData->pluck('month')->map(function($m) {
                    return \Carbon\Carbon::parse($m . '-01')->isoFormat('MMM YYYY');
                })) !!},
                datasets: [
                    {
                        label: 'Pemasukan',
                        data: {!! json_encode($chartData->pluck('income')) !!},
                        borderColor: 'rgb(16, 185, 129)',
                        backgroundColor: 'rgba(16, 185, 129, 0.1)',
                        tension: 0.4,
                        borderWidth: 3,
                        fill: true
                    },
                    {
                        label: 'Pengeluaran',
                        data: {!! json_encode($chartData->pluck('expense')) !!},
                        borderColor: 'rgb(239, 68, 68)',
                        backgroundColor: 'rgba(239, 68, 68, 0.1)',
                        tension: 0.4,
                        borderWidth: 3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                size: 14,
                                weight: 'bold'
                            },
                            padding: 20
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        titleFont: {
                            size: 14
                        },
                        bodyFont: {
                            size: 13
                        },
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                label += 'Rp ' + context.parsed.y.toLocaleString('id-ID');
                                return label;
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>
    @endpush
</x-app-layout>