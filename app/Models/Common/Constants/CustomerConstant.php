<?php

namespace App\Models\Common\Constants;

class CustomerConstant
{
    public const TYPE_PERSON = 'person';
    public const TYPE_COMPANY = 'company';

    public const TYPES = [
        self::TYPE_PERSON => 'Person',
        self::TYPE_COMPANY => 'Company',
    ];

    public const NEW_CUSTOMER = 'new-customer';
    public const RETURNING_CUSTOMER = 'returning-customer';
    public const VIP_CUSTOMER = 'vip-customer';
    public const POTENTIAL_LEAD = 'potential-lead';
    public const INACTIVE_CUSTOMER = 'inactive-customer';
    public const LOYAL_CUSTOMER = 'loyal-customer';
    public const AT_RISK_CUSTOMER = 'at-risk-customer';
    public const CHURNED_CUSTOMER = 'churned-customer';
    public const HIGH_SPENDING_CUSTOMER = 'high-spending-customer';
    public const LOW_SPENDING_CUSTOMER = 'low-spending-customer';
    public const CORPORATE_CLIENT = 'corporate-client';
    public const DISCOUNT_SEEKER = 'discount-seeker';
    public const FREQUENT_BUYER = 'frequent-buyer';
    public const ONE_TIME_BUYER = 'one-time-buyer';
    public const REFERRAL_CUSTOMER = 'referral-customer';
    public const TRIAL_USER = 'trial-user';
    public const WHOLESALE_CUSTOMER = 'wholesale-customer';
    public const SUPPORT_DEPENDENT_CUSTOMER = 'support-dependent-customer';
    public const FEEDBACK_CONTRIBUTOR = 'feedback-contributor';
    public const CUSTOM_ORDER_CLIENT = 'custom-order-client';

    public const LABELS = [
        self::NEW_CUSTOMER => 'New Customer',
        self::RETURNING_CUSTOMER => 'Returning Customer',
        self::VIP_CUSTOMER => 'VIP Customer',
        self::POTENTIAL_LEAD => 'Potential Lead',
        self::INACTIVE_CUSTOMER => 'Inactive Customer',
        self::LOYAL_CUSTOMER => 'Loyal Customer',
        self::AT_RISK_CUSTOMER => 'At Risk Customer',
        self::CHURNED_CUSTOMER => 'Churned Customer',
        self::HIGH_SPENDING_CUSTOMER => 'High Spending Customer',
        self::LOW_SPENDING_CUSTOMER => 'Low Spending Customer',
        self::CORPORATE_CLIENT => 'Corporate Client',
        self::DISCOUNT_SEEKER => 'Discount Seeker',
        self::FREQUENT_BUYER => 'Frequent Buyer',
        self::ONE_TIME_BUYER => 'One Time Buyer',
        self::REFERRAL_CUSTOMER => 'Referral Customer',
        self::TRIAL_USER => 'Trial User',
        self::WHOLESALE_CUSTOMER => 'Wholesale Customer',
        self::SUPPORT_DEPENDENT_CUSTOMER => 'Support Dependent Customer',
        self::FEEDBACK_CONTRIBUTOR => 'Feedback Contributor',
        self::CUSTOM_ORDER_CLIENT => 'Custom Order Client',
    ];

    public const INDUSTRIES = [
        'Agriculture',
        'Automotive',
        'Banking',
        'Construction',
        'Education',
        'Energy',
        'Entertainment',
        'Fashion',
        'Finance',
        'Food & Beverage',
        'Healthcare',
        'Hospitality',
        'Information Technology',
        'Insurance',
        'Manufacturing',
        'Media',
        'Real Estate',
        'Retail',
        'Telecommunication',
        'Transportation',
        'Travel',
    ];
}
