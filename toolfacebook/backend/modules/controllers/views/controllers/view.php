<?php
/* @var $this ControllersController */
/* @var $model Controllers */

$this->breadcrumbs = array(
    'Controllers' => array('index'),
    $model->controller_id,
);

$this->menu = array(
    array('label' => 'List Controllers', 'url' => array('index')),
    array('label' => 'Create Controllers', 'url' => array('create')),
    array('label' => 'Update Controllers', 'url' => array('update', 'id' => $model->controller_id)),
    array('label' => 'Delete Controllers', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->controller_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Controllers', 'url' => array('admin')),
);
?>

<h1>View Controllers #<?php echo $model->controller_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'controller_id',
        'controller_name',
        'description',
        //'parent',
        array(
            'label' => 'Thuộc Menu',
            'value' => empty($model->parent) ? "Menu Gốc" : Controllers::model()->findByPk($model->parent)->description
        ),
        'url',
        array(
            'label' => 'Hiển Thị',
            'value' => $model->special == 0 ? 'Hiển Thị Mọi User' : 'Hiển Thị Với Admin'
        )
    ),
));
?>
