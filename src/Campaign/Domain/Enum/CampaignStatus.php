<?php

namespace App\Campaign\Domain\Enum;

enum CampaignStatus: string
{
    case DRAFT = 'draft';
    case SCHEDULED = 'scheduled';
    case SENDING = 'sending';
    case COMPLETED = 'completed';
    case FAILED = 'failed';
}
