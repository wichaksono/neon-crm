<div
    id="{{ $record->getKey() }}"
    wire:click="recordClicked('{{ $record->getKey() }}', {{ @json_encode($record) }})"
    class="record bg-white dark:bg-gray-700 rounded-md px-4 py-2 cursor-grab font-medium text-gray-600 dark:text-gray-200"
    style="border-left: 4px solid {{ $record->color }};"
    @if($record->timestamps && now()->diffInSeconds($record->{$record::UPDATED_AT}) < 3)
        x-data
        x-init="
            $el.classList.add('animate-pulse-twice', 'bg-primary-100', 'dark:bg-primary-800')
            $el.classList.remove('bg-white', 'dark:bg-gray-700')
            setTimeout(() => {
                $el.classList.remove('bg-primary-100', 'dark:bg-primary-800')
                $el.classList.add('bg-white', 'dark:bg-gray-700')
            }, 3000)
        "
    @endif
>
    {{ $record->{static::$recordTitleAttribute} }}

    @if($record->timestamps)
        <div class="text-xs text-gray-400 dark:text-gray-500">
            {{ $record->{$record::UPDATED_AT}->diffForHumans() }}
        </div>
    @endif


</div>
