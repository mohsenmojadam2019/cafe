<?php

namespace App\Enum\Services;

enum StatusProduct: string
{
    case available = 'موجود';
    case outOfStock = 'ناموجود';
}

