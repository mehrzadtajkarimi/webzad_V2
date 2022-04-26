<?php

namespace App\Services\Payment\Contract;

interface OnlineGateway
{
    // from app to gateway
    public function payRequest($params);
    // from  gateway to app
    public function verifyRequest($params);
}
