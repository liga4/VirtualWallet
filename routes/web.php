<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');
Route::get('/dashboard', [WalletController::class, 'walletList'])->name('dashboard');

Route::get('/create-wallet', [WalletController::class, 'create'])->name('createWallet');
Route::post('/create-wallet', [WalletController::class, 'store']);

Route::get('/wallet/{id}', [WalletController::class, 'show'])->name('wallet.show');

Route::delete('/wallet/{id}', [WalletController::class, 'destroy'])->name('destroyWallet');

Route::delete('/transaction/{id}', [TransactionController::class, 'destroy'])->name('destroyTransaction');

Route::patch('/transactions/{id}/mark-fraudulent', [TransactionController::class, 'markFraudulent'])->name('markFraudulent');

Route::patch('/wallets/{walletId}/edit-name', [WalletController::class, 'edit'])->name('wallets.editName');

Route::get('/newTransaction', [TransactionController::class, 'create'])->name('newTransaction');
Route::post('/newTransaction', [TransactionController::class, 'store']);

require __DIR__ . '/auth.php';
