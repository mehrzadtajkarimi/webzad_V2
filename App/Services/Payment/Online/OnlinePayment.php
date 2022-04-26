<?php

namespace App\Services\Payment\Online;

use App\Services\Basket\Basket;
use App\Services\Payment\Contract\OnlineGateway;
use App\Services\Payment\Contract\PaymentContract;
use App\Services\Payment\Online\Gateway\ZarinPal;

class OnlinePayment implements PaymentContract
{
    public $gateway;
    public function __construct()
    {
        $this->gateway = new ZarinPal;
    }
    public function setGateway(OnlineGateway $gateway)
    {
        $this->gateway = $gateway;
    }
    
    public function pay()
    {
        $resnum = bin2hex(random_bytes(2)) . time();
        // basket to order here (order with unique resnum : $resnum )

        $params = array(
            'amount' => Basket::total(),
            'description' => "پرداخت تستی ",
            'email' => "test@gmail.com",
            'mobile' => '09777777777',
            'callback_url' => base_url('payment-verification?resnum=' . $resnum)
        );
        $this->gateway->payRequest($params);
    }
    public function verify()
    {
        // basket amount here for pay value validation
        $params = array('amount' => Basket::total());

        $payment_ok = $this->gateway->verifyRequest($params);
        if (!$payment_ok) {
            return false;
        }
        // at this line payment is ok !
        echo "پرداخت موفق بود";

        // get order by resnum reterned by gateway
        // register order for users
        // clear basket

        $order_items = Basket::items();

echo '<br><hr><pre style="background:#FF5722; border-radius: 10px; padding: 20PX">';
var_dump($order_items);
die('LINE' .' => '. __LINE__ . PHP_EOL .'FILE' .' => '. __FILE__ );

        Basket::reset();
    }
}
