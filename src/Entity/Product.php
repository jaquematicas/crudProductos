<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @UniqueEntity("name")
 * @UniqueEntity("code")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
 
 * @ORM\Column(type="string", length=255)
 * @Assert\Regex(
     *     pattern="/\s/",
     *     match=false,
     *     message="Este campo no puede tener espacios en blanco"
     * )

     * @Assert\Regex(
     *     pattern="/[^A-Za-z 0-9]/",
     *     match=false,
     *     message="Este campo no puede tener caracteres especiales"
     * )
      * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "The code must be at least {{ limit }} characters long",
     *      maxMessage = "The code cannot be longer than {{ limit }} characters"
     * )
*/
    private $code;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
    * @Assert\NotNull
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "The name must be at least {{ limit }} characters long",
     
     * )
    
     */
    private $name;

    /**
     * @ORM\Column(type="text")
    * @Assert\NotNull
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
      * @Assert\NotNull
     */
    private $brand;

       /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\NotNull
     */
    private $category;

    /**
     * @ORM\Column(type="float")
      * @Assert\NotNull
      * @Assert\Regex(
     *     pattern="/[^0-9(.{1})]/",
     *     match=false,
     *     message="The price cannot contain a number"
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")

     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

}
