<?php

namespace App\Models\Common\Constants;

class ProductConstant
{
    public const TYPE_PHYSICAL = 'physical';
    public const TYPE_DIGITAL = 'digital';
    public const TYPE_SERVICE = 'service';

    public const TYPES = [
        self::TYPE_PHYSICAL => 'Physical',
        self::TYPE_DIGITAL  => 'Digital',
        self::TYPE_SERVICE  => 'Service',
    ];

    public const STATUS_ACTIVE = 'active';
    public const STATUS_INACTIVE = 'inactive';
    public const STATUS_DRAFT = 'draft';
    public const STATUS_PENDING = 'pending';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    public const STATUSES = [
        self::STATUS_ACTIVE   => 'Active',
        self::STATUS_INACTIVE => 'Inactive',
        self::STATUS_DRAFT    => 'Draft',
        self::STATUS_PENDING  => 'Pending',
        self::STATUS_APPROVED => 'Approved',
        self::STATUS_REJECTED => 'Rejected',
    ];

    // units
    public const UNIT_PIECE = 'piece';
    public const UNIT_BOX = 'box';
    public const UNIT_CARTON = 'carton';
    public const UNIT_PALLET = 'pallet';
    public const UNIT_CONTAINER = 'container';
    public const UNIT_BARREL = 'barrel';
    public const UNIT_DRUM = 'drum';
    public const UNIT_BAG = 'bag';
    public const UNIT_BUNDLE = 'bundle';
    public const UNIT_PACK = 'pack';
    public const UNIT_CASE = 'case';

    public const UNITS = [
        self::UNIT_PIECE     => 'Piece',
        self::UNIT_BOX       => 'Box',
        self::UNIT_CARTON    => 'Carton',
        self::UNIT_PALLET    => 'Pallet',
        self::UNIT_CONTAINER => 'Container',
        self::UNIT_BARREL    => 'Barrel',
        self::UNIT_DRUM      => 'Drum',
        self::UNIT_BAG       => 'Bag',
        self::UNIT_BUNDLE    => 'Bundle',
        self::UNIT_PACK      => 'Pack',
        self::UNIT_CASE      => 'Case',
    ];
}
