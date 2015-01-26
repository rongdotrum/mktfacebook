<?php
    Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl.'/css/message.css');
    Yii::app()->clientScript->registerCssFile($this->module->assetsUrl.'/css/'.$this->module->name.'/form.css');
?>
<?php $this->renderPartial('/partial/topnews', array('title' => 'Nạp Card')) ?>
<style>
        form#loginForm label {
            color:black;
        }
</style>
<div class="boxContent pagePayment">
    <div class="newsTop"><!-- --></div>
    <div class="newsCenter">
        <div class="subCenter">
            <div class="category">
                <?php
                    if (app()->user->hasFlash('error'))
                        echo "<div class='message error' style='width:50%;margin:0 auto'>" . app()->user->getFlash('error') . "</div>";
                    if (app()->user->hasFlash('success'))
                        echo "<div class='message success' style='width:50%;margin:0 auto'>" . app()->user->getFlash('success') . "</div>";

                    if (!app()->user->isGuest) {
                        $form = $this->beginWidget('CActiveForm', array(
                            'id' => 'loginForm',
                            'action' => Yii::app()->createUrl($this->module->name.'/payment/napthe'),
                        ));
                        echo Chtml::label('Chọn Loại Thẻ','');
                        echo CHtml::activeDropDownList($model, 'CardId', GConst::$CardId,array('empty'=>'Chọn Loại Thẻ'));

                        echo $form->label($model,'Serial');
                        echo $form->textField($model,'Serial',array('placeholder'=>'Nhập Số Serial'));

                        echo $form->label($model, 'Pin');
                        echo $form->textField($model, 'Pin',array('placeholder'=>'Nhập Mã Thẻ'));

                        echo $form->label($model, 'ServerId');
                        echo CHtml::activeDropDownList($model, 'ServerId', GHelpers::getDropDownList('Servers','server_id','server_name','status=1 and published_date <= now()','published_date DESC'),array('empty' => 'Chọn máy chủ'));

                        echo CHtml::label('Mã Xác Thực','');
                        echo $form->textField($model, 'verifyCode',array('placeholder'=>'Nhập Mã Xác Thức'));
                        $this->widget('CCaptcha',array('id'=>'registcaptcha','buttonOptions'=>array('title'=>'Thay Đổi Mã Xác Thực')));
                        Yii::app()->clientScript->registerScript('initCaptcha', '$("#registcaptcha_button").trigger("click");', CClientScript::POS_READY);

                        echo CHtml::submitButton('Nạp Thẻ',array('class'=>'btn'));
                        $this->endWidget();
                    }
                ?>
            </div>
        </div>
    </div>
</div>
