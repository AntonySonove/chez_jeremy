<?php
class ViewAppointment{
    private ?string $hairdresser;
    private ?string $message;
    private ?string $messageMakeAnAppointment;
    private ?string $messageCancelAppointment;
    private ?string $availableAppointment;
    private ?string $bookedAppointment;
    private ?string $messageCancelMadeAppointment;

    public function getHairdresser(): ?string { return $this->hairdresser; }
    public function setHairdresser(?string $hairdresser): self { $this->hairdresser = $hairdresser; return $this; }

    public function getMessage(): ?string { return $this->message; }
    public function setMessage(?string $message): self { $this->message = $message; return $this; }

    public function getMessageMakeAnAppointment(): ?string { return $this->messageMakeAnAppointment; }
    public function setMessageMakeAnAppointment(?string $messageMakeAnAppointment): self { $this->messageMakeAnAppointment = $messageMakeAnAppointment; return $this; }

    public function getMessageCancelAppointment(): ?string { return $this->messageCancelAppointment; }
    public function setMessageCancelAppointment(?string $messageCancelAppointment): self { $this->messageCancelAppointment = $messageCancelAppointment; return $this; }

    public function getAvailableAppointment(): ?string { return $this->availableAppointment; }
    public function setAvailableAppointment(?string $availableAppointment): self { $this->availableAppointment = $availableAppointment; return $this; }

    public function getBookedAppointment(): ?string { return $this->bookedAppointment; }
    public function setBookedAppointment(?string $bookedAppointment): self { $this->bookedAppointment = $bookedAppointment; return $this; }
    
    public function getMessageCancelMadeAppointment(): ?string { return $this->messageCancelMadeAppointment; }
    public function setMessageCancelMadeAppointment(?string $messageCancelMadeAppointment): self { $this->messageCancelMadeAppointment = $messageCancelMadeAppointment; return $this; }

    public function displayView(){
        return'
        
<main id="mainAppointment">
    <div id=containerAppointment>
        <form action="" method="post" id="details">
            <p>Coordonnées</p>
            <p>
                <input type="text" name="firstname" placeholder="Prénom"><span style="color: red">*</span>
                <input type="text" name="lastname" placeholder="Nom"><span style="color: red">*</span>
                <input type="number" name="age" placeholder="Age">
            </p>
            <p>
                <input type="text" name="street" placeholder="Rue">
                <input type="number" name="postalCode" placeholder="Code postal">
                <input type="text" name="town" placeholder="Ville">
            </p>
            <p>
                <input type="email" name="email" placeholder="E-mail"><span style="color: red">*</span>
                <input type="tel" name="phone" placeholder="Téléphone" minlength="10" maxlength="10"><span style="color: red">*</span>
            </p>
            <p>Prestation</p>
            <p>
                <select name="benefit">
                <option value="choice" selected>Choix de la prestation</option>
                    <optgroup label="Cheveux">
                        <option value="Coupe + Coiffage">Coupe + Coiffage Homme</option>
                        <option value="Dégradé américain">Dégradé américain (à blanc)</option>
                        <option value="Coupe en brosse">Coupe en brosse</option>
                        <option value="Coupe enfant">Coupe enfant (-de 12 ans)</option>
                    </optgroup>
                    <optgroup label="Barbe">
                        <option value="Taille de barbe">Taille de barbe (taillage et traçage au rasoir)</option>
                    </optgroup>
                    <optgroup label="Forfaits">
                        <option value="Shampoing + Coupe + Coiffage">Shampoing + Coupe + Coiffage</option>
                        <option value="Coupe + Coiffage + Taille de barbe">Coupe + Coiffage + Taille de barbe (finition rasoir)</option>
                    </optgroup>
                </select>
            <p>
                <input id="dateInput" type="date" name="date">
                
                <select id="hairdresser" name="hairdresser">
                    <option value="choice">Choix du coiffeur</option>
                    '.$this->getHairdresser().'
                </select>
            </p>
            <p>
                <select name="hour" id="selectHour">
                    <option value="choice" selected>Heure</option>
                    '.$this->getAvailableAppointment().'
                </select>
            </p>
            <p>
                <input type=submit name="submitMakeAnAppointment" value="Prendre rendez-vous">
                '.$this->getMessageMakeAnAppointment().'
            </p>
        </form>
            <form action="" method="post" id= appointmentList>
            
            <p id="appointmentListButton">▼ Liste des rendez-vous <input id="inputDisplayAppointment" type="date" name="inputDisplayAppointment"></p>
            <ul id="displayBookedAppointments" class="">
            </ul>
        </form>
    
        <form id= addAppointment action="" method="post">
            <p>
                Ajouter des créneaux
            </p>
            
            <p>
                <input id="dateAddAppointment" type="date" name="dateAddAppointment">

                <select name="hairdresser">
                '.$this->getHairdresser().'
            </select>
            </p>
            
            <p>
                <input type="submit" name="submitAddAppointment" id="" value= "Ajouter des créneaux" style="color: green">
                <input type="submit" name="cancelAddAppointment" id="" value= "Supprimer des créneaux" style="color: red">
                '.$this->getMessage().'
                '.$this->getMessageCancelAppointment().'
            </p>
            <p>
                <button type="button" id="toggleCheckboxes">Tout sélectionner / Désélectionner</button>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="09:00" value="09:00" >
                <label for="09:00">09:00</label>

                <input type="checkbox" name="checkboxAddAppointment[]" id="09:30" value="09:30" >
                <label for="09:30">09:30</label>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="10:00" value="10:00" >
                <label for="10:00">10:00</label>
                
                <input type="checkbox" name="checkboxAddAppointment[]" id="10:30" value="10:30" >
                <label for="10:30">10:30</label>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="11:00" value="11:00" >
                <label for="11:00">11:00</label>

                <input type="checkbox" name="checkboxAddAppointment[]" id="11:30" value="11:30" >
                <label for="11:30">11:30</label>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="12:00" value="12:00" >
                <label for="12:00">12:00</label>

                <input type="checkbox" name="checkboxAddAppointment[]" id="12:30" value="12:30" >
                <label for="12:30">12:30</label>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="13:00" value="13:00" >
                <label for="13:00">13:00</label>

                <input type="checkbox" name="checkboxAddAppointment[]" id="13:30" value="13:30" >
                <label for="13:30">13:30</label>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="14:00" value="14:00" >
                <label for="14:00">14:00</label>

                <input type="checkbox" name="checkboxAddAppointment[]" id="14:30" value="14:30" >
                <label for="14:30">14:30</label>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="15:00" value="15:00" >
                <label for="15:00">15:00</label>

                <input type="checkbox" name="checkboxAddAppointment[]" id="15:30" value="15:30" >
                <label for="15:30">15:30</label>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="16:00" value="16:00" >
                <label for="16:00">16:00</label>

                <input type="checkbox" name="checkboxAddAppointment[]" id="16:30" value="16:30" >
                <label for="16:30">16:30</label>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="17:00" value="17:00" >
                <label for="17:00">17:00</label>

                <input type="checkbox" name="checkboxAddAppointment[]" id="17:30" value="17:30" >
                <label for="17:30">17:30</label>
            </p>
            <p>
                <input type="checkbox" name="checkboxAddAppointment[]" id="18:00" value="18:00" >
                <label for="18:00">18:00</label>

                <input type="checkbox" name="checkboxAddAppointment[]" id="18:30" value="18:30" >
                <label for="18:30">18:30</label>
            </p>
        </form>
    </div>
</main>
<script src="/repository/chez_jeremy/src/script/appointment.js"></script>
</body>
</html>   
';
    }

}
?>
