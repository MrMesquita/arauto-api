<?php

namespace App\WhatsappIntegration\Domain\Enum;

enum TemplateCategory: string
{
    case Marketing = 'MARKETING';
    case Utility = 'UTILITY';
    case Authentication = 'AUTHENTICATION';
}
