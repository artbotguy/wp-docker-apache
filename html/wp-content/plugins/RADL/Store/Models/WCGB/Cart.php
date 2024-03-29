<?php

namespace RADL\Store\Models\WCGB;

use RADL\Store\Models\ModelWCGB;

class Cart extends ModelWCGB
{
    public $route_base = 'cart';

    public $type = 'cart';
    public $settings = [
        "sensitive" => false,
        "JWTRequestConfig" => [
            "JWTMaintain" => true,
            "JWTReqired" => false,
        ]
    ];
}
