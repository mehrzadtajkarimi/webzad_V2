<?php

namespace App\Services\Payment\Wallet;

use App\Services\Payment\Contract\PaymentContract;


class WalletPayment implements PaymentContract
{
    public function pay()
    {
        // بررسی مقدار موجودی
        // بررسی مقدار سبد خرید
        // اگر کیف پول کمتر از سبد بود پیغام ارسال میشه


        /////////////// شروع معامله
        // https://www.mysqltutorial.org/mysql-transaction.aspx
        // ذخیره تراکنش
        // تایید سبد خرید
        // خالی شدن سبد خرید
        // کیف پول مقدارش کم بشه به مبلغ سبد خرید
        /////////////// پایان معامله
    }
}
