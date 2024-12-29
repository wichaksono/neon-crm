<?php

namespace App\Models\Common\Enum;

use Mokhosh\FilamentKanban\Concerns\IsKanbanStatus;

enum TodoStatus: string
{
    use IsKanbanStatus;

    case Pending = 'Pending';
    case InProgress = 'In Progress';
    case Completed = 'Completed';
    case Canceled = 'Canceled';
    case Archived = 'Archived';

    public static function getStatuses(): array
    {
        return [
            self::Pending->value => self::Pending->name,
            self::InProgress->value => self::InProgress->name,
            self::Completed->value => self::Completed->name,
            self::Canceled->value => self::Canceled->name,
            self::Archived->value => self::Archived->name,
        ];
    }

    public static function getColors(): array
    {
        return [
            self::Pending->value => 'gray',
            self::InProgress->value => 'blue',
            self::Completed->value => 'green',
            self::Canceled->value => 'red',
            self::Archived->value => 'gray',
        ];
    }

}
