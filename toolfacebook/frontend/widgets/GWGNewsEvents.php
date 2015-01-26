<?php

class GWGNewsEvents extends CWidget {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
    }

//    public function run() {
//        $process = new GNewsProcess();
//        $tonghop = $process->GetTongHopNews(5);
//        $Cattintuc = GConst::Cat_TinTuc;
//        $CatSukien = GConst::Cat_SuKien;
//        $tintuc = $process->GetListNews($Cattintuc, 5);
//        $sukien = $process->GetListNews($CatSukien, 5);
//        $this->render('GWGNewsEvents', array('tonghop' => $tonghop, 'tintuc' => $tintuc, 'sukien' => $sukien));
//    }

    public function run() {
        $process = new GNewsProcess();
        $result = array();
        $tonghop = $process->GetTongHopNews(5);
        $result[0] = $tonghop;
        $arraymodule = $process->getModule(GConst::TOP_RIGHT_MODULE);
        foreach ($arraymodule as &$value) {
            $value['list'] = $process->GetListNews($value['CatId'], 5);
        }
        $result[1] = $arraymodule;
//        print_r($result[1]);
//        die();
        $this->render('GWGNewsEvents', array('result' => $result));
    }

}

?>