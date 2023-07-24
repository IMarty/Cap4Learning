<?php

namespace App\Entity;

use App\Entity\Traits\TimeStampableTrait;
use App\Repository\TrainingCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * @ORM\Entity(repositoryClass=TrainingCategoryRepository::class)
 */
class TrainingCategory implements TranslatableInterface
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
     * @ORM\OneToOne(targetEntity=TrainingCategory::class, cascade={"persist", "remove"})
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Training::class, mappedBy="category")
     */
    private $trainings;

    /**
     * @ORM\Column(type="integer")
     */
    private $weight;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->trainings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getParent(): ?TrainingCategory
    {
        return $this->parent;
    }

    public function setParent(?TrainingCategory $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle() ?? '';
    }


    public function __call($method, $arguments)
    {
        return \Symfony\Component\PropertyAccess\PropertyAccess::createPropertyAccessor()->getValue($this->translate(), $method);
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->setCategory($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->removeElement($training)) {
            // set the owning side to null (unless already changed)
            if ($training->getCategory() === $this) {
                $training->setCategory(null);
            }
        }

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
}
