<?php

namespace App\Enum\Services;

enum StatusOrder: string
{
    case awaiting = 'انتظار';
    case preparing = 'آماده سازی';
    case ready = 'آماده';
    case delivered = 'تحویل داده شده';
}

