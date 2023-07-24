<?php

namespace App\Entity;

use App\Entity\SonataMediaBundle\Media;
use App\Entity\Traits\TimeStampableTrait;
use App\Repository\NewsRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * @ORM\Entity(repositoryClass=NewsRepository::class)
 */
class News implements TranslatableInterface
{
    use TranslatableTrait;
    use TimeStampableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class, cascade={"persist", "remove"})
     */
    private $picture;

    /**
     * @ORM\OneToOne(targetEntity=Training::class, cascade={"persist", "remove"})
     */
    private $linkedTraining;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function __toString(): ?string
    {
        return $this->getTitle();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?Media
    {
        return $this->picture;
    }

    public function setPicture(?Media $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getLinkedTraining(): ?Training
    {
        return $this->linkedTraining;
    }

    public function setLinkedTraining(?Training $linkedTraining): self
    {
        $this->linkedTraining = $linkedTraining;

        return $this;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function __call($method, $arguments)
    {
        return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
}
