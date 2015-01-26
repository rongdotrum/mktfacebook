<?php

class GWGHotLink extends CWidget {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
    }

    public function run() {
        $process = new GNewsProcess();
        $hotlink = $process->getHotLink(5);
        foreach ($hotlink as &$value) {
            $objecthot = $process->GetCat($value['CatId']);
            $value['action'] = $objecthot['CatAction'];
        }
        $this->render('GWGHotLink', array('hotlink' => $hotlink));
    }

}

?>