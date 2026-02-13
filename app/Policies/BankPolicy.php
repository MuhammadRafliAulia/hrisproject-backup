<?php

namespace App\Policies;

use App\Models\Bank;
use App\Models\User;

class BankPolicy
{
    /**
     * Superadmin & recruitmentteam share access to each other's banks.
     */
    private function isSharedAccess(User $user, Bank $bank): bool
    {
        $sharedRoles = ['superadmin', 'recruitmentteam'];
        if (!in_array($user->role, $sharedRoles)) {
            return false;
        }
        $bankOwner = User::find($bank->user_id);
        return $bankOwner && in_array($bankOwner->role, $sharedRoles);
    }

    public function update(User $user, Bank $bank): bool
    {
        return $user->id === $bank->user_id || $this->isSharedAccess($user, $bank);
    }

    public function delete(User $user, Bank $bank): bool
    {
        return $user->id === $bank->user_id || $this->isSharedAccess($user, $bank);
    }

    public function view(User $user, Bank $bank): bool
    {
        return $user->id === $bank->user_id || $this->isSharedAccess($user, $bank);
    }
}
