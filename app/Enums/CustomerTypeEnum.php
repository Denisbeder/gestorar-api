<?php

namespace App\Enums;

enum CustomerTypeEnum: string
{
    case CPF = 'cpf';
    case CNPJ = 'cnpj';
}
