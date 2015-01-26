<?php
/* @var $this ControllersController */
/* @var $model Controllers */

$this->breadcrumbs = array(
    'Controllers' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Controllers', 'url' => array('index')),
    array('label' => 'Create Controllers', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('controllers-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Controllers</h1>

<p>
    You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
    or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button')); ?>
<div class="search-form" style="display:none">
    <?php
    $this->renderPartial('_search', array(
        'model' => $model,
    ));
    ?>
</div><!-- search-form -->

<?php
$this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'controllers-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
        'controller_id',
        'controller_name',
        'description',
        //'parent',
        // 'parents.description',
        array(
            'header' => 'Thuộc Menu',
            'value' => 'isset($data->parents["description"])?$data->parents["description"]:(empty($data->parent)?"Menu Gốc":"Không Xác Định")'
        ),
        'url',
        //'special ',
        array(
            'header' => 'Hiển Thị',
            'value' => '$data->special==0?"Hiển Thị Mọi User":"Hiển Thị Với Admin"'
        ),
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'buttons' => array(
                'view',
                'update',
                'delete',
            )
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