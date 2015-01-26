<?php
  class popupregist extends CWidget {
      public function run() {      
          $model = new SignUpForm();          
          $this->render('popupregist',array('model'=>$model));
      }
  }
?>
