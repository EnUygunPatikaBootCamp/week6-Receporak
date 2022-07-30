<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 *
 */
class Product
{

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private string $productName;

    /**
     * @ORM\Column(type="text", length=255)
     */
    private ?string $productDescription;

    /**
     * @ORM\Column(type="integer")
     */
    private int $productStock;

    /**
     * @ORM\Column(type="float")
     */
    private float $productPrice;

    /**
     * @ORM\Column(type="datetime")
     */
    private \DateTimeInterface $productCreatedAt;

    public function __construct()
    {

    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductName(): ?string
    {
        return $this->productName;
    }

    public function setProductName(string $productName): self
    {
        $this->productName = $productName;

        return $this;
    }

    public function getProductDescription(): ?string
    {
        return $this->productDescription;
    }

    public function setProductDescription(?string $productDescription): self
    {
        $this->productDescription = $productDescription;

        return $this;
    }

    public function getProductStock(): ?int
    {
        return $this->productStock;
    }

    public function setProductStock(int $productStock): self
    {
        $this->productStock = $productStock;

        return $this;
    }

    public function getProductPrice(): ?float
    {
        return $this->productPrice;
    }

    public function setProductPrice(float $productPrice): self
    {
        $this->productPrice = $productPrice;

        return $this;
    }

    public function getProductCreatedAt(): ?\DateTimeInterface
    {
        return $this->productCreatedAt;
    }

    public function setProductCreatedAt(\DateTimeInterface $productCreatedAt): self
    {
        $this->productCreatedAt = $productCreatedAt;

        return $this;
    }
}
