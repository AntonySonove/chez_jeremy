<?php
class ViewIndex {
    private ?string $message;

    public function getMessage(): ?string { return $this->message; }
    public function setMessage(?string $message): self { $this->message = $message; return $this; }


    public function displayView():string{

        return "";
    }


}