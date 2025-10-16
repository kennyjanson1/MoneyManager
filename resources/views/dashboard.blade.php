<x-app-layout>
<div class="min-h-screen py-8 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Good morning, 
                <span class="text-gray-900">{{ auth()->user()->name }}</span>
            </h1>
            <p class="text-gray-500 mt-1">This is your finance report</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column --}}
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Balance Card --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <p class="text-sm text-gray-500 mb-2">My balance</p>
                    <div class="flex items-baseline gap-3">
                        <h2 class="text-4xl font-bold text-gray-900">${{ number_format($balance, 2) }}</h2>
                        <span class="text-green-600 text-sm font-medium">
                            @php
                                $lastMonth = $totalIncome > 0 ? (($balance / $totalIncome) * 100) : 0;
                            @endphp
                            +{{ number_format($lastMonth, 1) }}% compare to last month
                        </span>
                    </div>
                    <p class="text-xs text-gray-400 mt-3">{{ $user->account_number ?? '6549 7329 9821 2472' }}</p>
                    
                    <div class="flex gap-3 mt-6">
                        <button class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            Send money
                        </button>
                        <button class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg text-sm font-medium transition-colors">
                            Request money
                        </button>
                    </div>
                </div>

                {{-- Income & Expense Cards --}}
                <div class="grid grid-cols-2 gap-6">
                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600">📈</span>
                            </div>
                            <p class="text-sm text-gray-600">Monthly income</p>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">${{ number_format($monthlyIncome, 2) }}</h3>
                        <p class="text-xs text-green-600 mt-2">+9,8% compare to last month</p>
                    </div>

                    <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                        <div class="flex items-center gap-2 mb-3">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                <span class="text-red-600">📉</span>
                            </div>
                            <p class="text-sm text-gray-600">Monthly expenses</p>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900">${{ number_format($monthlyExpense, 2) }}</h3>
                        <p class="text-xs text-red-600 mt-2">-8,6% compare to last month</p>
                    </div>
                </div>

                {{-- Statistics Chart --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-bold text-gray-900">Statistics</h3>
                            <div class="flex gap-4 mt-2">
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                                    <span class="text-xs text-gray-600">Total income</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <div class="w-3 h-3 bg-orange-400 rounded-full"></div>
                                    <span class="text-xs text-gray-600">Total expenses</span>
                                </div>
                            </div>
                        </div>

                        {{-- Period Filter --}}
                        <form method="GET" class="flex gap-2">
                            <select name="period" onchange="this.form.submit()" 
                                class="border border-gray-200 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                <option value="weekly" {{ $period == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                            </select>
                        </form>
                    </div>

                    <div class="h-72">
                        <canvas id="financeChart"></canvas>
                    </div>

                    {{-- Average Stats --}}
                    <div class="grid grid-cols-2 gap-6 mt-6 pt-6 border-t border-gray-100">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Average income</p>
                            <h4 class="text-2xl font-bold text-gray-900">
                                ${{ number_format($chartData->avg('income') ?? 0, 2) }}
                            </h4>
                            <p class="text-xs text-green-600 mt-1">+9,8% compare to last month</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Average expenses</p>
                            <h4 class="text-2xl font-bold text-gray-900">
                                ${{ number_format($chartData->avg('expense') ?? 0, 2) }}
                            </h4>
                            <p class="text-xs text-red-600 mt-1">+8,7% compare to last month</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Right Column --}}
            <div class="space-y-6">
                
                {{-- All Expenses Donut Chart --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-gray-900">All expenses</h3>
                        <div class="flex gap-2 text-xs">
                            <button class="px-3 py-1.5 rounded-lg bg-gray-100 text-gray-700 font-medium">Daily</button>
                            <button class="px-3 py-1.5 rounded-lg text-gray-500">Weekly</button>
                            <button class="px-3 py-1.5 rounded-lg text-gray-500">Monthly</button>
                        </div>
                    </div>

                    <div class="flex justify-center mb-6">
                        <div class="relative w-48 h-48">
                            <canvas id="expenseChart"></canvas>
                        </div>
                    </div>

                    {{-- Category List --}}
                    <div class="space-y-3">
                        @foreach($expensesByCategory->take(4) as $index => $category)
                        @php
                            $colors = ['bg-green-500', 'bg-red-500', 'bg-blue-400', 'bg-orange-400'];
                            $percentage = $expensesByCategory->sum('value') > 0 
                                ? ($category['value'] / $expensesByCategory->sum('value') * 100) 
                                : 0;
                        @endphp
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <div class="w-2 h-2 rounded-full {{ $colors[$index] ?? 'bg-gray-400' }}"></div>
                                <span class="text-sm text-gray-600">{{ $category['label'] }}</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-900">{{ number_format($percentage, 0) }}%</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- CTA Card --}}
                <div class="bg-gradient-to-br from-green-400 to-green-600 rounded-2xl shadow-sm p-6 text-white">
                    <h3 class="text-lg font-bold mb-2">Secure Your Future with Our Comprehensive Retirement Plans!</h3>
                    <p class="text-sm opacity-90 mb-4">Start planning for a comfortable retirement today.</p>
                    <button class="bg-white text-green-600 px-6 py-2.5 rounded-lg text-sm font-medium hover:bg-gray-50 transition-colors">
                        Learn more
                    </button>
                </div>

                {{-- Quick Actions --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border border-gray-100">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-2">
                        <a href="{{ route('transactions.create') }}" 
                           class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <span class="text-green-600">➕</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700">Add Transaction</span>
                        </a>
                        <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                <span class="text-blue-600">📊</span>
                            </div>
                            <span class="text-sm font-medium text-gray-700">View Reports</span>
                        </a>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Line Chart
    const ctx = document.getElementById('financeChart');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: {!! json_encode($chartData->pluck('period')) !!},
            datasets: [
                {
                    label: 'Income',
                    data: {!! json_encode($chartData->pluck('income')) !!},
                    borderColor: '#10b981',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#10b981',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                },
                {
                    label: 'Expenses',
                    data: {!! json_encode($chartData->pluck('expense')) !!},
                    borderColor: '#fb923c',
                    backgroundColor: 'transparent',
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#fb923c',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false
            },
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: '#1f2937',
                    padding: 12,
                    borderColor: '#374151',
                    borderWidth: 1,
                    titleColor: '#fff',
                    bodyColor: '#fff',
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': $' + new Intl.NumberFormat().format(context.raw);
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            size: 11
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f3f4f6'
                    },
                    ticks: {
                        color: '#9ca3af',
                        font: {
                            size: 11
                        },
                        callback: function(value) {
                            return '$' + new Intl.NumberFormat().format(value);
                        }
                    }
                }
            }
        }
    });

    // Doughnut Chart
    const ctx2 = document.getElementById('expenseChart');
    const expenseData = {!! json_encode(collect($expensesByCategory)->pluck('value')) !!};
    const total = expenseData.reduce((a, b) => a + b, 0);
    
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode(collect($expensesByCategory)->pluck('label')) !!},
            datasets: [{
                data: expenseData,
                backgroundColor: [
                    '#10b981',
                    '#ef4444', 
                    '#60a5fa',
                    '#fb923c',
                    '#8b5cf6',
                    '#f59e0b'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            cutout: '70%',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    enabled: true,
                    backgroundColor: '#1f2937',
                    padding: 12,
                    callbacks: {
                        label: function(context) {
                            const percentage = ((context.raw / total) * 100).toFixed(0);
                            return context.label + ': ' + percentage + '%';
                        }
                    }
                }
            }
        }
    });
</script>
@endpush
</x-app-layout>