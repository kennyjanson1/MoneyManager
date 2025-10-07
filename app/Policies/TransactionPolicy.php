<?php
// Buat Policy dulu: php artisan make:policy TransactionPolicy --model=Transaction

// app/Policies/TransactionPolicy.php
namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;

class TransactionPolicy
{
    public function update(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id;
    }

    public function delete(User $user, Transaction $transaction): bool
    {
        return $user->id === $transaction->user_id;
    }
}