<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Paiement status') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl w-full mx-auto sm:px-6 lg:px-8">
            <div class="checkout-success bg-white dark:bg-gray-800 shadow-md rounded-lg p-8 text-center space-y-4">

                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                    {{ $message }}
                </h2>

                @if($status === 'succeeded')
                    <p class="text-green-600 dark:text-green-400 font-semibold">Merci pour votre commande ! 🎉</p>
                @elseif($status === 'processing')
                    <p class="text-yellow-600 dark:text-yellow-400 font-semibold">Votre paiement est en cours de traitement…</p>
                @else
                    <p class="text-red-600 dark:text-red-400 font-semibold">Veuillez réessayer ou contacter le support.</p>
                @endif

                <x-link href="{{ route('products.index') }}" color="primary" size="md">
                    Retour au shop
                </x-link>


            </div>
        </div>
    </div>
</x-app-layout>
