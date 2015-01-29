<?php
/* @var $this LogQuaysoController */
/* @var $model LogQuayso */
/* @var $form CActiveForm */
?>

<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'log-quayso-form',
        'enableAjaxValidation' => false,
    ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <?php echo $form->labelEx($model, 'userid'); ?>
        <?php echo $form->textField($model, 'userid'); ?>
        <?php echo $form->error($model, 'userid'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'username'); ?>
        <?php echo $form->textField($model, 'username', array('size' => 50, 'maxlength' => 50)); ?>
        <?php echo $form->error($model, 'username'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'content'); ?>
        <?php echo $form->textField($model, 'content', array('size' => 60, 'maxlength' => 100)); ?>
        <?php echo $form->error($model, 'content'); ?>
    </div>

     <div class="row">
        <?php echo $form->labelEx($model, 'datequay'); ?>
        <?php
        //echo $form->textField($model, 'published_date', array('size' => 50, 'maxlength' => 50));
        $this->widget('application.extensions.EJuiDateTimePicker.EJuiDateTimePicker', array(
            'model' => $model,
            'attribute' => 'datequay',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
                'timeFormat' => 'HH:mm:ss'
            ),
            'htmlOptions' => array(
                'class' => 'input-medium',
            )
        ));
        ?>
        <?php echo $form->error($model, 'datequay'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'type'); ?>
        <?php
        echo CHtml::activeDropDownList($model, 'type', array(0 => 'Điểm tích lũy', 1 => 'Item ingame', 2 => 'Item outgame'), array('empty' => 'Chọn Loại Item'))
        ?>
        <?php echo $form->error($model, 'type'); ?>
    </div>
    <div class="row">
        <?php echo $form->labelEx($model, 'quantily'); ?>
        <?php echo $form->textField($model, 'quantily'); ?>
        <?php echo $form->error($model, 'quantily'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'codeingame'); ?>
        <?php echo $form->textField($model, 'codeingame', array('size' => 30, 'maxlength' => 30)); ?>
        <?php echo $form->error($model, 'codeingame'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model, 'isfreeday'); ?>
        <?php
        echo CHtml::activeDropDownList($model, 'isfreeday', array(0 => 'Nạp', 1 => 'Miễn phí'))
        ?>
        <?php echo $form->error($model, 'isfreeday'); ?>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->