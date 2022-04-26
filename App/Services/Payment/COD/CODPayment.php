<?php

namespace App\Services\Payment\COD;

use App\Services\Payment\Contract\PaymentContract;


// COD = cash on delivery
class CODPayment implements PaymentContract
{
    public function pay()
    {
        // توسط پیک موتوری شناسایی کاربر و کشیدن کارت
        // تایید مبلغ واریز به پیک
        // تایید سفارش به پیک
        // پیغام به کاربر
    }
}
