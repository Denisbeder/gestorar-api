<?php

namespace App\Enums;

enum ContactTypeEnum: string
{
    case TEXT = 'text';
    case EMAIL = 'email';
    case PHONE = 'phone';
}
