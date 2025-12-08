<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Liste des produits') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white">
                <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                    <h2 class="text-2xl font-bold tracking-tight text-gray-900">Customers also purchased</h2>

                    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">

                        @foreach($products as $product)
                        <!-- PRODUCT CARD -->
                        <div
                            class="group relative border rounded-xl overflow-hidden shadow-sm hover:shadow-xl transition">

                            <!-- Image + overlay actions -->
                            <div class="relative">
                                <img
                                    src="{{ $product->image }}"
                                    class="object-cover object-top aspect-square w-full transition-transform duration-500 ease-in-out transform group-hover:scale-110"
                                    alt="image"
                                />


                                <!-- Action buttons ON HOVER -->
                                <div
                                    class="absolute inset-0 flex items-center justify-center gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-1000">

                                    <!-- Add to cart (hover effect) -->
                                    <button class="px-3 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg shadow hover:bg-gray-800 hover:text-white transform transition-transform duration-300 hover:scale-110">
                                        <!-- ICON CART -->
                                        <span class="material-symbols-outlined" style="font-size: 20px">
                                            add_shopping_cart
                                        </span>
                                    </button>

                                    <!-- Favorite ❤️ (hover effect) -->
                                    <button class="p-2 bg-white rounded-full shadow text-gray-700 hover:bg-red-100 hover:text-red-600 transform transition-transform duration-300 hover:scale-125 hover:rotate-6">
                                        ❤️
                                    </button>

                                    <!-- Quick view 👁️ (hover effect) -->
                                    <button class="p-2 bg-white rounded-full shadow text-gray-700 hover:bg-gray-200 transform transition-transform duration-300 hover:scale-125 hover:-rotate-6">
                                        👁️
                                    </button>
                                </div>

                            </div>

                            <!-- Info -->
                            <div class="p-3 space-y-3">

                                <!-- Name + price -->
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-sm font-medium text-gray-800">
                                            <a href="#">
                                                <!-- inset-0 permet au span de recouvrir entièrement le <a> — comme un film transparent posé dessus.-->
                                                <span class="absolute inset-0 pointer-events-none"></span>
                                                {{ $product->name  }}
                                            </a>
                                        </h3>

                                        <!-- NEW COLORS -->
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="w-4 h-4 rounded-full bg-red-500 border border-gray-300 hover:ring-2 hover:ring-red-500 transition"></span>
                                            <span class="w-4 h-4 rounded-full bg-blue-500 border border-gray-300 hover:ring-2 hover:ring-blue-500 transition"></span>
                                            <span class="w-4 h-4 rounded-full bg-green-500 border border-gray-300 hover:ring-2 hover:ring-green-500 transition"></span>
                                        </div>
                                    </div>

                                    <!-- Prix actuel + ancien prix -->
                                    <div class="flex flex-col items-end">
                                        <p class="text-sm font-bold text-gray-900">{{ $product->getFormattedPriceAttribute() }}</p>
                                        <p class="text-xs text-gray-400 line-through">{{ $product->getFormatedHoldPriceAttribute() }}</p>
                                    </div>
                                </div>

                                <!-- Description (NEW) -->
                                <p class="text-xs text-gray-600 leading-relaxed line-clamp-2">
                                    {{ $product->description }}
                                </p>

                                <!-- Add to cart button (always visible) -->
                                <add-to-cart :product-id="{{ $product->id }}"></add-to-cart>

                            </div>
                        </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
