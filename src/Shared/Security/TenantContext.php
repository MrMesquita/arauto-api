<?php

namespace App\Shared\Security;

use App\Shared\Domain\Entity\Tenant;
use App\Shared\Domain\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

class TenantContext
{
    public function __construct(
        private readonly Security $security,
    ) {
    }

    public function getTenant(): Tenant
    {
        $user = $this->security->getUser();

        if (!$user instanceof User) {
            throw new \LogicException('Não há usuário autenticado para resolver o tenant.');
        }

        return $user->getTenant();
    }
}
