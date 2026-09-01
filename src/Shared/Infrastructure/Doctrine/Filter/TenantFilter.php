<?php

namespace App\Shared\Infrastructure\Doctrine\Filter;

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
            return ''; // filtro ativado mas sem parâmetro setado ainda — não filtra
        }

        $column = $targetEntity->getAssociationMapping('tenant')['joinColumns'][0]['name'] ?? 'tenant_id';

        return sprintf('%s.%s = %s', $targetTableAlias, $column, $tenantId);
    }
}
