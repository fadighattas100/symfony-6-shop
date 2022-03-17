<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[Groups(["product:r"])]
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[Groups(["product:r", "product:w"])]
    #[Assert\NotBlank(['message' => "Code is required.", 'groups' => ['product:c']])]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $code;

    #[Groups(["product:r", "product:w"])]
    #[Assert\NotBlank(['message' => "Title is required.", 'groups' => ['product:c']])]
    #[ORM\Column(type: 'string', length: 255)]
    private ?string $title;

    #[Groups(["product:r", "product:w"])]
    #[Assert\NotBlank(['message' => "Price is required.", 'groups' => ['product:c']])]
    #[ORM\Column(type: 'float')]
    private ?float $price;

    #[Groups(["product:r", "product:w"])]
    #[Assert\Valid]
    #[ORM\ManyToOne(targetEntity: Category::class, cascade: ["persist"], inversedBy: 'products')]
    #[ORM\JoinColumn(name: "category_id", referencedColumnName: "id", nullable: false)]
    private ?Category $category;


//    #[ORM\ManyToMany(targetEntity: Cart::class, mappedBy: 'Product')]
//    private ArrayCollection $carts;

//    #[Pure] public function __construct()
//    {
//        $this->carts = new ArrayCollection();
//    }


    public function getId(): int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(?string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $Category): self
    {
        $this->category = $Category;

        return $this;
    }

//    /**
//     * @return Collection<int, Cart>
//     */
//    public function getCarts(): Collection
//    {
//        return $this->carts;
//    }
//
//    public function addCart(Cart $cart): self
//    {
//        if (!$this->carts->contains($cart)) {
//            $this->carts[] = $cart;
//            $cart->addProduct($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCart(Cart $cart): self
//    {
//        if ($this->carts->removeElement($cart)) {
//            $cart->removeProduct($this);
//        }
//
//        return $this;
//    }
}
