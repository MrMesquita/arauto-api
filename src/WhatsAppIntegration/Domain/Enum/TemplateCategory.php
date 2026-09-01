<?php

namespace App\WhatsAppIntegration\Domain\Enum;

enum TemplateCategory: string
{
    case Marketing = 'MARKETING';
    case Utility = 'UTILITY';
    case Authentication = 'AUTHENTICATION';
}
