<?php
// include "../controller/controller_header.php";
// include "../view/view_home.php";

class ControllerHome{

    private ?ViewHome $viewHome;
    
    public function __construct(viewHome $viewHome){
        $this->viewHome=$viewHome;
    }

    public function getViewHome(): ?ViewHome { return $this->viewHome; }
    public function setViewHome(?ViewHome $viewHome): self { $this->viewHome = $viewHome; return $this; }

    public function render():void{

        echo $this->getViewHome()->displayView();
    }
}

// $home=new ControllerHome(new viewHome);
// $home->render();
// include "../view/view_footer.php";