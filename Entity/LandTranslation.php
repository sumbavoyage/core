<?php

namespace Svs\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslation;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity()
 */
class LandTranslation extends AbstractTranslation
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
     * @ORM\ManyToOne(targetEntity="Land", inversedBy="translations")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string", length=255)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $introText1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $introText2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $introText3;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setIntroText1(?string $introText1): void
    {
        $this->introText1 = $introText1;
    }

    public function getIntroText1(): ?string
    {
        return $this->introText1;
    }

    public function setIntroText2(?string $introText2): void
    {
        $this->introText2 = $introText2;
    }

    public function getIntroText2(): ?string
    {
        return $this->introText2;
    }

    public function setIntroText3(?string $introText3): void
    {
        $this->introText3 = $introText3;
    }

    public function getIntroText3(): ?string
    {
        return $this->introText3;
    }

    public function __toString()
    {
        return $this->name;
    }
}
