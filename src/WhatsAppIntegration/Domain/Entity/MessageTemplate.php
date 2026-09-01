<?php

namespace App\WhatsAppIntegration\Domain\Entity;

use App\Campaign\Domain\Entity\Campaign;
use App\Shared\Domain\Entity\Tenant;
use App\WhatsAppIntegration\Domain\Enum\TemplateCategory;
use App\WhatsAppIntegration\Infrastructure\Repository\MessageTemplateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessageTemplateRepository::class)]
class MessageTemplate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'messageTemplates')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tenant $tenant = null;

    #[ORM\Column(length: 255)]
    private ?string $metaTemplateName = null;

    #[ORM\Column(enumType: TemplateCategory::class)]
    private ?TemplateCategory $category = null;

    #[ORM\Column(length: 10)]
    private ?string $language = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $bodyText = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Campaign>
     */
    #[ORM\OneToMany(targetEntity: Campaign::class, mappedBy: 'template')]
    private Collection $campaigns;

    public function __construct()
    {
        $this->campaigns = new ArrayCollection();
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

    public function getMetaTemplateName(): ?string
    {
        return $this->metaTemplateName;
    }

    public function setMetaTemplateName(string $metaTemplateName): static
    {
        $this->metaTemplateName = $metaTemplateName;

        return $this;
    }

    public function getCategory(): ?TemplateCategory
    {
        return $this->category;
    }

    public function setCategory(TemplateCategory $category): static
    {
        $this->category = $category;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getBodyText(): ?string
    {
        return $this->bodyText;
    }

    public function setBodyText(string $bodyText): static
    {
        $this->bodyText = $bodyText;

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
            $campaign->setTemplate($this);
        }

        return $this;
    }

    public function removeCampaign(Campaign $campaign): static
    {
        if ($this->campaigns->removeElement($campaign)) {
            // set the owning side to null (unless already changed)
            if ($campaign->getTemplate() === $this) {
                $campaign->setTemplate(null);
            }
        }

        return $this;
    }
}
