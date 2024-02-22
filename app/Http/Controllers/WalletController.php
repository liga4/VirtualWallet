<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Transfer;
use App\Models\Wallet;
use App\Rules\ValidWalletName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WalletController extends Controller
{
    public function create():View
    {
        return view('wallet.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'wallet_name' => [
                'required',
                'string',
                'max:255',
                new ValidWalletName()
            ]
            ]);

        Wallet::create([
            'user_id' => auth()->user()['id'],
            'name' => $request->wallet_name,
            'wallet_number' => $this->generateWalletNumber(),
            'balance' => 100
        ]);

        return redirect('dashboard');
    }

    public function show($id)
    {
        $incomingTransactions = Transaction::where('receiver_wallet_id', $id)->get();

        $outgoingTransactions = Transaction::where('sender_wallet_id', $id)->get();

        $wallet = Wallet::findOrFail($id);

            return View('wallet.show', [
                'wallet' => $wallet,
                'incoming' => $incomingTransactions,
                'outgoing' => $outgoingTransactions
            ]);
    }

    public function edit(Request $request , $id)
    {
        $wallet = Wallet::findOrFail($id);
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                new ValidWalletName()
            ]
        ]);

        $wallet->update(['name' => $request->input('name')]);
        return redirect()->back()->with('success', 'Wallet name updated successfully');
    }

    public function generateWalletNumber(): string
    {
        $countryCode = 'LV';
        $accountNumber = str_pad(mt_rand(1, 9999999999), 6, '0', STR_PAD_LEFT);

        return $countryCode . $accountNumber;
    }
    public function walletList()
    {
        $userWallets = Auth::user()->wallets;
        return view('wallet.walletList', ['userWallets' => $userWallets]);
    }
    public function destroy($id)
    {
        $wallet = Wallet::findOrFail($id);

        $wallet->delete();

        return redirect('dashboard')->with('success', 'Wallet deleted successfully');
    }
}
