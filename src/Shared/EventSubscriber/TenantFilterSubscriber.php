<?php

namespace App\Shared\EventSubscriber;

use App\Shared\Security\TenantContext;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class TenantFilterSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly TenantContext $tenantContext
    ) {
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onKernelRequest', -10]
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        try {
            $tenant = $this->tenantContext->getTenant();
        } catch (\LogicException) {
            return;
        }

        $filter = $this->entityManager->getFilters()->enable('tenant_filter');
        $filter->setParameter('tenantId', $tenant->getId(), Types::INTEGER);
    }
}
