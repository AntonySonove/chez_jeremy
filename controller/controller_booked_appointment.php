<?php
include "../utils/utils.php";
include "../model/model_appointment.php";


class ControllerBookedAppointment {
    private? ModelAppointment $modelAppointment;

    public function __construct(ModelAppointment $modelAppointment){
        $this->modelAppointment=$modelAppointment;
    }

    public function getModelAppointment(): ModelAppointment { return $this->modelAppointment; }
    public function setModelAppointment(ModelAppointment $modelAppointment): self { $this->modelAppointment = $modelAppointment; return $this; }

    public function displayBookedAppointment():string{

        $date = $_GET["date"];

        $data=$this->modelAppointment->recoverMadeAppointment($date);
        // var_dump($data);

        if($date){

            $bookedAppointment="";

            if(empty($data)){

                return "Aucun rendez-vous prévu";
            }

            foreach($data as $element){
    
                $bookedAppointment=$bookedAppointment.'

<li style="list-style: none">
    <div style="border-bottom: 1px black solid">
        <p>
            <strong>'.$element["formatted_hour"].' | '.$element["firstname"].' '.$element["lastname"].'</strong>
        </p>
        <p>
            '.$element["email"].' | '.formatPhoneNumber($element["phone"]).'
        </p>
        <p id="cancelAppointment">
            <strong>'.$element["benefit"].' | '.$element["name"].'</strong>
            <button type="submit" name="cancelAppointment" style="color: red;">Annuler le<br>rendez-vous</button>
        </p>
        <input type="hidden" name="hour" value='.$element["formatted_hour"].'</input>
        <input type="hidden" name="firstname" value='.$element["firstname"].'</input>
        <input type="hidden" name="lastname" value='.$element["lastname"].'</input>
        <input type="hidden" name="hairdresser" value='.$element["id_hairdresser"].'</input>
    </div>
</li>       
                ';    
            }     
        }
        return $bookedAppointment;
    }
}
$bookedAppointment= new ControllerBookedAppointment(new ModelAppointment);

echo $bookedAppointment->displayBookedAppointment();
