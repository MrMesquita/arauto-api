<?php

namespace App\Shared\Domain\Entity;

use App\Campaign\Domain\Entity\Campaign;
use App\Campaign\Domain\Entity\MessageLog;
use App\Contact\Domain\Entity\Contact;
use App\Shared\Domain\Enum\TenantPlan;
use App\Shared\Infrastructure\Repository\TenantRepository;
use App\WhatsappIntegration\Domain\Entity\MessageTemplate;
use App\WhatsappIntegration\Domain\Entity\WhatsAppAccount;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TenantRepository::class)]
class Tenant
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(enumType: TenantPlan::class)]
    private ?TenantPlan $plan = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Contact>
     */
    #[ORM\OneToMany(targetEntity: Contact::class, mappedBy: 'tenant')]
    private Collection $contacts;

    /**
     * @var Collection<int, WhatsAppAccount>
     */
    #[ORM\OneToMany(targetEntity: WhatsAppAccount::class, mappedBy: 'tenant')]
    private Collection $whatsAppAccounts;

    /**
     * @var Collection<int, MessageTemplate>
     */
    #[ORM\OneToMany(targetEntity: MessageTemplate::class, mappedBy: 'tenant')]
    private Collection $messageTemplates;

    /**
     * @var Collection<int, Campaign>
     */
    #[ORM\OneToMany(targetEntity: Campaign::class, mappedBy: 'tenant')]
    private Collection $campaigns;

    /**
     * @var Collection<int, MessageLog>
     */
    #[ORM\OneToMany(targetEntity: MessageLog::class, mappedBy: 'tenant')]
    private Collection $messageLogs;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
        $this->whatsAppAccounts = new ArrayCollection();
        $this->messageTemplates = new ArrayCollection();
        $this->campaigns = new ArrayCollection();
        $this->messageLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPlan(): ?TenantPlan
    {
        return $this->plan;
    }

    public function setPlan(TenantPlan $plan): static
    {
        $this->plan = $plan;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * @return Collection<int, Contact>
     */
    public function getContacts(): Collection
    {
        return $this->contacts;
    }

    public function addContact(Contact $contact): static
    {
        if (!$this->contacts->contains($contact)) {
            $this->contacts->add($contact);
            $contact->setTenant($this);
        }

        return $this;
    }

    public function removeContact(Contact $contact): static
    {
        if ($this->contacts->removeElement($contact)) {
            // set the owning side to null (unless already changed)
            if ($contact->getTenant() === $this) {
                $contact->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, WhatsAppAccount>
     */
    public function getWhatsAppAccounts(): Collection
    {
        return $this->whatsAppAccounts;
    }

    public function addWhatsAppAccount(WhatsAppAccount $whatsAppAccount): static
    {
        if (!$this->whatsAppAccounts->contains($whatsAppAccount)) {
            $this->whatsAppAccounts->add($whatsAppAccount);
            $whatsAppAccount->setTenant($this);
        }

        return $this;
    }

    public function removeWhatsAppAccount(WhatsAppAccount $whatsAppAccount): static
    {
        if ($this->whatsAppAccounts->removeElement($whatsAppAccount)) {
            // set the owning side to null (unless already changed)
            if ($whatsAppAccount->getTenant() === $this) {
                $whatsAppAccount->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MessageTemplate>
     */
    public function getMessageTemplates(): Collection
    {
        return $this->messageTemplates;
    }

    public function addMessageTemplate(MessageTemplate $messageTemplate): static
    {
        if (!$this->messageTemplates->contains($messageTemplate)) {
            $this->messageTemplates->add($messageTemplate);
            $messageTemplate->setTenant($this);
        }

        return $this;
    }

    public function removeMessageTemplate(MessageTemplate $messageTemplate): static
    {
        if ($this->messageTemplates->removeElement($messageTemplate)) {
            // set the owning side to null (unless already changed)
            if ($messageTemplate->getTenant() === $this) {
                $messageTemplate->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Campaign>
     */
    public function getCampaigns(): Collection
    {
        return $this->campaigns;
    }

    public function addCampaign(Campaign $campaign): static
    {
        if (!$this->campaigns->contains($campaign)) {
            $this->campaigns->add($campaign);
            $campaign->setTenant($this);
        }

        return $this;
    }

    public function removeCampaign(Campaign $campaign): static
    {
        if ($this->campaigns->removeElement($campaign)) {
            // set the owning side to null (unless already changed)
            if ($campaign->getTenant() === $this) {
                $campaign->setTenant(null);
            }
        }

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
            $messageLog->setTenant($this);
        }

        return $this;
    }

    public function removeMessageLog(MessageLog $messageLog): static
    {
        if ($this->messageLogs->removeElement($messageLog)) {
            // set the owning side to null (unless already changed)
            if ($messageLog->getTenant() === $this) {
                $messageLog->setTenant(null);
            }
        }

        return $this;
    }
}
