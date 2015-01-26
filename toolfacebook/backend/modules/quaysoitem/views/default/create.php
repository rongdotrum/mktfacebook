<?php
/* @var $this QuaysoItemController */
/* @var $model QuaysoItem */

$this->breadcrumbs=array(
	'Quayso Items'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List QuaysoItem', 'url'=>array('index')),
	array('label'=>'Manage QuaysoItem', 'url'=>array('admin')),
);
?>

<h1>Create QuaysoItem</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>