<?php

namespace App\Entity;

use App\Repository\FieldRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=FieldRepository::class)
 */
class Field
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $fieldKey;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $fieldValue;

    /**
     * @ORM\ManyToOne(targetEntity=Contact::class, inversedBy="fields")
     */
    private $contact;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFieldKey(): ?string
    {
        return $this->fieldKey;
    }

    public function setFieldKey(string $fieldKey): self
    {
        $this->fieldKey = $fieldKey;

        return $this;
    }

    public function getFieldValue(): ?string
    {
        return $this->fieldValue;
    }

    public function setFieldValue(?string $fieldValue): self
    {
        $this->fieldValue = $fieldValue;

        return $this;
    }

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): self
    {
        $this->contact = $contact;

        return $this;
    }
}
