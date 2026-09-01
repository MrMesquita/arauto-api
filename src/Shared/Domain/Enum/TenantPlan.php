<?php

namespace App\Shared\Domain\Enum;

enum TenantPlan: string
{
    case FREE = 'free';
    case PAID = 'paid';
}
