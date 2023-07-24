<?php

namespace App\Entity;

use App\Entity\SonataMediaBundle\Media;
use App\Repository\ParagraphRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * @ORM\Entity(repositoryClass=ParagraphRepository::class)
 */
class Paragraph implements TranslatableInterface
{
    use TranslatableTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Media::class)
     */
    private $media;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $disposition;

    /**
     * @ORM\ManyToOne(targetEntity=Page::class, inversedBy="paragraphs")
     */
    private $page;

    public function __toString()
    {
        return $this->getDisposition();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMedia(): ?Media
    {
        return $this->media;
    }

    public function setMedia(?Media $media): self
    {
        $this->media = $media;

        return $this;
    }

    public function getDisposition(): ?string
    {
        return $this->disposition;
    }

    public function setDisposition(string $disposition): self
    {
        $this->disposition = $disposition;

        return $this;
    }

    public function getPage(): ?Page
    {
        return $this->page;
    }

    public function setPage(?Page $page): self
    {
        $this->page = $page;

        return $this;
    }

    public function __call($method, $arguments)
    {
        return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }
}
