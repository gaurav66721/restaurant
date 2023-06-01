<?php

namespace App\Entity;

use App\Repository\BookingTableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookingTableRepository::class)]
class BookingTable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $table_name = null;

    #[ORM\OneToMany(mappedBy: 'booking_table_id', targetEntity: BookingOrder::class, orphanRemoval: true)]
    private Collection $bookingOrders;

    public function __construct()
    {
        $this->bookingOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTableName(): ?string
    {
        return $this->table_name;
    }

    public function setTableName(string $table_name): self
    {
        $this->table_name = $table_name;

        return $this;
    }

    /**
     * @return Collection<int, BookingOrder>
     */
    public function getBookingOrders(): Collection
    {
        return $this->bookingOrders;
    }

    public function addBookingOrder(BookingOrder $bookingOrder): self
    {
        if (!$this->bookingOrders->contains($bookingOrder)) {
            $this->bookingOrders->add($bookingOrder);
            $bookingOrder->setBookingTableId($this);
        }

        return $this;
    }

    public function removeBookingOrder(BookingOrder $bookingOrder): self
    {
        if ($this->bookingOrders->removeElement($bookingOrder)) {
            // set the owning side to null (unless already changed)
            if ($bookingOrder->getBookingTableId() === $this) {
                $bookingOrder->setBookingTableId(null);
            }
        }

        return $this;
    }
}