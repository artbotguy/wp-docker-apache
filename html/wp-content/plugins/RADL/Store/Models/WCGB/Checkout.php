<?php

namespace RADL\Store\Models\WCGB;

use RADL\Store\Models\ModelWCGB;

class Checkout extends ModelWCGB
{
    public $route_base = 'checkout';

    public $type = 'checkout';

    public $settings = [
        "sensitive" => true,
        "JWTRequestConfig" => [
            "JWTMaintain" => true,
            "JWTReqired" => true,
        ]
    ];
}
