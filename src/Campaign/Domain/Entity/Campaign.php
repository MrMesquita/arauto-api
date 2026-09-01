<?php

namespace App\Campaign\Domain\Entity;

use App\Campaign\Domain\Enum\CampaignStatus;
use App\Campaign\Infrastructure\Repository\CampaignRepository;
use App\Contact\Domain\Entity\ContactList;
use App\Shared\Domain\Entity\Tenant;
use App\Shared\Domain\Entity\User;
use App\WhatsAppIntegration\Domain\Entity\MessageTemplate;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CampaignRepository::class)]
class Campaign
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'campaigns')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tenant $tenant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'campaigns')]
    #[ORM\JoinColumn(nullable: false)]
    private ?MessageTemplate $template = null;

    #[ORM\ManyToMany(targetEntity: ContactList::class, inversedBy: 'campaigns')]
    private Collection $contactLists;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(enumType: CampaignStatus::class)]
    private ?CampaignStatus $status = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $scheduledAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, MessageLog>
     */
    #[ORM\OneToMany(targetEntity: MessageLog::class, mappedBy: 'campaign')]
    private Collection $messageLogs;

    public function __construct()
    {
        $this->messageLogs = new ArrayCollection();
        $this->contactLists = new ArrayCollection();
    }

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

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): void
    {
        $this->createdBy = $createdBy;
    }

    public function getTemplate(): ?MessageTemplate
    {
        return $this->template;
    }

    public function setTemplate(?MessageTemplate $template): static
    {
        $this->template = $template;

        return $this;
    }

    public function getContactLists(): Collection
    {
        return $this->contactLists;
    }

    public function addContactList(ContactList $contactList): static
    {
        if (!$this->contactLists->contains($contactList)) {
            $this->contactLists->add($contactList);
        }
        return $this;
    }

    public function removeContactList(ContactList $contactList): static
    {
        $this->contactLists->removeElement($contactList);
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStatus(): ?CampaignStatus
    {
        return $this->status;
    }

    public function setStatus(CampaignStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getScheduledAt(): ?\DateTimeImmutable
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(?\DateTimeImmutable $scheduledAt): static
    {
        $this->scheduledAt = $scheduledAt;

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

    /**
     * @return Collection<int, MessageLog>
     */
    public function getMessageLogs(): Collection
    {
        return $this->messageLogs;
    }

    public function addMessageLog(MessageLog $messageLog): static
    {
        if (!$this->messageLogs->contains($messageLog)) {
            $this->messageLogs->add($messageLog);
            $messageLog->setCampaign($this);
        }

        return $this;
    }

    public function removeMessageLog(MessageLog $messageLog): static
    {
        if ($this->messageLogs->removeElement($messageLog)) {
            // set the owning side to null (unless already changed)
            if ($messageLog->getCampaign() === $this) {
                $messageLog->setCampaign(null);
            }
        }

        return $this;
    }
}
