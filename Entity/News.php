<?php

namespace Svs\Core\Entity;

use Svs\Core\Entity\MediaObject;
use Svs\Core\Repository\NewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;

use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslatable;
use Locastic\ApiPlatformTranslationBundle\Model\TranslationInterface;

/**
 * @ORM\Entity(repositoryClass=NewsRepository::class)
 * @ApiResource(
 *     attributes={
 *         "filters"={"translation.groups"},
 *         "normalization_context"={"groups":{"post_read"}},
 *         "denormalization_context"={"groups":{"post_write"}}
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
class News extends AbstractTranslatable
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $date;

    /**
     * @Groups({"post_read"})
     */
    private $name;

    /**
     * @Groups({"post_read"})
     */
    private $description;

    /**
     * @Groups({"post_read"})
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"post_write", "translations"})
     */
    private $enabled;

    /**
     * @ORM\OneToMany(targetEntity=MediaObject::class, mappedBy="news")
     * @Groups({"post_write", "translations"})
     */
    public $images;

    /**
     * @ORM\OneToMany(targetEntity="NewsTranslation", mappedBy="translatable", fetch="EXTRA_LAZY", indexBy="locale", cascade={"PERSIST"}, orphanRemoval=true)
     *
     * @Groups({"post_write", "translations"})
     */
    protected $translations;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getName(): string
    {
        return $this->getTranslation()->getName();
    }

    public function setName(string $name): self
    {
        $this->getTranslation()->setName($name);
    }

    public function getSlug(): ?string
    {
        return $this->getTranslation()->getSlug();
    }

    public function setSlug(string $slug): void
    {
        $this->getTranslation()->setSlug($slug);
    }

    public function getDescription(): string
    {
        return $this->getTranslation()->getDescription();
    }

    public function setDescription(string $description): self
    {
        $this->getTranslation()->setDescription($description);
    }

    public function getShortDescription(): string
    {
        return $this->getTranslation()->getShortDescription();
    }

    public function setShortDescription(string $shortDescription): self
    {
        $this->getTranslation()->setShortDescription($shortDescription);
    }

    public function isEnabled(): ?bool
    {
        return $this->enabled;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;

        return $this;
    }

    protected function createTranslation(): TranslationInterface
    {
        return new NewsTranslation();
    }

    public function __toString()
    {
        return $this->getName();
    }
}
