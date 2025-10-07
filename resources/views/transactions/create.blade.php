{{-- resources/views/transactions/create.blade.php --}}
<x-app-layout>
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Header --}}
            <div class="gradient-card rounded-3xl shadow-2xl p-6 mb-8">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" 
                        class="text-purple-600 hover:text-purple-800 mr-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                    </a>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800">💸 Tambah Transaksi Baru</h1>
                        <p class="text-gray-600 mt-1">Catat pemasukan atau pengeluaran Anda hari ini</p>
                    </div>
                </div>
            </div>

            {{-- Form Card --}}
            <div class="gradient-card rounded-3xl shadow-2xl p-8">
                
                {{-- Error Messages --}}
                @if ($errors->any())
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-xl mb-6">
                        <div class="flex items-center mb-2">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            <strong>Oops! Ada kesalahan:</strong>
                        </div>
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('transactions.store') }}" class="space-y-6">
                    @csrf

                    {{-- Type Selection --}}
                    <div>
                        <label class="block text-gray-700 font-bold mb-3 text-lg">
                            🎯 Tipe Transaksi
                        </label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="income" class="peer hidden" 
                                    {{ old('type') == 'income' ? 'checked' : '' }} required>
                                <div class="border-2 border-gray-300 peer-checked:border-green-500 peer-checked:bg-green-50 rounded-2xl p-6 text-center transition transform hover:scale-105">
                                    <div class="text-5xl mb-3">💰</div>
                                    <div class="font-bold text-lg text-gray-800">Pemasukan</div>
                                    <div class="text-sm text-gray-600 mt-1">Income / Gaji / Bonus</div>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="type" value="expense" class="peer hidden" 
                                    {{ old('type') == 'expense' ? 'checked' : '' }} required>
                                <div class="border-2 border-gray-300 peer-checked:border-red-500 peer-checked:bg-red-50 rounded-2xl p-6 text-center transition transform hover:scale-105">
                                    <div class="text-5xl mb-3">💸</div>
                                    <div class="font-bold text-lg text-gray-800">Pengeluaran</div>
                                    <div class="text-sm text-gray-600 mt-1">Expense / Belanja</div>
                                </div>
                            </label>
                        </div>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label for="category_id" class="block text-gray-700 font-bold mb-3 text-lg">
                            🏷️ Kategori
                        </label>
                        <select name="category_id" id="category_id" required
                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-lg">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->icon }} {{ $category->name }} ({{ ucfirst($category->type) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Amount --}}
                    <div>
                        <label for="amount" class="block text-gray-700 font-bold mb-3 text-lg">
                            💵 Jumlah
                        </label>
                        <input type="number" name="amount" id="amount" value="{{ old('amount') }}" required
                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-lg"
                            placeholder="Masukkan jumlah (Rp)">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-gray-700 font-bold mb-3 text-lg">
                            📝 Deskripsi
                        </label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-lg"
                            placeholder="Tambahkan catatan transaksi">{{ old('description') }}</textarea>
                    </div>

                    {{-- Date --}}
                    <div>
                        <label for="date" class="block text-gray-700 font-bold mb-3 text-lg">
                            📅 Tanggal
                        </label>
                        <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                            class="w-full px-4 py-4 border-2 border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent text-lg">
                    </div>

                    {{-- Submit Button --}}
                    <div class="flex justify-end">
                        <button type="submit"
                            class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-6 rounded-2xl shadow-lg transition transform hover:scale-105">
                            ✅ Simpan Transaksi
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
```
