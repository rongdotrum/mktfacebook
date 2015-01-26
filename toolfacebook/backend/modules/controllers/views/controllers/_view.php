<?php
/* @var $this ControllersController */
/* @var $data Controllers */
?>

<div class="view">

    <b><?php echo CHtml::encode($data->getAttributeLabel('controller_id')); ?>:</b>
    <?php echo CHtml::link(CHtml::encode($data->controller_id), array('view', 'id' => $data->controller_id)); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('controller_name')); ?>:</b>
    <?php echo CHtml::encode($data->controller_name); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('description')); ?>:</b>
    <?php echo CHtml::encode($data->description); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('parent')); ?>:</b>
    <?php echo CHtml::encode($data->parent); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('url')); ?>:</b>
    <?php echo CHtml::encode($data->url); ?>
    <br />

    <b><?php echo CHtml::encode($data->getAttributeLabel('special')); ?>:</b>
    <?php echo CHtml::encode($data->special); ?>
    <br />


</div>