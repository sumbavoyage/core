<?php

namespace Svs\Core\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiProperty;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="Gedmo\Sortable\Entity\Repository\SortableRepository")
 */
class TourRouteStagePosition
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Tour::class)
     */
    private $tour;

    /**
     * @ORM\ManyToOne(targetEntity=RouteStage::class)
     */
    private $routeStage;

    /**
     * @ORM\Column(name="position", type="integer")
     */
    private $position;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTour(): ?Tour
    {
        return $this->tour;
    }

    public function setTour(?Tour $tour): self
    {
        $this->tour = $tour;

        return $this;
    }

    public function getRouteStage(): ?RouteStage
    {
        return $this->routeStage;
    }

    public function setRouteStage(?RouteStage $routeStage): self
    {
        $this->routeStage = $routeStage;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }

    public function setPosition($position)
    {
        $this->position = $position;
    }

    public function __toString()
    {
        return $this->getTour()->getName() . ' - day ' . $this->getPosition() . ' - ' . $this->getRouteStage()->getName();
    }
}
