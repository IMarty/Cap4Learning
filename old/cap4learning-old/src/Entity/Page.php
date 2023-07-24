<?php

namespace App\Entity;

use App\Entity\SonataMediaBundle\Media;
use App\Entity\Traits\TimeStampableTrait;
use App\Repository\PageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * @ORM\Entity(repositoryClass=PageRepository::class)
 */
class Page implements TranslatableInterface
{
    use TimeStampableTrait;
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Media::class, cascade={"persist", "remove"})
     */
    private $picture;

    /**
     * @ORM\OneToOne(targetEntity=News::class, cascade={"persist", "remove"})
     */
    private $linkedNews;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $menu;

    /**
     * @ORM\Column(type="boolean")
     */
    private $published;

    /**
     * @ORM\OneToMany(targetEntity=Paragraph::class, mappedBy="page", cascade={"remove", "persist"})
     */
    private $paragraphs;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->paragraphs = new ArrayCollection();
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

    public function getLinkedNews(): ?News
    {
        return $this->linkedNews;
    }

    public function setLinkedNews(?News $linkedNews): self
    {
        $this->linkedNews = $linkedNews;

        return $this;
    }

    public function getMenu(): ?string
    {
        return $this->menu;
    }

    public function setMenu(?string $menu): self
    {
        $this->menu = $menu;

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

    /**
     * @return Collection|Paragraph[]
     */
    public function getParagraphs(): Collection
    {
        return $this->paragraphs;
    }

    public function addParagraph(Paragraph $paragraph): self
    {
        if (!$this->paragraphs->contains($paragraph)) {
            $this->paragraphs[] = $paragraph;
            $paragraph->setPage($this);
        }

        return $this;
    }

    public function removeParagraph(Paragraph $paragraph): self
    {
        if ($this->paragraphs->removeElement($paragraph)) {
            if ($paragraph->getPage() === $this) {
                $paragraph->setPage(null);
                die();
            }
        }

        return $this;
    }
}
