<?php
class ModelAppointment{
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
    private ?string $phone;
    private ?int $postalCode;
    private ?int $age;
    
    private ?PDO $bdd;

    public function __construct(){
        $this->bdd = connect();
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

    public function getPhone(): ?string { return $this->phone; }
    public function setPhone(?string $phone): self { $this->phone = $phone; return $this; }

    public function getPostalCode(): ?int { return $this->postalCode; }
    public function setPostalCode(?int $postalCode): self { $this->postalCode = $postalCode; return $this; }

    public function getAge(): ?int { return $this->age; }
    public function setAge(?int $age): self { $this->age = $age; return $this; }

    //! RECUPERER LES COIFFEURS
    public function recoverHairdresser():array | string{

        try{

            $req=$this->getBdd()->prepare("SELECT `name`, id_hairdresser FROM hairdressers");
            $req->execute();
            $data=$req->fetchAll(PDO::FETCH_ASSOC);

            return $data;

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //! RECUPERER LES CRENEAUX DISPONNIBLES
    public function recoverAvailableAppointments($date):array | string{
        try{

            // Vérifier si la date est un vendredi et exclure les créneaux de 18:00 et 18:30
            $dayOfWeek = date('w', strtotime($date)); // 0 = dimanche, 1 = lundi, ..., 5 = vendredi

            $timesQuery = "";
            if ($dayOfWeek == 5) {
                // Si c'est un vendredi, exclure 18:00 et 18:30
                $timesQuery = "AND `hour` NOT IN ('18:00', '18:30')";
            } 

            $req=$this->getBdd()->prepare("SELECT TIME_FORMAT(`hour`, '%H:%i') AS formatted_hour,`date` FROM appointments WHERE `date`= :selectedDate $timesQuery AND is_booked = 0  GROUP BY `hour` ORDER BY HOUR ASC");
            $req->bindParam(":selectedDate", $date, PDO::PARAM_STR);
            $req->execute();
            $data=$req->fetchAll(PDO::FETCH_ASSOC);

            return $data;

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //! RECUPERER LES CRENEAUX RESERVES
    public function recoverMadeAppointment($date):array | string{

        try{

            $req=$this->getBdd()->prepare("SELECT firstname, lastname, age, street, postal_code, town, email, phone, TIME_FORMAT(`hour`, '%H:%i') AS formatted_hour, `date`, benefit, `name` 
            FROM booked_appointments AS ba
            INNER JOIN hairdressers AS h
            ON ba.id_hairdresser=h.id_hairdresser
            WHERE `date`=? 
            ORDER BY HOUR ASC");

            $req->bindParam(1,$date,PDO::PARAM_STR);
    
            $req->execute();
            $data=$req->fetchAll(PDO::FETCH_ASSOC);
    
            return $data;

        }catch(PDOException $error){
            return $error->getMessage();
        }   
    }

    //! AJOUTER UN CRENEAU 
    public function AddAppointment():string{
        try{

            $hour=$this->getHour();
            $date=$this->getDate();
            $haidresser=$this->getHairdresser();

            $req=$this->getBdd()->prepare("INSERT INTO appointments (`hour`,`date`,id_hairdresser) VALUES (?,?,?)");
            $req->bindParam(1,$hour,PDO::PARAM_STR);
            $req->bindParam(2,$date,PDO::PARAM_STR);
            $req->bindParam(3,$haidresser,PDO::PARAM_INT);
            $req->execute();

            return "";

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //! PRENDRE UN RENDEZ-VOUS
    public function makeAnAppointment():string{

        try{

            $req=$this->getBdd()->prepare("INSERT INTO booked_appointments (firstname, lastname, age, street, postal_code, town, email, phone, `hour`, `date`, benefit, id_hairdresser) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
    
            $firstname=$this->getFirstname();
            $lastname=$this->getLastname();
            $age=$this->getAge();
            $street=$this->getStreet();
            $postalCode=$this->getPostalCode();
            $town=$this->getTown();
            $email=$this->getEmail();
            $phone=$this->getPhone();
            $hour=$this->getHour();
            $date=$this->getDate();
            $benefit=$this->getBenefit();
            $haidresser=$this->getHairdresser();

            $req->bindParam(1,$firstname, PDO::PARAM_STR);
            $req->bindParam(2,$lastname,PDO::PARAM_STR);
            $req->bindParam(3,$age,PDO::PARAM_INT);
            $req->bindParam(4,$street,PDO::PARAM_STR);
            $req->bindParam(5,$postalCode,PDO::PARAM_INT);
            $req->bindParam(6,$town,PDO::PARAM_STR);
            $req->bindParam(7,$email,PDO::PARAM_STR);
            $req->bindParam(8,$phone,PDO::PARAM_STR);
            $req->bindParam(9,$hour,PDO::PARAM_STR);
            $req->bindParam(10,$date,PDO::PARAM_STR);
            $req->bindParam(11,$benefit,PDO::PARAM_STR);
            $req->bindParam(12,$haidresser,PDO::PARAM_INT);
    
            $req->execute();
    
            return "<span style='color:green'>*Rendez-vous enregistré</span>";

        }catch(PDOException $error){
            return $error->getMessage();
        }   
    }

    //! PASSER UN CRENEAU EN "RESERVE"
    public function bookAnAppointment():string{

        try{

            $req=$this->getBdd()->prepare("UPDATE appointments SET is_booked=1 WHERE `hour`=? AND `date`=? AND id_hairdresser=?");

            $hour=$this->getHour();
            $date=$this->getDate();
            $hairdresser=$this->getHairdresser();

            $req->bindParam(1,$hour,PDO::PARAM_STR);
            $req->bindParam(2,$date,PDO::PARAM_STR);
            $req->bindParam(3,$hairdresser,PDO::PARAM_INT);

            $req->execute();

            return "";

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //! SUPPRIMER UN CRENEAU
    public function cancelAddAppointment():string{

        try{

             $req=$this->getBdd()->prepare("DELETE FROM appointments 
             WHERE `hour`=? AND `date`=? AND id_hairdresser=?");
            
            $hour=$this->getHour();
            $date=$this->getDate();
            $hairdresser=$this->getHairdresser();

            $req->bindParam(1,$hour,PDO::PARAM_STR);
            $req->bindParam(2,$date,PDO::PARAM_STR);
            $req->bindParam(3,$hairdresser,PDO::PARAM_INT);

            $req->execute();            

            return "";

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //! PASSER UN CRENEAU EN "DISPONIBLE"
    public function cancelBookAnAppointment():string{
        try{

            $req=$this->getBdd()->prepare("UPDATE appointments SET is_booked=0 WHERE `hour`=? AND `date`=?");

            $hour=$this->getHour();
            $date=$this->getDate();

            $req->bindParam(1,$hour,PDO::PARAM_STR);
            $req->bindParam(2,$date,PDO::PARAM_STR);

            $req->execute();

            return "";
        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //! RECUPERER UN CRENEAU DISPONNIBLE PAR SON HEURE
    public function getByHour():array | string{

        try{

            $req=$this->getBdd()->prepare("SELECT TIME_FORMAT(`hour`, '%H:%i') AS formatted_hour 
            FROM appointments 
            WHERE `date`=? AND is_booked=0 AND id_hairdresser=?");
    
            $date=$this->getDate();
            $hairdresser=$this->getHairdresser();
    
            $req->bindParam(1,$date,PDO::PARAM_STR);
            $req->bindParam(2,$hairdresser,PDO::PARAM_INT);
            $req->execute();
    
            $data=$req->fetchAll(PDO::FETCH_ASSOC);
            
            return $data;

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //! RECUPERE UN CRENEAU DISPONIBLE PAR UN COIFFEUR
    public function getByBooked():array | string{

        try{

            $req=$this->getBdd()->prepare("SELECT is_booked, `name`, h.id_hairdresser
            FROM appointments AS a
            INNER JOIN hairdressers AS h
            ON a.id_hairdresser=h.id_hairdresser
            WHERE `hour`=? AND `date`=? AND is_booked=0");
    
            $hour=$this->getHour();
            $date=$this->getDate();
    
            $req->bindParam(1,$hour,PDO::PARAM_STR);
            $req->bindParam(2,$date,PDO::PARAM_STR);
    
            $req->execute();
            $data=$req->fetchAll(PDO::FETCH_ASSOC);
    
            return $data;

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }
}
?>