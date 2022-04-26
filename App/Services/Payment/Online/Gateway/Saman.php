<?php

namespace App\Services\Payment\Online\Gateway;

use App\Services\Payment\Contract\OnlineGateway;

class Saman implements OnlineGateway
{
        // from app to gateway
        public function payRequest($params){

        }
        // from  gateway to app
        public function verifyRequest($params){

        }
}
