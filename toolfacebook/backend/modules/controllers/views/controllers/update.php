<?php
/* @var $this ControllersController */
/* @var $model Controllers */

$this->breadcrumbs = array(
    'Controllers' => array('index'),
    $model->controller_id => array('view', 'id' => $model->controller_id),
    'Update',
);

$this->menu = array(
    array('label' => 'List Controllers', 'url' => array('index')),
    array('label' => 'Create Controllers', 'url' => array('create')),
    array('label' => 'View Controllers', 'url' => array('view', 'id' => $model->controller_id)),
    array('label' => 'Manage Controllers', 'url' => array('admin')),
);
?>

<h1>Update Controllers <?php echo $model->controller_id; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'modules' => $modules)); ?>