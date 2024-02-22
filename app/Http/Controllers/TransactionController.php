<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Wallet;
use App\Rules\ValidAmount;
use App\Rules\ValidName;
use App\Rules\ValidReceiver;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function create(): View
    {
        $userWallets = Auth::user()->wallets;
        return view('transactions.create', ['userWallets' => $userWallets]);
    }

    public function store(Request $request): RedirectResponse
    {
        $sender = Auth::user();
        $wallet = Wallet::where('id', $request->wallet_id)->first();

        $request->validate([
            'wallet_id' => ['required'],
            'receivers_name' => ['required', 'string', 'max:255', new ValidName($request->receiver_wallet_number)],
            'receiver_wallet_number' => ['required', new ValidReceiver()],
            'amount' => ['required', 'numeric', new ValidAmount($wallet->balance)],
            'reference' => ['required', 'string', 'max:500']
        ]);
        $receiversWallet = Wallet::where('wallet_number', $request->receiver_wallet_number)->first();
        $receiver = $receiversWallet->user_id;
        $amount = $request->amount;

        Transaction::create([
            'sender_id' => $sender->id,
            'sender_wallet_id' => $request->wallet_id,
            'receiver_id' => $receiver,
            'receiver_wallet_id' => $receiversWallet->id,
            'reference' => $request->reference,
            'amount' => $amount
        ]);

        $newSenderBalance = (int)$wallet->balance - $amount;
        $wallet->update(['balance' => $newSenderBalance]);

        $receiversBalance = $receiversWallet->balance;
        $newReceiversBalance = $receiversBalance + $amount;
        $receiversWallet->update(['balance' => $newReceiversBalance]);

        return redirect('wallet/' . $request->wallet_id);
    }

    public function markFraudulent($id): RedirectResponse
    {
        $transaction = Transaction::findOrFail($id);
        if ($transaction->fraudulent == 0) {
            $transaction->update(['fraudulent' => true]);
        } else {
            $transaction->update(['fraudulent' => false]);
        }
        return redirect()->back();
    }

    public function destroy($id): RedirectResponse
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->back()->with('success', 'Transaction deleted successfully');
    }
}
