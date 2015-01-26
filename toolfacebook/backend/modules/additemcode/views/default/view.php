<?php
/* @var $this ItemGiftcodeInputController */
/* @var $model ItemGiftcodeInput */

$this->breadcrumbs=array(
	'Item Giftcode Inputs'=>array('index'),
	$model->itemid,
);

$this->menu=array(
	array('label'=>'List ItemGiftcodeInput', 'url'=>array('index')),
	array('label'=>'Create ItemGiftcodeInput', 'url'=>array('create')),
	array('label'=>'Update ItemGiftcodeInput', 'url'=>array('update', 'id'=>$model->itemid)),
	array('label'=>'Delete ItemGiftcodeInput', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->itemid),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage ItemGiftcodeInput', 'url'=>array('admin')),
);
?>

<h1>View ItemGiftcodeInput #<?php echo $model->itemid; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'itemid',
		array(
            'label'=>'content',
            'value'=>$model->content,
            'type'=>'raw',
        ),
		array(
            'label'=>'status',
            'value'=>($model->status == 1)?'Mở':'Đóng'
        )
	),
)); ?>
<hr/>
<?php
$this->widget('bootstrap.widgets.TbButtonGroup', array(
    'type' => 'primary',
    'buttons' => array(
        array('label' => 'Quản Lý', 'url' => array('index')),
        array('label' => 'Tạo Mới', 'url' => array('create')),
        array('label' => 'Chỉnh Sửa', 'url' => array('update', 'id' => $model->itemid)),
        array('label' => 'Xóa', 'url' => array('delete'), 'htmlOptions' => array('submit' => array('delete', 'id' => $model->itemid), 'confirm' => 'Bạn Muốn Xóa Item ?')),
    ),
    'htmlOptions' => array('class' => 'form-actions'),
));
?>
