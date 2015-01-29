<?php
/* @var $this QuaysoItemController */
/* @var $model QuaysoItem */

$this->breadcrumbs=array(
	'Quayso Items'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List QuaysoItem', 'url'=>array('index')),
	array('label'=>'Create QuaysoItem', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('quayso-item-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Quayso Items</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>


<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'quayso-item-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
		'itemid',		
		'itemname',
		'count',
		'percent',
        'image',
        'image_hover',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>

<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => t('Thêm Mới'),
        'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'url' => $this->createUrl('create'),
        'toggle' => true,
    ));
    ?>
</div>