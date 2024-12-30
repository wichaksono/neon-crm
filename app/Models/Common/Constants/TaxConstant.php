<?php

namespace App\Models\Common\Constants;

class TaxConstant
{
    public const TYPE_FIXED = 'fixed';
    public const TYPE_PERCENTAGE = 'percentage';

    public const TYPES = [
        self::TYPE_FIXED => 'Fixed',
        self::TYPE_PERCENTAGE => 'Percentage',
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';

    public const STATUSES = [
        self::STATUS_ACTIVE => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
    ];
}
