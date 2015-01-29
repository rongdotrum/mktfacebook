<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs = array(
    'Users' => array('index'),
    $model->user_id,
);

$this->menu = array(
    array('label' => 'List Users', 'url' => array('index')),
    array('label' => 'Create Users', 'url' => array('create')),
    array('label' => 'Update Users', 'url' => array('update', 'id' => $model->user_id)),
    array('label' => 'Delete Users', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->user_id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Users', 'url' => array('admin')),
);
?>

<h1>View Users #<?php echo $model->user_id; ?></h1>

<?php
$this->widget('zii.widgets.CDetailView', array(
    'data' => $model,
    'attributes' => array(
        'user_id',
        array(
            'label'=>'Tên Hiển Thị',
            'value'=>$model->display_name,
        ),        
        'email',
        'registerdate',      
        'social_name',        
    ),
));
?>
<hr/>
<?php
$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'type' => 'primary',
    'buttons' => array(
        array('label' => 'Quản Lý', 'url' => array('index')),      
    ),
    'htmlOptions' => array('class' => 'form-actions'),
));
?>
