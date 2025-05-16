<?php
// include "../view/view_header.php";
class ControllerHeader{

    private ?ViewHeader $viewHeader;
    
    public function __construct(ViewHeader $viewHeader){

        $this->viewHeader=$viewHeader;
    }

    public function getViewHeader(): ?ViewHeader { return $this->viewHeader; }
    public function setViewHeader(?ViewHeader $viewHeader): self { $this->viewHeader = $viewHeader; return $this; }

    public function render():void{

        echo $this->getViewHeader()->displayView();
    }
}

// $header=new ControllerHeader(new ViewHeader);
// $header->render();
