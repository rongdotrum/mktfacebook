<?php
/* @var $this ItemGiftcodeInputController */
/* @var $model ItemGiftcodeInput */

$this->breadcrumbs=array(
	'Item Giftcode Inputs'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List ItemGiftcodeInput', 'url'=>array('index')),
	array('label'=>'Create ItemGiftcodeInput', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#item-giftcode-input-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Item Giftcode Inputs</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'item-giftcode-input-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'itemid',
		'content',
		array(
            'name'=>'status',
            'value'=>function($data) {
                if ($data->status == 1)
                    return 'Mở';
                return 'Đóng';
            }
        ),
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => t('Tạo Code Item'),
        'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'url' => $this->createUrl('create'),
        'toggle' => true,
    ));
    ?>
</div>