<?php

namespace Svs\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslation;

/**
 * @ORM\Entity()
 */
class ExclusionTranslation extends AbstractTranslation
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
     * @ORM\ManyToOne(targetEntity="Exclusion", inversedBy="translations")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string")
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $name;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->name;
    }
}
