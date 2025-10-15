<?php

namespace App\Core\Utils\Constant\Error;

enum TypeLog: string
{
    case EXCEPTION = 'EXCEPTION';
    case QUERY = 'QUERY';
    case SYSTEM = 'SYSTEM';
    case SERVICE = 'SERVICE';
    case API = 'API';
    case UNKNOWN = 'UNKNOWN';
}
