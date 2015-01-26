<?php

$this->widget('bootstrap.widgets.TbNavbar', array(
    'type' => 'inverse', // null or 'inverse'
    'brand' => 'G4G Control Panel',
    'brandUrl' => '/',
    'collapse' => true, // requires bootstrap-responsive.css
    'items' => array(
        array('class' => 'bootstrap.widgets.TbMenu',
            'items' => $itmes),
        array(
            'class' => 'bootstrap.widgets.TbMenu',
            'htmlOptions' => array('class' => 'pull-right'),
            'items' => array(
                array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
                array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
            ),
        ),
    ),
));
?>