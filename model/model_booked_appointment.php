<?php
class ModelBookedAppointment{
    private ?PDO $bdd;
    private ?int $id;
    private ?string $hour;
    private ?string $date;
    private? bool $booked;
    private ?string $firstname;
    private ?string $lastname ;
    private ?string $email;
    private ?string $street;
    private ?string $town;
    private ?string $benefit;
    private ?string $hairdresser;
    private ?int $phone;
    private ?int $postalCode;
    private ?int $age;

    public function connect():PDO{
        return $this->bdd=connect();
    }

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }

    public function getHour(): ?string { return $this->hour; }
    public function setHour(?string $hour): self { $this->hour = $hour; return $this; }

    public function getDate(): ?string { return $this->date; }
    public function setDate(?string $date): self { $this->date = $date; return $this; }

    public function getBooked(): bool { return $this->booked; }
    public function setBooked(bool $booked): self { $this->booked = $booked; return $this; }

    public function getBdd(): ?PDO { return $this->bdd; }
    public function setBdd(?PDO $bdd): self { $this->bdd = $bdd; return $this; }

    public function getFirstname(): ?string { return $this->firstname; }
    public function setFirstname(?string $firstname): self { $this->firstname = $firstname; return $this; }

    public function getLastname(): ?string { return $this->lastname; }
    public function setLastname(?string $lastname): self { $this->lastname = $lastname; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(?string $email): self { $this->email = $email; return $this; }

    public function getStreet(): ?string { return $this->street; }
    public function setStreet(?string $street): self { $this->street = $street; return $this; }

    public function getTown(): ?string { return $this->town; }
    public function setTown(?string $town): self { $this->town = $town; return $this; }

    public function getBenefit(): ?string { return $this->benefit; }
    public function setBenefit(?string $benefit): self { $this->benefit = $benefit; return $this; }

    public function getHairdresser(): ?string { return $this->hairdresser; }
    public function setHairdresser(?string $hairdresser): self { $this->hairdresser = $hairdresser; return $this; }

    public function getPhone(): ?int { return $this->phone; }
    public function setPhone(?int $phone): self { $this->phone = $phone; return $this; }

    public function getPostalCode(): ?int { return $this->postalCode; }
    public function setPostalCode(?int $postalCode): self { $this->postalCode = $postalCode; return $this; }

    public function getAge(): ?int { return $this->age; }
    public function setAge(?int $age): self { $this->age = $age; return $this; }

}
?>