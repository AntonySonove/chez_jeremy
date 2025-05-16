<?php
// include "../view/view_header.php";
// include "../view/view_products.php";

class ControllerProducts{

    private ?ViewProducts $viewProducts;

    public function __construct(ViewProducts $viewProducts){
        $this->viewProducts=$viewProducts;
    }

    public function getViewProducts(): ?ViewProducts { return $this->viewProducts; }
    public function setViewProducts(?ViewProducts $viewProducts): self { $this->viewProducts = $viewProducts; return $this; }

    public function render():void{

        echo $this->getViewProducts()->displayView();
    }
}
// include "../view/view_footer.php";
?>