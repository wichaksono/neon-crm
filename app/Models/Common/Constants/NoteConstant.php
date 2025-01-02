<?php

namespace App\Models\Common\Constants;

class NoteConstant
{
    public const PRIORITY_LOW = 'low';
    public const PRIORITY_NORMAL = 'normal';
    public const PRIORITY_MEDIUM = 'medium';
    public const PRIORITY_HIGH = 'high';
    public const PRIORITY_URGENT = 'urgent';

    public const PRIORITIES = [
        self::PRIORITY_LOW => 'Low',
        self::PRIORITY_NORMAL => 'Normal',
        self::PRIORITY_MEDIUM => 'Medium',
        self::PRIORITY_HIGH => 'High',
        self::PRIORITY_URGENT => 'Urgent',
    ];
}
