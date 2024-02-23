<?php
namespace App\Rules;

use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class ValidReceiver implements Rule
{
    public function passes($attribute, $value)
    {
        return Wallet::where('wallet_number', $value)->exists();
    }

    public function message()
    {
        return 'Wallet number does not match existing wallet.';
    }
}
