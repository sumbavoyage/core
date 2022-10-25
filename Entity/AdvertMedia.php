<?php

namespace Svs\Core\Entity;

use Svs\Core\Entity\MediaObject;
use Svs\Core\Repository\AdvertMediaRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=AdvertMediaRepository::class)
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"advert_media_read", "post_read"}},
 *         "denormalization_context"={"groups":{"advert_media_write", "post_write"}}
 *     },
 *     itemOperations={
 *         "get"={
 *             "method"="GET"
 *         },
 *         "put"={
 *             "method"="PUT",
 *             "normalization_context"={"groups":{"translations"}}
 *         }
 *     },
 *     collectionOperations={
 *         "get"={
 *             "method"="GET"
 *         },
 *         "post"={
 *             "method"="POST",
 *             "normalization_context"={"groups":{"translations"}}
 *         }
 *     }
 * )
 */
class AdvertMedia extends AbstractTranslatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @Groups({"advert_media_read", "post_read", "post_write", "translations"})
     */
    private $name;

    /**
     * @var MediaObject|null
     *
     * @ORM\ManyToOne(targetEntity=MediaObject::class, fetch="EAGER")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     * @ApiProperty(iri="http://schema.org/image")
     * @Groups({"advert_media_read", "post_read", "post_write", "translations"})
     */
    public $image;

    /**
     * @ORM\ManyToMany(targetEntity=Advert::class, mappedBy="images")
     */
    private $adverts;

    /**
     * @ORM\OneToMany(targetEntity="AdvertMediaTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     * @Groups({"advert_media_read", "post_write", "translations"})
     */
    protected $translations;

    /**
     * @Groups({"advert_media_read", "post_read", "post_write", "translations"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advert_media_read", "post_read", "post_write", "translations"})
     */
    private $titleTag;

    /**
     * @Groups({"advert_media_read", "post_read", "post_write", "translations"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"advert_media_read", "post_read", "post_write", "translations"})
     */
    private $hasButton;

    /**
     * @Groups({"advert_media_read", "post_read", "post_write", "translations"})
     */
    private $buttonText;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"advert_media_read", "post_read", "post_write", "translations"})
     */
    private $buttonRoute;

    public function __construct()
    {
        parent::__construct();
        $this->adverts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->getTranslation()->getName();
    }

    public function setName(string $name): void
    {
        $this->getTranslation()->setName($name);
    }

    /**
     * @return Collection<int, Advert>
     */
    public function getAdverts(): Collection
    {
        return $this->adverts;
    }

    public function addAdvert(Advert $advert): self
    {
        if (!$this->adverts->contains($advert)) {
            $this->adverts[] = $advert;
            $advert->addImage($this);
        }

        return $this;
    }

    public function removeAdvert(Advert $advert): self
    {
        if ($this->adverts->removeElement($advert)) {
            $advert->removeImage($this);
        }

        return $this;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new AdvertMediaTranslation();
    }

    public function getTitle(): ?string
    {
        return $this->getTranslation()->getTitle();
    }

    public function setTitle(?string $title): void
    {
        $this->getTranslation()->setTitle($title);
    }

    public function getTitleTag(): ?string
    {
        return $this->titleTag;
    }

    public function setTitleTag(?string $titleTag): self
    {
        $this->titleTag = $titleTag;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(?string $description): void
    {
        $this->getTranslation()->setDescription($description);
    }

    public function isHasButton(): ?bool
    {
        return $this->hasButton;
    }

    public function setHasButton(bool $hasButton): self
    {
        $this->hasButton = $hasButton;

        return $this;
    }

    public function getButtonText(): ?string
    {
        return $this->getTranslation()->getButtonText();
    }

    public function setButtonText(?string $buttonText): void
    {
        $this->getTranslation()->setButtonText($buttonText);
    }

    public function getButtonRoute(): ?string
    {
        return $this->buttonRoute;
    }

    public function setButtonRoute(?string $buttonRoute): self
    {
        $this->buttonRoute = $buttonRoute;

        return $this;
    }

    public function __toString()
    {
        return !empty($this->getName()) ? $this->getName() : $this->getTitle();
    }
}
