<?php
return array(
    'name' =>'Cửu Giới',  
    'theme'=>'skin1',
    'components'=>array(
        'mail' => array(
            'class' => 'common.extensions.yii-mail.YiiMail',
            'transportType' => 'smtp',
            'transportOptions' => array(
                'host' => 'smtp.gmail.com',
                'port' => '465',
                'encryption' => 'ssl',
                'username' => '',
                'password' => ''
            ),
            'viewPath' => 'common.views.mail',
        ),
    ),
    'params' => array(
        'appfb_id'=>'774520229309342',   
        'appfb_secret'=>'e6d2ee549b19d5d98cae5b6606a68890',             
    )
);
?>
