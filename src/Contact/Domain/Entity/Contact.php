<?php

namespace App\Contact\Domain\Entity;

use App\Campaign\Domain\Entity\MessageLog;
use App\Contact\Infrastructure\Repository\ContactRepository;
use App\Shared\Domain\Entity\Tenant;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contacts')]
    #[ORM\JoinColumn(nullable: false)]
    private ?tenant $tenant = null;

    #[ORM\Column(length: 12)]
    private ?string $phone = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?array $tags = null;

    #[ORM\Column]
    private ?bool $optIn = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, ContactList>
     */
    #[ORM\ManyToMany(targetEntity: ContactList::class, mappedBy: 'contacts')]
    private Collection $lists;

    /**
     * @var Collection<int, MessageLog>
     */
    #[ORM\OneToMany(targetEntity: MessageLog::class, mappedBy: 'contact')]
    private Collection $messageLogs;

    public function __construct()
    {
        $this->lists = new ArrayCollection();
        $this->messageLogs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTenant(): ?tenant
    {
        return $this->tenant;
    }

    public function setTenant(?tenant $tenant): static
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

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

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    public function isOptIn(): ?bool
    {
        return $this->optIn;
    }

    public function setOptIn(bool $optIn): static
    {
        $this->optIn = $optIn;

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
     * @return Collection<int, ContactList>
     */
    public function getLists(): Collection
    {
        return $this->lists;
    }

    public function addList(ContactList $list): static
    {
        if (!$this->lists->contains($list)) {
            $this->lists->add($list);
            $list->addContact($this);
        }

        return $this;
    }

    public function removeList(ContactList $list): static
    {
        if ($this->lists->removeElement($list)) {
            $list->removeContact($this);
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
            $messageLog->setContact($this);
        }

        return $this;
    }

    public function removeMessageLog(MessageLog $messageLog): static
    {
        if ($this->messageLogs->removeElement($messageLog)) {
            // set the owning side to null (unless already changed)
            if ($messageLog->getContact() === $this) {
                $messageLog->setContact(null);
            }
        }

        return $this;
    }
}
