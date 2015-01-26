<?php
/* @var $this AdminLogController */
/* @var $model AdminLog */

$this->breadcrumbs=array(
	'Admin Logs'=>array('index'),
	$model->Log_Id=>array('view','id'=>$model->Log_Id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AdminLog', 'url'=>array('index')),
	array('label'=>'Create AdminLog', 'url'=>array('create')),
	array('label'=>'View AdminLog', 'url'=>array('view', 'id'=>$model->Log_Id)),
	array('label'=>'Manage AdminLog', 'url'=>array('admin')),
);
?>

<h1>Update AdminLog <?php echo $model->Log_Id; ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>