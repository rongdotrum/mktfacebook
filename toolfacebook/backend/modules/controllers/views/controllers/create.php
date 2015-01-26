<?php
/* @var $this ControllersController */
/* @var $model Controllers */

$this->breadcrumbs = array(
    'Controllers' => array('index'),
    'Create',
);

$this->menu = array(
    array('label' => 'List Controllers', 'url' => array('index')),
    array('label' => 'Manage Controllers', 'url' => array('admin')),
);
?>

<h1>Create Controllers</h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'modules' => $modules)); ?>