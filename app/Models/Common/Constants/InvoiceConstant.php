<?php

namespace App\Models\Common\Constants;

class InvoiceConstant
{
    // Payment types conts
    public const PAYMENT_TYPE_CASH = 'cash';
    public const PAYMENT_TYPE_INSTALLMENT = 'installment';

    public const INSTALLMENT_PERIODS = [
        '3' => '3 Months',
        '6' => '6 Months',
        '12' => '12 Months',
    ];

    public const PAYMENT_TYPES = [
        self::PAYMENT_TYPE_CASH        => 'Cash',
        self::PAYMENT_TYPE_INSTALLMENT => 'Installment',
    ];

    // Payment methods conts
    public const PAYMENT_METHOD_BANK_TRANSFER = 'bank_transfer';
    public const PAYMENT_METHOD_CREDIT_CARD = 'credit_card';
    public const PAYMENT_METHOD_DIRECT_DEBIT = 'direct_debit';
    public const PAYMENT_METHOD_E_WALLET = 'e_wallet';
    public const PAYMENT_METHOD_RETAIL = 'retail';
    public const PAYMENT_METHOD_VIRTUAL_ACCOUNT = 'virtual_account';

    public const PAYMENT_METHODS = [
        self::PAYMENT_METHOD_BANK_TRANSFER   => 'Bank Transfer',
        self::PAYMENT_METHOD_CREDIT_CARD     => 'Credit Card',
        self::PAYMENT_METHOD_DIRECT_DEBIT    => 'Direct Debit',
        self::PAYMENT_METHOD_E_WALLET        => 'E-Wallet',
        self::PAYMENT_METHOD_RETAIL          => 'Retail',
        self::PAYMENT_METHOD_VIRTUAL_ACCOUNT => 'Virtual Account',
    ];

    // Payment statuses conts
    public const PAYMENT_STATUS_DRAFT = 'draft';
    public const PAYMENT_STATUS_UNPAID = 'unpaid';
    public const PAYMENT_STATUS_PAID = 'paid';
    public const PAYMENT_STATUS_REFUND = 'refund';
    public const PAYMENT_STATUS_CANCEL = 'cancel';

    public const PAYMENT_STATUSES = [
        self::PAYMENT_STATUS_DRAFT  => 'Draft',
        self::PAYMENT_STATUS_UNPAID => 'Unpaid',
        self::PAYMENT_STATUS_PAID   => 'Paid',
        self::PAYMENT_STATUS_REFUND => 'Refund',
        self::PAYMENT_STATUS_CANCEL => 'Cancel',
    ];

    // Payment banks conts
    public const PAYMENT_BANK_BCA = 'bca';
    public const PAYMENT_BANK_BNI = 'bni';
    public const PAYMENT_BANK_BRI = 'bri';
    public const PAYMENT_BANK_MANDIRI = 'mandiri';
    public const PAYMENT_BANK_CIMB = 'cimb';
    public const PAYMENT_BANK_DANAMON = 'danamon';
    public const PAYMENT_BANK_MAYBANK = 'maybank';
    public const PAYMENT_BANK_PANIN = 'panin';
    public const PAYMENT_BANK_PERMATA = 'permata';
    public const PAYMENT_BANK_BUKOPIN = 'bukopin';

    public const PAYMENT_BANKS = [
        self::PAYMENT_BANK_BCA     => 'BCA',
        self::PAYMENT_BANK_BNI     => 'BNI',
        self::PAYMENT_BANK_BRI     => 'BRI',
        self::PAYMENT_BANK_MANDIRI => 'Mandiri',
        self::PAYMENT_BANK_CIMB    => 'CIMB Niaga',
        self::PAYMENT_BANK_DANAMON => 'Danamon',
        self::PAYMENT_BANK_MAYBANK => 'Maybank',
        self::PAYMENT_BANK_PANIN   => 'Panin',
        self::PAYMENT_BANK_PERMATA => 'Permata',
        self::PAYMENT_BANK_BUKOPIN => 'Bukopin',
    ];

    // e-wallets types conts
    public const E_WALLET_OVO = 'ovo';
    public const E_WALLET_GOPAY = 'gopay';
    public const E_WALLET_DANA = 'dana';
    public const E_WALLET_LINKAJA = 'linkaja';
    public const E_WALLET_SHOPEEPAY = 'shopeepay';

    public const E_WALLETS = [
        self::E_WALLET_OVO       => 'OVO',
        self::E_WALLET_GOPAY     => 'GoPay',
        self::E_WALLET_DANA      => 'DANA',
        self::E_WALLET_LINKAJA   => 'LinkAja',
        self::E_WALLET_SHOPEEPAY => 'ShopeePay',
    ];

    // Retail types
    public const RETAIL_INDOMARET = 'indomaret';
    public const RETAIL_ALFAMART = 'alfamart';

    public const RETAILS = [
        self::RETAIL_INDOMARET => 'Indomaret',
        self::RETAIL_ALFAMART  => 'Alfamart',
    ];

    // Credit card types
    public const CREDIT_CARD_VISA = 'visa';
    public const CREDIT_CARD_MASTER = 'master';
    public const CREDIT_CARD_JCB = 'jcb';
    public const CREDIT_CARD_AMEX = 'amex';
    public const CREDIT_CARD_DINERS = 'diners';

    public const CREDIT_CARDS = [
        self::CREDIT_CARD_VISA   => 'Visa',
        self::CREDIT_CARD_MASTER => 'MasterCard',
        self::CREDIT_CARD_JCB    => 'JCB',
        self::CREDIT_CARD_AMEX   => 'American Express',
        self::CREDIT_CARD_DINERS => 'Diners Club',
    ];

}
