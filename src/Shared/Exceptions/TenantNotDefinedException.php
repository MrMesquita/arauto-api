<?php

namespace App\Shared\Exceptions;

use ApiPlatform\Metadata\ErrorResource;

#[ErrorResource(status: 500)]
final class TenantNotDefinedException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('Tenant is not defined.');
    }
}
