<?php

namespace Svs\Core\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Locastic\ApiPlatformTranslationBundle\Model\AbstractTranslation;

/**
 * @ORM\Entity()
 */
class RouteStageTranslation extends AbstractTranslation
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
     * @ORM\ManyToOne(targetEntity="RouteStage", inversedBy="translations")
     */
    protected $translatable;

    /**
     * @ORM\Column(type="string")
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
     * @ORM\Column(type="text", nullable=true)
     *
     * @Groups({"post_read", "post_write", "translations"})
     */
    private $hotelDescription;

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

    public function setHotelDescription(string $hotelDescription): void
    {
        $this->hotelDescription = $hotelDescription;
    }

    public function getHotelDescription(): ?string
    {
        return $this->hotelDescription;
    }

    public function __toString()
    {
        return $this->name;
    }
}
