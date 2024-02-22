<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Wallet Information') }}
        </h2>

    </x-slot>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
    <form method="POST" action="{{ route('destroyWallet', ['id' => $wallet->id]) }}">
        @csrf
        @method('DELETE')

        <x-button type="submit" onclick="return confirm('Are you sure you want to delete this wallet?')">Delete Wallet</x-button>
    </form>
    </div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-5 md:mt-0 md:col-span-2">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="text-2xl font-bold mb-4">{{ $wallet->name }}</h1>
                    <form method="POST" action="{{ route('wallets.editName', ['walletId' => $wallet->id]) }}"
                          class="my-4">
                        @csrf
                        @method('PATCH')

                        <div class="form-group">
                            <label for="name">Edit Name:</label>
                            <label>
                                <x-input type="text" class="form-control" name="name" value="{{ $wallet->name }}"
                                         required></x-input>
                            </label>
                            <x-button type="submit" class="btn btn-primary">Save</x-button>
                            @if ($errors->has('name'))
                                <div class="alert alert-danger error-message" style="color: red">
                                    {{ $errors->first('name') }}
                                </div>
                            @endif
                        </div>
                    </form>
                    <p class="text-gray-800">Balance: ${{ $wallet->balance }}</p>
                    <p class="text-gray-800">Wallet Number: {{ $wallet->wallet_number }}</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-xl font-bold mb-4">Transaction History ({{ count($incoming) + count($outgoing) }})</h2>
                    @if(count($incoming) > 0)
                            <h3 class="text-xl font-bold mb-4">Incoming</h3>
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wallet Number</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fraud Status</th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($incoming as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->sender->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->senderWallet->wallet_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-green-600"> + ${{ $transaction->amount }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->reference }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->fraudulent == 0 ? 'False' : 'True' }}
                                                <form method="POST" action="{{ route('markFraudulent', ['id' => $transaction->id]) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="text-xs" style="color: red;" type="submit" onclick="return confirm('Are you sure you want to change fraud status?')">Change</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('destroyTransaction', ['id' => $transaction->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button type="submit" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</x-button>
                                                </form>
                                            </td>
                                        </tr>
                                @endforeach
                                </tbody>
                            </table>
                    @else
                        <h3 class="text-xl font-bold mb-4">Incoming</h3>
                        <p>No incoming transactions found for this wallet.</p>
                    @endif
                    @if(count($outgoing) > 0)
                        <h3 class="text-xl font-bold mb-4">Outgoing</h3>
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Wallet Number</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fraud Status</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($outgoing as $transaction)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->receiver->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->receiverWallet->wallet_number }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-red-600"> - ${{ $transaction->amount }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->reference }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->created_at->format('Y-m-d H:i:s') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $transaction->fraudulent == 0 ? 'False' : 'True' }}
                                                <form method="POST" action="{{ route('markFraudulent', ['id' => $transaction->id]) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button class="text-xs" style="color: red;" type="submit" onclick="return confirm('Are you sure you want to change fraud status?')">Change</button>
                                                </form>
                                            </td>
                                            <td>
                                                <form method="POST" action="{{ route('destroyTransaction', ['id' => $transaction->id]) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <x-button type="submit" onclick="return confirm('Are you sure you want to delete this transaction?')">Delete</x-button>
                                                </form>
                                            </td>
                                        </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <h3 class="text-xl font-bold mb-4">Outgoing</h3>
                        <p>No outgoing transactions found for this wallet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
