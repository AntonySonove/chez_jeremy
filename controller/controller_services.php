<?php
// include "../controller/controller_header.php";
// include "../view/view_services.php";
class ControllerServices{

    private ?ViewServices $viewServices;

    public function __construct(ViewServices $viewServices){
        $this->viewServices=$viewServices;
    }

    public function getViewServices(): ?ViewServices { return $this->viewServices; }
    public function setViewServices(?ViewServices $viewServices): self { $this->viewServices = $viewServices; return $this; }

    public function render():void{

        echo $this->getViewServices()->displayView();
    }
}
// include "../view/view_footer.php";
