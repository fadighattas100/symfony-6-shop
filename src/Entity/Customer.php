<?php

namespace App\Entity;

use App\Repository\CustomerRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CustomerRepository::class)]
class Customer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private int $id;

    #[Groups(["customer:r", "customer:w"])]
    #[Assert\NotBlank(['message' => "Name is required."])]
    #[ORM\Column(type: 'string', length: 255)]
    private string $name;

    #[Groups(["customer:r", "customer:w"])]
    #[ORM\Column(type: 'string', length: 255)]
    private string $email;

    #[Groups(["customer:r", "customer:w"])]
    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private string $phoneNumber;

//    #[ORM\OneToOne(mappedBy: 'Customer', targetEntity: Cart::class, cascade: ['persist', 'remove'])]
//    private ?Cart $cart;

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

//    public function getCart(): ?Cart
//    {
//        return $this->cart;
//    }
//
//    public function setCart(Cart $cart): self
//    {
//        // set the owning side of the relation if necessary
//        if ($cart->getCustomer() !== $this) {
//            $cart->setCustomer($this);
//        }
//
//        $this->cart = $cart;
//
//        return $this;
//    }
}
