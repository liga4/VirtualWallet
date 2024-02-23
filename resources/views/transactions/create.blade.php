<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Transaction') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-semibold text-lg text-gray-800 mb-4">
                        {{ __('Create a New Transaction') }}
                    </h3>

                    <form action="{{ route('newTransaction') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label for="wallet_id" class="block text-sm font-medium text-gray-600">Select Wallet</label>
                            <select id="wallet_id" name="wallet_id" class="mt-1 p-2 border rounded-md w-full" required>
                                @foreach($userWallets as $wallet)
                                    <option value="{{ $wallet->id }}">{{ $wallet->name }} (${{ $wallet->balance }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="receivers_name" class="block text-sm font-medium text-gray-600">Receivers Name</label>
                            <input type="text" id="receivers_name" value="{{ old('receivers_name') }}" name="receivers_name" class="mt-1 p-2 border rounded-md w-full" required>
                            @if ($errors->has('receivers_name'))
                                <div class="alert alert-danger error-message" style="color: red">
                                    {{ $errors->first('receivers_name') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="receiver_wallet_number" class="block text-sm font-medium text-gray-600">Receivers Wallet number</label>
                            <input type="text" id="receiver_wallet_number" value="{{ old('receiver_wallet_number') }}" name="receiver_wallet_number" class="mt-1 p-2 border rounded-md w-full" required>
                            @if ($errors->has('receiver_wallet_number'))
                                <div class="alert alert-danger error-message" style="color: red">
                                    {{ $errors->first('receiver_wallet_number') }}
                                </div>
                            @endif
                        </div>
                        <div class="mb-4">
                            <label for="amount" class="block text-sm font-medium text-gray-600">Amount</label>
                            <input type="number" id="amount" value="{{ old('amount') }}" name="amount" class="mt-1 p-2 border rounded-md w-full" required>
                            @if ($errors->has('amount'))
                                <div class="alert alert-danger error-message" style="color: red">
                                    {{ $errors->first('amount') }}
                                </div>
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="reference" class="block text-sm font-medium text-gray-600">Reference</label>
                            <textarea id="reference" name="reference"  rows="2" class="mt-1 p-2 border rounded-md w-full" required></textarea>
                        </div>
                        <div class="mb-4">
                            <x-button type="submit">
                                {{ __('Submit') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
