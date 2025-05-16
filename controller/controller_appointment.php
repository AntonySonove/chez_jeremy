<?php
// include "../utils/utils.php";
// include "../model/model_appointment.php";
// include "../controller/controller_header.php";
// include "../view/view_appointment.php";

class ControllerAppointment{
    private ?ViewAppointment $viewAppointment;
    private ?ModelAppointment $modelAppointment;

    public function __construct(ViewAppointment $viewAppointment, ModelAppointment $modelAppointment,){
        $this->viewAppointment=$viewAppointment;
        $this->modelAppointment=$modelAppointment;
    }

    public function getViewAppointment(): ?ViewAppointment { return $this->viewAppointment; }
    public function setViewAppointment(?ViewAppointment $viewAppointment): self { $this->viewAppointment = $viewAppointment; return $this; }

    public function getModelAppointment(): ?ModelAppointment { return $this->modelAppointment; }
    public function setModelAppointment(?ModelAppointment $modelAppointment): self { $this->modelAppointment = $modelAppointment; return $this; }

    //! INSERER LES COIFFEURS DANS LES SELECT
    public function displayHairdresser():string{

        $hairdresserList=''; //variable d'affichage
        foreach($this->modelAppointment->recoverHairdresser() as $element){
            
            $hairdresserList=$hairdresserList.'<option value='.$element["id_hairdresser"].'>'.$element["name"].'</option>';    
        }
        return $hairdresserList;
    }

    //! AFFICHER LES CRENEAUX DISPONIBLES
    public function displayAppointment():string{

        //* récupération de la date
        $date=$_GET["date"] ?? null;
        $hairdresser=$_GET["hairdresser"] ?? "choice";

        //*affichage dans un menu select
        if ($date){

            $availableAppointment=""; //? variable d'affichage
            
            echo "<option value='choice' selected >Heure</option>"; //? option sélectionnée par défaut

            foreach($this->modelAppointment->recoverAvailableAppointments($date, $hairdresser) as $appointment){ //? boucle pour générer les créneaux

                $hour= htmlspecialchars($appointment["formatted_hour"], ENT_QUOTES, 'UTF-8');

                $availableAppointment.="
                <option value='$hour'>$hour</option>
                ";
            }
            
            echo $availableAppointment;
            exit; //? stopper le script (sinon il génère toute la page HTML)

        }
        return "";
    }

    //! AFFICHER LES RENDEZ-VOUS
    public function displayBookedAppointment():string{

        //* récupération de la date
        $date=$_GET["date"]?? null;

        if($date){

            //* variable d'affichage
            $bookedAppointment="";
            
            foreach($this->modelAppointment->recoverMadeAppointment($date) as $element){
    
                $bookedAppointment=$bookedAppointment.'
                    <li>'.$element.'</li>
                ';
            }
            echo $bookedAppointment;
            exit;
        }else{
            return "Aucun rendez-vous prévu";
        }
    }
    

    //! AJOUTER UN CRENEAU
    public function addAppointment():string{

        //* Vérifier si on rçcoit le formulaire
        if(!isset($_POST["submitAddAppointment"])){

            return "";
        }
        
        //* Vérifier si la date est renseignée
        if (empty($_POST["dateAddAppointment"])){

            return "<span style='color: red'>*Date non saisie</span>";
        }

        //* Vérifier que le coiffeur est renseigné 
        if (empty($_POST["hairdresser"])){

            return "<span style='color: red'>*Coiffeur non renseigné</span>";
        }

        //* Vérifier qu'au moins une checkbox est sélectionnée
        if (!isset($_POST["checkboxAddAppointment"])){

            return "<span style='color: red'>*Selectionnez au moins un créneau</span>";
        }

        //* Nettoyage de la date
        $date=sanitize($_POST["dateAddAppointment"]);
        
        //* Nettoyage du coiffeur
        $hairdresser=sanitize($_POST["hairdresser"]);

        //* Création d'un tableau pour récupérer toutes les checkbox pour boucler dessus
        $cleanedCheckbox=[];

        //* vériefier que les horraires sont autorisées
        $horairesAutorises = [
            "09:00", "09:30", "10:00", "10:30", "11:00", "11:30",
            "12:00", "12:30", "13:00", "13:30", "14:00", "14:30",
            "15:00", "15:30", "16:00", "16:30", "17:00", "17:30",
            "18:00", "18:30"
        ];
        
        if (isset($_POST["checkboxAddAppointment"])) {

            foreach ($_POST["checkboxAddAppointment"] as $element) {

                if (!in_array($element, $horairesAutorises)) {

                    return "erreur";
                }
            }
        }

        //* Boucle pour nettoyer les données des checkbox
        foreach($_POST["checkboxAddAppointment"] as $element){
            $cleanedCheckbox[]=sanitize($element);
        }

        //* Récupération des créneaux existants dans la bdd (pour éviter les doublons)
        $this->getModelAppointment()->setDate($date)->setHairdresser($hairdresser);
        $data=$this->getModelAppointment()->getByHour();

        //* Vérifier si les créneaux existent
        foreach($cleanedCheckbox as $element){
            
            foreach($data as $elementData){
              
                if($elementData["formatted_hour"]==$element){

                    return "<span style='color: red'>*Créneau(x) déjà enregistré(s)</span>";
                }
            }
                
            //* Ajout des créneaux
            $this->getModelAppointment()->setHour($element)->setDate($date)->setHairdresser($hairdresser);
            $this->getModelAppointment()->AddAppointment();
        }       

        return "<span style='color:green'>*Créneau(x) ajouté(s)</span>";
    }

    //! SUPPRIMER UN CRENEAU
    public function cancelAddAppointment(){
            //* Vérifier si on reçoit le formulaire
            if(!isset($_POST["cancelAddAppointment"])){

                return "";
            }

            //* Vérifier si la date est renseignée
            if (empty($_POST["dateAddAppointment"])){
    
                return "<span style='color: red'>*Date non saisie</span>";
            }
            //* Vérifier qu'au moins une checkbox est sélectionnée
            if (!isset($_POST["checkboxAddAppointment"])){
    
                return "<span style='color: red'>*Selectionnez au moins un créneau</span>";
            }
    
            //* Nettoyage de la date et du coiffeur
            $date=sanitize($_POST["dateAddAppointment"]);
            $hairdresser=sanitize($_POST["hairdresser"]);
    
            //* Création d'un tableau pour récupérer toutes les checkbox pour boucler dessus
            $cleanedCheckbox=[]; 
    
            //* Boucle pour nettoyer les données des checkbox
            foreach($_POST["checkboxAddAppointment"] as $element){
                $cleanedCheckbox[]=sanitize($element);
            }
    
            //* suppression des créneaux
            foreach ($cleanedCheckbox as $element) {
                $this->getModelAppointment()->setHour($element)->setDate($date)->setHairdresser($hairdresser);
                $this->getModelAppointment()->cancelAddAppointment();
            }
            return "<span style='color:green'>*Créneau(x) supprimé(s)</span>";
        }       

    //! PRENDRE UN RENDEZ-VOUS
    public function makeAnAppointment():string{
        
        //* Vérifier qu'on reçoit le formulaire
        if(!isset($_POST["submitMakeAnAppointment"])){

            return "";
        }
        
        //* Vérifier que les champs obligatoirs ne sont pas vides
        if (empty($_POST["firstname"]) || empty($_POST["lastname"]) || empty($_POST["email"]) || empty($_POST["phone"]) || empty($_POST["benefit"]) || empty($_POST["hour"]) || empty($_POST["date"])){

            return "<span style='color: red'>*Veuillez saisir tous les champs obligatoirs</span>";
        }
        if($_POST["benefit"]== "choice"){
            return "<span style='color: red'>*Veuillez choisir une prestation</span>";
        }
        //* Nettoyage des données
        $firstname=sanitize($_POST["firstname"]);
        $lastname=sanitize($_POST["lastname"]);
        $age=sanitize($_POST["age"]) ?:null;
        $street=sanitize($_POST["street"]) ?:null;
        $postalCode=sanitize($_POST["postalCode"]) ?:null;
        $town=sanitize($_POST["town"]) ?:null;
        $email=sanitize($_POST["email"]);
        $phone=sanitize($_POST["phone"]);
        $benefit=sanitize($_POST["benefit"]);
        $hour=sanitize($_POST["hour"]);
        $date=sanitize($_POST["date"]);
        $hairdresser=sanitize($_POST["hairdresser"]) ?:null;
        
        //* Vérifier que le créneau est disponible
        $this->getModelAppointment()->setHour($hour)->setDate($date);
        $data=$this->getModelAppointment()->getByBooked();

        if(empty($data)){

            return "<span style='color: red'>*Veuillez choisir un créneau</span>";
        }

        if($_POST["hairdresser"]!="choice"){

            $this->getModelAppointment()->setFirstname($firstname)->setLastname($lastname)->setAge($age)->setStreet($street)->setPostalCode($postalCode)->setTown($town)->setEmail($email)->setPhone($phone)->setBenefit($benefit)->setHairdresser($hairdresser)->bookAnAppointment();

            return $this->getModelAppointment()->makeAnAppointment();
        }

        if($_POST["hairdresser"]=="choice"){
            foreach($data as $element){
                
                if($element["is_booked"]==0){

                    $this->getModelAppointment()->setFirstname($firstname)->setLastname($lastname)->setAge($age)->setStreet($street)->setPostalCode($postalCode)->setTown($town)->setEmail($email)->setPhone($phone)->setBenefit($benefit)->setHairdresser($element["id_hairdresser"])->bookAnAppointment();

                    return $this->getModelAppointment()->makeAnAppointment();
                }
            }
        }
    return "";
    }

    //! ANNULER UN RENDEZ-VOUS
    public function cancelMadeAppointment():string{

        //* récupérer la date
        $date = $_GET["date"] ?? null;

        if(isset($_POST["cancelAppointment"])){

            //* nettoyer les données
            $hour=sanitize($_POST["hour"]);
            $date=sanitize($date);
            $firstname=sanitize($_POST["firstname"]);
            $lastname=sanitize($_POST["lastname"]);
            $hairdresser=sanitize($_POST["hairdresser"]);

            //* donner les informations au model
            $this->modelAppointment->setHour($hour)
            ->setDate($date)
            ->setFirstname($firstname)
            ->setLastname($lastname)
            ->setHairdresser($hairdresser);
            
            $this->modelAppointment->cancelMadeAppointment($date);$this->modelAppointment->cancelBookAnAppointment($date);
        }

        return "";
    }

    //! AFFICHAGE DE LA PAGE
    public function render(){

        //* charger l'affichage
        $hairdresser=$this->displayHairdresser();
        $availableAppointment=$this->displayAppointment();
        $message=$this->addAppointment();
        $messageMakeAnAppointment=$this->makeAnAppointment();
        $messageCancelAppointment=$this->cancelAddAppointment();
        $messageCancelMadeAppointment=$this->cancelMadeAppointment();

        //* faire le rendu
        echo $this->getViewAppointment()
        ->setHairdresser($hairdresser)
        ->setMessage($message)
        ->setAvailableAppointment($availableAppointment)
        ->setMessageMakeAnAppointment($messageMakeAnAppointment)
        ->setMessageCancelAppointment($messageCancelAppointment)
        ->setMessageCancelMadeAppointment($messageCancelMadeAppointment)
        ->displayView();       
    }
}
date_default_timezone_set("Europe/Paris");

// $appointment=new ControllerAppointment(new ViewAppointment,new ModelAppointment, );

// $appointment->render();

// include "../view/view_footer.php";
