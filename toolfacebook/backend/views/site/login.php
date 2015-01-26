<?php
$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
    'Login',
);
?>

<p>Please fill out the following form with your login credentials:</p>

<div class="form" id="loginbox">
    <?php
    $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
        'id' => 'login-form',
        'type' => 'horizontal',
        'enableClientValidation' => true,
        'htmlOptions' => array('class' => 'well'),
        'clientOptions' => array(
            'validateOnSubmit' => true,
        ),));
    ?>

    <?php echo CHtml::errorSummary($model, null, null, array('class' => 'alert alert-error')); ?>
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <div id="login-inner">
        <?php echo $form->textFieldRow($model, 'username', array('class' => 'span3')); ?>
        <?php echo $form->passwordFieldRow($model, 'password', array('class' => 'span3')); ?>
        <?php echo $form->checkBoxRow($model, 'rememberMe'); ?>

        <?php if ($model->requireCaptcha): ?>
            <?php $this->widget('CCaptcha'); ?>
            <?php echo $form->textField($model, 'verifyCode'); ?>
        <?php endif; ?>

        <div class="form-actions">
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'submit', 'type' => 'primary', 'label' => 'Submit', 'icon' => 'ok')); ?>
            <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType' => 'reset', 'label' => 'Reset')); ?>
        </div>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- form -->
