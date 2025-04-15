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
            '.$element["email"].' | '.$element["phone"].'
        </p>
        <p>
            <strong>'.$element["benefit"].' | '.$element["hairdresser"].'</strong>
        </p>
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


?>
