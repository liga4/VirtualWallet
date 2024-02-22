<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidAmount implements Rule
{
    protected $balance;

    public function __construct($balance)
    {
        $this->balance = $balance;
    }

    public function passes($attribute, $value)
    {
        return $value <= $this->balance;
    }

    public function message()
    {
        return 'Not enough money in chosen wallet.';
    }
}
