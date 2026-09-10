<?php

namespace App\Shared\Infrastructure\Doctrine\Filter;

use App\Shared\Exceptions\TenantNotDefinedException;
use Doctrine\ORM\Mapping\ClassMetadata;
use Doctrine\ORM\Query\Filter\SQLFilter;

class TenantFilter extends SQLFilter
{
    public function addFilterConstraint(ClassMetadata $targetEntity, string $targetTableAlias): string
    {
        if (!$targetEntity->hasAssociation('tenant')) {
            return '';
        }

        try {
            $tenantId = $this->getParameter('tenantId');
        } catch (\InvalidArgumentException) {
            throw new TenantNotDefinedException();
        }

        $column = $targetEntity->getAssociationMapping('tenant')->joinColumns[0]->name ?? 'tenant_id';

        return sprintf('%s.%s = %s', $targetTableAlias, $column, $tenantId);
    }
}
