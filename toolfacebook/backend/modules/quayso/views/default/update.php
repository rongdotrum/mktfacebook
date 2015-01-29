<?php
/* @var $this QuaysoController */
/* @var $model Quayso */

$this->breadcrumbs = array(
    'Quaysos' => array('index'),
    $model->ID => array('view', 'id' => $model->ID),
    'Update',
);

$this->menu = array(
    array('label' => 'List Quayso', 'url' => array('index')),
    array('label' => 'Create Quayso', 'url' => array('create')),
    array('label' => 'View Quayso', 'url' => array('view', 'id' => $model->ID)),
    array('label' => 'Manage Quayso', 'url' => array('admin')),
);
?>

<h1>Update Quayso <?php echo $model->ID; ?></h1>

<?php echo $this->renderPartial('_form', array('model' => $model, 'item' => $item)); ?>