<x-filament::dropdown placement="bottom-start">
    <x-slot name="trigger">
        <x-filament::icon-button
            class="border border-primary-500 text-primary-500 hover:bg-primary-500 hover:text-white dark:border-primary-500 dark:text-primary-500 dark:hover:bg-primary-500 dark:hover:text-white"
            icon="hugeicons-plus-sign"
            size="xs"
            label="Add New"/>
    </x-slot>

    <x-filament::dropdown.list>
        <x-filament::dropdown.list.item
            class="hover:border-primary-500 hover:text-primary-500"
            icon="heroicon-m-sparkles"
            href="{{ $newOrderUrl }}"
            tag="a"
        >
            New Order
        </x-filament::dropdown.list.item>

        <x-filament::dropdown.list.item
            class="hover:border-primary-500 hover:text-primary-500"
            icon="hugeicons-user-add-01"
            href="{{ $newCustomerUrl }}"
            tag="a"
        >
            New Customer
        </x-filament::dropdown.list.item>

    </x-filament::dropdown.list>
</x-filament::dropdown>
