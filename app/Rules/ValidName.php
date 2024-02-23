<?php
namespace App\Rules;

use App\Models\User;
use App\Models\Wallet;
use Illuminate\Contracts\Validation\Rule;

class ValidName implements Rule
{
    protected $walletNumber;

    public function __construct($walletNumber)
    {
        $this->walletNumber = $walletNumber;
    }

    public function passes($attribute, $value)
    {
        if(Wallet::where('wallet_number', $this->walletNumber)->exists()){
            $wallet = Wallet::where('wallet_number', $this->walletNumber)->first();
            $user = User::find($wallet->user_id);
            $name = $user->name;
            return $value == $name;
        }
        return false;
    }

    public function message()
    {
        return 'Name does not match wallet number.';
    }
}
