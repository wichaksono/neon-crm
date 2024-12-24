<!-- resources/views/filament/pages/settings.blade.php -->

<x-filament::page>
    <!-- Menampilkan alert jika ada error -->
    @if ($errors->any())
        <div class="alert alert-danger mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form wire:submit.prevent="saveSettings">
        <div class="space-y-4">
            <!-- Form Fields -->
            {{ $this->form }}
        </div>

        <div class="flex justify-end mt-4">
            <x-filament::button type="submit" class="mt-6" color="primary">
                Save Settings
            </x-filament::button>
        </div>
    </form>
</x-filament::page>
