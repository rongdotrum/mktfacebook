<?php

class GWGThongbao extends CWidget {

    public function init() {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application
        // import the module-level models and components
    }

    public function run() {
        $process = new GNewsProcess();
        $CatThongbao = GConst::Cat_ThongBao;
        $thongbao = $process->GetListNews($CatThongbao, 5);
        $this->render('GWGThongbao', array('thongbao' => $thongbao));
    }

}

?>