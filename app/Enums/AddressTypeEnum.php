<?php

namespace App\Enums;

enum AddressTypeEnum: string
{
    case HOME = 'home';
    case COMMERCIAL = 'commercial';
    case BILLING = 'billing';
}
