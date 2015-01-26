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
        //	'password',
        'email',
        'registerdate',
        'partners.partner_name',
        'social_name',
        //'del_flg',
        array(
            'label' => 'Trạng Thái',
            'value' => $model->del_flg == 1 ? "Khóa" : "Mở"
        ),          
    ),
));
?>
<hr/>
<?php
$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'type' => 'primary',
    'buttons' => array(
        array('label' => 'Quản Lý', 'url' => array('index')),
        array('label' => 'Khóa', 'url' => array('delete'), 'htmlOptions' => array('submit' => array('delete', 'id' => $model->user_id), 'confirm' => 'Are you sure you want to delete this item?')),
    ),
    'htmlOptions' => array('class' => 'form-actions'),
));
?>
