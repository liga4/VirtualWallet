<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Virtual Wallet') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="mt-5 md:mt-0 md:col-span-2">

            <form action="{{ route('createWallet') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label for="wallet_name" class="block text-sm font-medium text-gray-600">Wallet Name</label>
                    <input type="text" id="wallet_name" name="wallet_name" class="mt-1 p-2 border rounded-md w-full" required>
                    @if ($errors->has('wallet_name'))
                        <div class="alert alert-danger error-message" style="color: red">
                            {{ $errors->first('wallet_name') }}
                        </div>
                    @endif
                </div>


                <div class="mb-4">
                    <x-button type="submit">
                        {{ __('Create Wallet') }}
                    </x-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
