<?php

namespace App\WhatsAppIntegration\Domain\Entity;

use App\Shared\Domain\Entity\Tenant;
use App\WhatsAppIntegration\Infrastructure\Repository\WhatsAppAccountRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WhatsAppAccountRepository::class)]
class WhatsAppAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'whatsAppAccounts')]
    private ?Tenant $tenant = null;

    #[ORM\Column(length: 255)]
    private ?string $wabaId = null;

    #[ORM\Column(length: 255)]
    private ?string $phoneNumberId = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $accessToken = null;

    #[ORM\Column(length: 255)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): static
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getWabaId(): ?string
    {
        return $this->wabaId;
    }

    public function setWabaId(string $wabaId): static
    {
        $this->wabaId = $wabaId;

        return $this;
    }

    public function getPhoneNumberId(): ?string
    {
        return $this->phoneNumberId;
    }

    public function setPhoneNumberId(string $phoneNumberId): static
    {
        $this->phoneNumberId = $phoneNumberId;

        return $this;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): static
    {
        $this->accessToken = $accessToken;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
