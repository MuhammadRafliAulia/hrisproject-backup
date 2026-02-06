<?php

namespace App\Policies;

use App\Models\Bank;
use App\Models\User;

class BankPolicy
{
    public function update(User $user, Bank $bank): bool
    {
        return $user->id === $bank->user_id;
    }

    public function delete(User $user, Bank $bank): bool
    {
        return $user->id === $bank->user_id;
    }

    public function view(User $user, Bank $bank): bool
    {
        return $user->id === $bank->user_id;
    }
}
