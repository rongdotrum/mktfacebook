<?php
/* @var $this QuaysoItemController */
/* @var $model QuaysoItem */

$this->breadcrumbs=array(
	'Quayso Items'=>array('index'),
	$model->itemid,
);

$this->menu=array(
	array('label'=>'List QuaysoItem', 'url'=>array('index')),
	array('label'=>'Create QuaysoItem', 'url'=>array('create')),
	array('label'=>'Update QuaysoItem', 'url'=>array('update', 'id'=>$model->itemid)),
	array('label'=>'Delete QuaysoItem', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->itemid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage QuaysoItem', 'url'=>array('admin')),
);
?>

<h1>View QuaysoItem #<?php echo $model->itemid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'itemid',		
		'itemname',
		'count',
		'percent',
        'limititem',
        'typeitem',
        'image',
        'image_hover',
	),
)); ?>

<?php
$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'type' => 'primary',
    'buttons' => array(
        array('label' => 'Quản Lý', 'url' => array('index')),
        array('label' => 'Tạo Mới', 'url' => array('create')),
        array('label' => 'Chỉnh Sửa', 'url' => array('update', 'id' => $model->itemid)),
        array('label' => 'Xóa', 'url' => array('delete'), 'htmlOptions' => array('submit' => array('delete', 'id' => $model->itemid), 'confirm' => 'Are you sure you want to delete this item?')),
    ),
    'htmlOptions' => array('class' => 'form-actions'),
));
?>