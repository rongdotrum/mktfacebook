<?php
/* @var $this QuaysoController */
/* @var $model Quayso */

$this->breadcrumbs = array(
    'Quayso' => array('index'),
    'Manage',
);



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('quayso-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Quayso</h1>





<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'quayso-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        'position',
        array(
            'header' => 'Item',
            'filter' => CHtml::activeDropDownList($model, 'itemid', GHelpers::getDropDownList('QuaysoItem', 'itemid', 'itemname'), array('empty' => 'Chọn Item')),
            'value' => 'isset($data->items->itemname)?($data->items->count . "- " . $data->items->itemname):""',
        ),
        array(
            'class' => 'CButtonColumn',
        ),
    ),
));
?>
<div class="form-actions">
    <?php
    $this->widget('bootstrap.widgets.TbButton', array(
        'label' => t('Thêm mới'),
        'type' => 'primary', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'size' => 'small', // null, 'large', 'small' or 'mini'
        'url' => $this->createUrl('create'),
        'toggle' => true,
    ));
    ?>
</div>