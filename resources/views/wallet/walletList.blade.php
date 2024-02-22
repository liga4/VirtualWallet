<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-4">
                <div class="p-6 bg-white border-b border-gray-200">
                    <p class="text-lg">You're logged in!</p>
                    <x-button class="text-blue-500" onclick="window.location.href = '{{ route('createWallet') }}'">
                        Create new wallet
                    </x-button>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200 text-center">
                    <h3 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
                        {{ __('Your Wallets') }}
                    </h3>
                    @foreach ($userWallets as $wallet)
                        <a href="{{ route('wallet.show', $wallet->id) }}"
                           class="bg-gray-500 text-white font-bold py-2 px-4 rounded mb-2 inline-block w-full">
                            {{ $wallet->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
