<?php

namespace App\Models\Common\Constants;

class RecurringConstant
{
    public const RECURRING_TYPE_ONCE = 'once';
    public const RECURRING_TYPE_DAILY = 'daily';
    public const RECURRING_TYPE_WEEKLY = 'weekly';
    public const RECURRING_TYPE_BIWEEKLY = 'biweekly';
    public const RECURRING_TYPE_MONTHLY = 'monthly';
    public const RECURRING_TYPE_QUARTERLY = 'quarterly';
    public const RECURRING_TYPE_SEMIANNUALLY = 'semiannually';
    public const RECURRING_TYPE_ANNUALLY = 'annually';
    public const RECURRING_TYPE_BIENNIAL = 'biennial';
    public const RECURRING_TYPE_TRIENNIAL = 'triennial';
    public const RECURRING_TYPE_QUADRENNIAL = 'quadrennial';
    public const RECURRING_TYPE_QUINQUENNIAL = 'quinquennial';

    public const RECURRING_TYPES = [
        self::RECURRING_TYPE_ONCE => 'Once',
        self::RECURRING_TYPE_DAILY => 'Daily',
        self::RECURRING_TYPE_WEEKLY => 'Weekly',
        self::RECURRING_TYPE_BIWEEKLY => 'Biweekly',
        self::RECURRING_TYPE_MONTHLY => 'Monthly',
        self::RECURRING_TYPE_QUARTERLY => 'Quarterly',
        self::RECURRING_TYPE_SEMIANNUALLY => 'Semiannually',
        self::RECURRING_TYPE_ANNUALLY => 'Annually',
        self::RECURRING_TYPE_BIENNIAL => 'Biennial',
        self::RECURRING_TYPE_TRIENNIAL => 'Triennial',
        self::RECURRING_TYPE_QUADRENNIAL => 'Quadrennial',
    ];

    public const RECURRING_INTERVAL = [
        self::RECURRING_TYPE_DAILY => '+1 day',
        self::RECURRING_TYPE_WEEKLY => '+1 week',
        self::RECURRING_TYPE_BIWEEKLY => '+2 weeks',
        self::RECURRING_TYPE_MONTHLY => '+1 month',
        self::RECURRING_TYPE_QUARTERLY => '+3 months',
        self::RECURRING_TYPE_SEMIANNUALLY => '+6 months',
        self::RECURRING_TYPE_ANNUALLY => '+1 year',
        self::RECURRING_TYPE_BIENNIAL => '+2 years',
        self::RECURRING_TYPE_TRIENNIAL => '+3 years',
        self::RECURRING_TYPE_QUADRENNIAL => '+4 years',
        self::RECURRING_TYPE_QUINQUENNIAL => '+5 years',
    ];
}
