<?php

namespace App\Entity;

use App\Entity\SonataMediaBundle\Media;
use App\Entity\Traits\TimeStampableTrait;
use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Knp\DoctrineBehaviors\Contract\Entity\TranslatableInterface;
use Knp\DoctrineBehaviors\Model\Translatable\TranslatableTrait;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    use TimeStampableTrait;

    public const CONTACT_DEVIS = 'contact_devis';
    public const CONTACT_MORE_INFOS = 'contact_more_information';
    public const CONTACT_INTRA = 'contact_intra_information';
    public const CONTACT_OTHER = 'contact_other';

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="text")
     */
    private $message;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $conversionPage;


    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    public function getConversionPage(): ?string
    {
        return $this->conversionPage;
    }

    public function setConversionPage(string $conversionPage): self
    {
        $this->conversionPage = $conversionPage;

        return $this;
    }

    public function getTypeLabel(): ?string
    {

        $choices = [
            Contact::CONTACT_DEVIS =>  'Devis' ,
            Contact::CONTACT_MORE_INFOS => "Plus d'information" ,
            Contact::CONTACT_INTRA => 'Formule intra',
            Contact::CONTACT_OTHER => 'Contact',
        ];

        return $choices[$this->getType()];
    }

}
