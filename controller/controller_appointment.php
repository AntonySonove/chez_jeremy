<?php
include "../utils/utils.php";
include "../model/model_appointment.php";
include "../controller/controller_header.php";
// include "../controller/controller_booked_appointment.php";
include "../view/view_appointment.php";
include "../view/view_footer.php";

class ControllerAppointment{
    private ?ViewAppointment $viewAppointment;
    private ?ModelAppointment $modelAppointment;
    // private ?ControllerBookedAppointment $ControllerBookedAppointment;

    public function __construct(ViewAppointment $viewAppointment, ModelAppointment $modelAppointment,){
        $this->viewAppointment=$viewAppointment;
        $this->modelAppointment=$modelAppointment;
    }

    public function getViewAppointment(): ?ViewAppointment { return $this->viewAppointment; }
    public function setViewAppointment(?ViewAppointment $viewAppointment): self { $this->viewAppointment = $viewAppointment; return $this; }

    public function getModelAppointment(): ?ModelAppointment { return $this->modelAppointment; }
    public function setModelAppointment(?ModelAppointment $modelAppointment): self { $this->modelAppointment = $modelAppointment; return $this; }

    // public function getControllerBookedAppointment(): ?ControllerBookedAppointment { return $this->ControllerBookedAppointment; }
    // public function setControllerBookedAppointment(?ControllerBookedAppointment $ControllerBookedAppointment): self { $this->ControllerBookedAppointment = $ControllerBookedAppointment; return $this; }
    
    //! AFFICHER LES CRENEAUX DISPONIBLES
    public function displayAppointment():string{

        //* récupération de la date
        $date=$_GET["date"]?? null;

        //*affichage dans un menu select
        if ($date){

            $availableAppointment=""; //? variable d'affichage
            
            echo "<option value='choice' selected >Heure</option>"; //? option sélectionnée par défaut

            foreach($this->modelAppointment->recoverAvailableAppointments($date) as $appointment){ //? boucle pour générer les créneaux

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
    public function addAppointmentOneDay():string{

        //* Vérifier si on rçcoit le formulaire
        if(!isset($_POST["submitAddAppointmentOneDay"])){

            return "";
        }
        
        //* Vérifier si la date est renseignée
        if (empty($_POST["dateInputAddAppointmentOneDay"])){

            return "<span style='color: red'>*Date non saisie</span>";
        }
        //* Vérifier qu'au moins une checkbox est sélectionnée
        if (!isset($_POST["checkboxAddOneDayAppointment"])){

            return "<span style='color: red'>*Selectionnez au moins un créneau</span>";
        }

        //* Nettoyage de la date
        $date=sanitize($_POST["dateInputAddAppointmentOneDay"]);

        //* Création d'un tableau pour récupérer toutes les checkbox pour boucler dessus
        $cleanedCheckboxAddOneDayAppointment=[];

        //* Boucle pour nettoyer les données des checkbox
        foreach($_POST["checkboxAddOneDayAppointment"] as $checkboxAddOneDayAppointment){
            $cleanedCheckboxAddOneDayAppointment[]=sanitize($checkboxAddOneDayAppointment);
        }

        //* Récupération des créneaux existants dans la bdd (pour éviter les doublons)
        $this->getModelAppointment()->setDate($date);
        $data=$this->getModelAppointment()->getByHour();

        //* Vérifier si les créneaux existent
        foreach($cleanedCheckboxAddOneDayAppointment as $oneCleanedCheckboxAddOneDayAppointment){
            
            foreach($data as $oneData){
              
                if($oneData["formatted_hour"]==$oneCleanedCheckboxAddOneDayAppointment){

                    return "<span style='color: red'>*Créneau(x) déjà enregistré(s)</span>";
                }
            }
                
            //* Ajout des créneaux
            $this->getModelAppointment()->setHour($oneCleanedCheckboxAddOneDayAppointment)->setDate($date);
            $this->getModelAppointment()->addAnAppointment();
        }       

        return "<span style='color:green'>*Créneau(x) créé(s)</span>";
    }

    //! SUPPRIMER UN CRENEAU
    public function cancelAddAppointmentOneDay(){
            //* Vérifier si on rçcoit le formulaire
            if(!isset($_POST["cancelAddAppointmentOneDay"])){

                return "";
            }

            //* Vérifier si la date est renseignée
            if (empty($_POST["dateInputAddAppointmentOneDay"])){
    
                return "<span style='color: red'>*Date non saisie</span>";
            }
            //* Vérifier qu'au moins une checkbox est sélectionnée
            if (!isset($_POST["checkboxAddOneDayAppointment"])){
    
                return "<span style='color: red'>*Selectionnez au moins un créneau</span>";
            }
    
            //* Nettoyage de la date
            $date=sanitize($_POST["dateInputAddAppointmentOneDay"]);
    
            //* Création d'un tableau pour récupérer toutes les checkbox pour boucler dessus
            $cleanedCheckboxAddOneDayAppointment=[]; 
    
            //* Boucle pour nettoyer les données des checkbox
            foreach($_POST["checkboxAddOneDayAppointment"] as $checkboxAddOneDayAppointment){
                $cleanedCheckboxAddOneDayAppointment[]=sanitize($checkboxAddOneDayAppointment);
            }
    
            //* suppression des créneaux
            foreach ($cleanedCheckboxAddOneDayAppointment as $hour) {
                $this->getModelAppointment()->setHour($hour)->setDate($date);
                $this->getModelAppointment()->cancelAddAnAppointment();
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
        
        if(!empty($data)){
            $this->getModelAppointment()->setFirstname($firstname)->setLastname($lastname)->setAge($age)->setStreet($street)->setPostalCode($postalCode)->setTown($town)->setEmail($email)->setPhone($phone)->setBenefit($benefit)->setHairdresser($hairdresser)->bookAnAppointment();

            return $this->getModelAppointment()->makeAnAppointment();
        }
        return "";
    }

    //! AFFICHAGE DE LA PAGE
    public function render(){

        //* charger l'affichage
        $availableAppointment=$this->displayAppointment();
        $message=$this->addAppointmentOneDay();
        $messageMakeAnAppointment=$this->makeAnAppointment();
        $messageCancelAppointment=$this->cancelAddAppointmentOneDay();
        // $bookedAppointment= new ControllerBookedAppointment;
        // $bookedAppointment->displayBookedAppointments();

        //* faire le rendu
        echo $this->getViewAppointment()
        ->setMessage($message)
        ->setAvailableAppointment($availableAppointment)
        ->setMessageMakeAnAppointment($messageMakeAnAppointment)
        ->setMessageCancelAppointment($messageCancelAppointment)
        ->displayView();
        
        // ->setBookedAppointment($bookedAppointment)
        
    }
}
date_default_timezone_set("Europe/Paris");

$appointment=new ControllerAppointment(new ViewAppointment,new ModelAppointment, );
// $appointment->setControllerBookedAppointment(new ControllerBookedAppointment(new ViewAppointment, new ModelAppointment));
$appointment->render();

?>