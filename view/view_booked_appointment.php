<?php
class ViewBookedAppointment{
    private ?string $bookedAppointment;

    public function getBookedAppointment(): ?string { return $this->bookedAppointment; }
    public function setBookedAppointment(?string $bookedAppointment): self { $this->bookedAppointment = $bookedAppointment; return $this; }

    public function displayView():string{
        
        return $this->getBookedAppointment();
    }
}
?>