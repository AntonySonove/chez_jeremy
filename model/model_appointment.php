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
    public function recoverAvailableAppointments($date, $hairdresser):array | string{
        // var_dump($hairdresser);
        try{
            // Vérifier si la date est un vendredi et exclure les créneaux de 18:00 et 18:30
            $dayOfWeek = date('w', strtotime($date)); // 0 = dimanche, 1 = lundi, ..., 5 = vendredi

            $timesQuery = "";
            if ($dayOfWeek == 5) {
                // Si c'est un vendredi, exclure 18:00 et 18:30
                $timesQuery = "AND `hour` NOT IN ('18:00', '18:30')";
            } 

            //* stockage de la requête SQL dans une variable pour ensuite l'utiliser dans une requête préparée

            // stockage de la requête dans une variable
            $sql="SELECT TIME_FORMAT(`hour`, '%H:%i') AS formatted_hour
            FROM appointments AS a
            INNER JOIN hairdressers AS h
            ON a.id_hairdresser=h.id_hairdresser
            WHERE `date`= :selectedDate $timesQuery AND is_booked = 0";
            
            // condition si un coiffeur à été sélectionné
            if($hairdresser != "choice"){
                $sql .= " AND a.id_hairdresser = :selectedHairdresser"; //? ne pas oublier l'espace entre " et AND pour la concaténation
            }

            $sql .= " GROUP BY `hour` ORDER BY HOUR ASC"; //? idem ici pour l'espace entre " et GROUP

            //* Préparation de la requête

            // on peut passer la variable contenant la requête en paramètre pour le prepare 
            $req=$this->getBdd()->prepare($sql);

            $req->bindParam(":selectedDate", $date, PDO::PARAM_STR);

            // condition si un coiffeur à été sélectionné
            if($hairdresser != "choice"){

                $req->bindParam(":selectedHairdresser", $hairdresser, PDO::PARAM_INT);
            }

            $req->execute();
            $data=$req->fetchAll(PDO::FETCH_ASSOC);

            return $data;

        }catch(PDOException $error){
            $error->getMessage();
            return [];
        }
    }

    //! RECUPERER LES CRENEAUX RESERVES
    public function recoverMadeAppointment($date):array | string{

        try{

            $req=$this->getBdd()->prepare("SELECT firstname, lastname, age, street, postal_code, town, email, phone, TIME_FORMAT(ba.`hour`, '%H:%i') AS formatted_hour, ba.`date`, benefit, `name`, ba.id_hairdresser 
            FROM booked_appointments AS ba
            INNER JOIN hairdressers AS h
            ON ba.id_hairdresser = h.id_hairdresser
            INNER JOIN appointments AS a
            ON h.id_hairdresser = a.id_hairdresser AND a.hour = ba.hour AND a.date = ba.date
            WHERE ba.`date`=? 
            ORDER BY ba.`hour` ASC");

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
            $hairdresser=$this->getHairdresser();

            $req=$this->getBdd()->prepare("INSERT INTO appointments (`hour`,`date`,id_hairdresser) VALUES (?,?,?)");
            $req->bindParam(1,$hour,PDO::PARAM_STR);
            $req->bindParam(2,$date,PDO::PARAM_STR);
            $req->bindParam(3,$hairdresser,PDO::PARAM_INT);
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
            $hairdresser=$this->getHairdresser();

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
            $req->bindParam(12,$hairdresser,PDO::PARAM_INT);
    
            $req->execute();
    
            return "<span style='color:green'>*Rendez-vous enregistré</span>";

        }catch(PDOException $error){
            return $error->getMessage();
        }   
    }

    //! RECUPERE UN CRENEAU DISPONIBLE
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

    //! ANNULER UN RENDEZ-VOUS
    public function cancelMadeAppointment($date):array | string{

        try{

            $req=$this->getBdd()->prepare("DELETE 
            FROM booked_appointments
            WHERE `hour`=? AND firstname=? AND lastname=? AND id_hairdresser=?");

            $hour=$this->getHour();
            $firstname=$this->getFirstname();
            $lastname=$this->getLastname();
            $hairdresser=$this->getHairdresser();

            $req->bindParam(1,$hour,PDO::PARAM_STR);
            $req->bindParam(2,$firstname,PDO::PARAM_STR);
            $req->bindParam(3,$lastname,PDO::PARAM_STR);
            $req->bindParam(4,$hairdresser,PDO::PARAM_INT);

            $req->execute();
            
            return "";

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }

    //! PASSER UN CRENEAU EN "DISPONIBLE"
    public function cancelBookAnAppointment($date):string{
        try{

            $req=$this->getBdd()->prepare("UPDATE appointments SET is_booked=0 WHERE `hour`=? AND id_hairdresser=?");

            $hour=$this->getHour();
            $hairdresser=$this->getHairdresser();

            $req->bindParam(1,$hour,PDO::PARAM_STR);
            $req->bindParam(2,$hairdresser,PDO::PARAM_INT);

            $req->execute();

            return "";

        }catch(PDOException $error){
            return $error->getMessage();
        }
    }
}
?>