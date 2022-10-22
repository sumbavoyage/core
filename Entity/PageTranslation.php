<?php

namespace Svs\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslation;

/**
 * @ORM\Entity()
 */
class PageTranslation extends AbstractTranslation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"post_write", "translations"})
     */
    protected $locale;

    /**
     * @ORM\ManyToOne(targetEntity="Page", inversedBy="translations")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $h1;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setH1(string $h1): void
    {
        $this->h1 = $h1;
    }

    public function getH1(): ?string
    {
        return $this->h1;
    }

    public function __toString()
    {
        return $this->title;
    }
}
