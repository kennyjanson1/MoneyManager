<?php
// database/seeders/CategorySeeder.php
// Buat dulu: php artisan make:seeder CategorySeeder

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            // Income Categories
            ['name' => 'Gaji', 'type' => 'income', 'icon' => '💰', 'color' => '#10b981'],
            ['name' => 'Bonus', 'type' => 'income', 'icon' => '🎁', 'color' => '#3b82f6'],
            ['name' => 'Investasi', 'type' => 'income', 'icon' => '📈', 'color' => '#8b5cf6'],
            ['name' => 'Lainnya', 'type' => 'income', 'icon' => '💵', 'color' => '#06b6d4'],
            
            // Expense Categories
            ['name' => 'Makanan & Minuman', 'type' => 'expense', 'icon' => '🍔', 'color' => '#ef4444'],
            ['name' => 'Transportasi', 'type' => 'expense', 'icon' => '🚗', 'color' => '#f59e0b'],
            ['name' => 'Belanja', 'type' => 'expense', 'icon' => '🛒', 'color' => '#ec4899'],
            ['name' => 'Hiburan', 'type' => 'expense', 'icon' => '🎮', 'color' => '#a855f7'],
            ['name' => 'Tagihan', 'type' => 'expense', 'icon' => '📱', 'color' => '#6366f1'],
            ['name' => 'Kesehatan', 'type' => 'expense', 'icon' => '🏥', 'color' => '#14b8a6'],
            ['name' => 'Pendidikan', 'type' => 'expense', 'icon' => '📚', 'color' => '#0ea5e9'],
            ['name' => 'Lainnya', 'type' => 'expense', 'icon' => '💸', 'color' => '#64748b'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}