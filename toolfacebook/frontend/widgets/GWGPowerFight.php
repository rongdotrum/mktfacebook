<?php

class GWGPowerFight extends CWidget {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
    }

    public function run() {
        $process = new GNewsProcess();
        //$powerfight = $process->getPowerFight(10, 1);
        $powerfight = new PowerFight('search');
        $this->render('GWGPowerFight', array('powerfight' => $powerfight));
    }

}

?>