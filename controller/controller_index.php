<?php
class ControllerIndex{

    // ATTRIBUTS
    private ? ViewIndex $viewIndex;
    private ? ModelIndex $modelIndex;

    // CONSTRUCTOR
    public function __construct(ViewIndex $viewIndex, ModelIndex $modelIndex){
        $this->viewIndex=$viewIndex;
        $this->modelIndex=$modelIndex;
    }

    // GETTER SETTER
    public function getViewIndex(){ return $this->viewIndex; }
    public function setViewIndex($viewIndex): self { $this->viewIndex = $viewIndex; return $this; }

    public function getModelIndex(){ return $this->modelIndex; }
    public function setModelIndex($modelIndex): self { $this->modelIndex = $modelIndex; return $this; }

    //METHOD
}