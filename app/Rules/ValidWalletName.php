<?php
namespace App\Rules;

use App\Models\User;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ValidWalletName implements Rule
{
    public function passes($attribute, $value)
    {
        $userWallets = Auth::user()->wallets;

        if ($userWallets->isNotEmpty()) {
            foreach ($userWallets as $wallet) {
                if ($value === $wallet->name) {
                    return false;
                }
            }
        }

        return true;
    }

    public function message()
    {
        return 'Choose different wallet name.';
    }
}
