<?php

namespace App\Tests;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Contact\Domain\Entity\Contact;
use App\Shared\Domain\Entity\Tenant;
use App\Shared\Domain\Entity\User;
use App\Shared\Domain\Enum\TenantPlan;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ContactApiTest extends ApiTestCase
{
    protected static ?bool $alwaysBootKernel = true;

    public function testAuthenticationIsRequired(): void
    {
        static::createClient()->request('GET', '/api/contacts');

        self::assertResponseStatusCodeSame(401);
    }

    public function testTenantCannotSeeContactsFromAnotherTenant(): void
    {
        $client = static::createClient();

        $entityManager = static::getContainer()->get(EntityManagerInterface::class);
        $passwordHasher = static::getContainer()->get(UserPasswordHasherInterface::class);
        $userEmail = 'user-'. time() .'@example.com';

        $tenantA = (new Tenant())
            ->setName('Tenant A')
            ->setPlan(TenantPlan::FREE)
            ->setCreatedAt(new \DateTimeImmutable());

        $tenantB = (new Tenant())
            ->setName('Tenant B')
            ->setPlan(TenantPlan::FREE)
            ->setCreatedAt(new \DateTimeImmutable());

        $userA = (new User())
            ->setEmail($userEmail)
            ->setTenant($tenantA);

        $userA->setPassword(
            $passwordHasher->hashPassword($userA, 'password123')
        );

        $contactA = (new Contact())
            ->setTenant($tenantA)
            ->setName('Contato do Tenant A')
            ->setPhone('5511999999991')
            ->setOptIn(true)
            ->setCreatedAt(new \DateTimeImmutable());

        $contactB = (new Contact())
            ->setTenant($tenantB)
            ->setName('Contato do Tenant B')
            ->setPhone('5511999999992')
            ->setOptIn(true)
            ->setCreatedAt(new \DateTimeImmutable());

        foreach ([$tenantA, $tenantB, $userA, $contactA, $contactB] as $entity) {
            $entityManager->persist($entity);
        }

        $entityManager->flush();

        $loginResponse = $client->request('POST', '/api/login', [
            'json' => [
                'username' => $userEmail,
                'password' => 'password123',
            ],
        ]);

        self::assertResponseIsSuccessful();

        $token = $loginResponse->toArray()['token'];

        $response = static::createClient([], [
            'headers' => [
                'Authorization' => 'Bearer '.$token,
            ],
        ])->request('GET', '/api/contacts');

        self::assertResponseIsSuccessful();

        $content = $response->getContent(false);

        self::assertStringContainsString('Contato do Tenant A', $content);
        self::assertStringNotContainsString('Contato do Tenant B', $content);
    }
}
