<?php

namespace App\Entity;

use App\Repository\BookingOrderRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingOrderRepository::class)]
class BookingOrder
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(name:'user_id')]
    #[ORM\ManyToOne(inversedBy: 'bookingOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\Column]
    private ?bool $status = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $booking_date_time = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(inversedBy: 'bookingOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private ?BookingTable $booking_table = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function isStatus(): ?bool
    {
        return $this->status;
    }

    public function setStatus(bool $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getBookingDateTime(): ?\DateTimeInterface
    {
        return $this->booking_date_time;
    }

    public function setBookingDateTime(\DateTimeInterface $booking_date_time): self
    {
        $this->booking_date_time = $booking_date_time;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getBookingTable(): ?BookingTable
    {
        return $this->booking_table;
    }

    public function setBookingTable(?BookingTable $booking_table): self
    {
        $this->booking_table = $booking_table;

        return $this;
    }
}
