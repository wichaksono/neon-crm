<x-filament::page>
    <div class="space-y-6">
        <h2 class="text-lg font-bold">Daftar Produk</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            @foreach ($products as $product)
                <div class="border p-4 rounded-lg shadow">
                    <h3 class="font-semibold">{{ $product->name }}</h3>
                    <p>Harga: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
                    <x-filament::button
                        wire:click="addToCart({{ $product->id }})"
                        class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                        Tambahkan ke Keranjang
                    </x-filament::button>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::page>
