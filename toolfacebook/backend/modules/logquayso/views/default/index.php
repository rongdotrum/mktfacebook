<?php
/* @var $this LogQuaysoController */
/* @var $model LogQuayso */

$this->breadcrumbs = array(
    'Log Quaysos' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List LogQuayso', 'url' => array('index')),
    array('label' => 'Create LogQuayso', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('log-quayso-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Log Quaysos</h1>

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
    'id' => 'log-quayso-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'ajaxUrl' => app()->createUrl('logquayso'),
     'selectableRows'=>2,
    'columns' => array(
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        array(
            'name'=>'userid',
            'value'=>function($data) {
                return CHtml::link($data->userid,Yii::app()->createUrl('users/users/view/id').$data->userid,array('target'=>'_blank'));
            },
            'type'=>'raw'
        ),        
        array(
            'header'=>'Email',
            'filter'=>CHtml::activeTextField($model,'email'),
            'value'=>function($data) {
                if (isset($data->users->email))
                    return $data->users->email;
            }
        ),     
        array(
            'header'=>'tên facebook',
            'filter'=>CHtml::activeTextField($model,'social_name'),
            'value'=>function($data) {
                if (isset($data->users->social_name))
                    return $data->users->social_name;
            }
        ),
        'content',
        'datequay',
        array(
            'header' => 'Loại Thưởng',
            'filter' => CHtml::activeDropDownList($model, 'type', array(1 => 'Trúng thưởng',  0=> 'Không trúng thưởng'),
             array('empty' => 'Xem Hết')),
            'value' => function($data) {
                if ($data->type==1)
                    return 'Trúng thưởng';
                else
                    return 'Không trúng thưởng';                
            }
        ),
        array(
            'name'=>'status',
            'filter'=>CHtml::activeDropDownList($model,'status',array(1=>'đã nhận',0=>'chưa nhận'),array('empty'=>'xem hết')),
            'value'=>function($data) {
                if ($data->status==1)
                    return 'đã nhận';
                else
                    return 'chưa nhận';
            }
        ),
         array(
            'class'=>'CCheckBoxColumn',   
            'id'=>'chk',            
            'footer'=>CHtml::button('đã nhận',array('id'=>'btndelcode','class'=>'btn btn-primary btn-small')),
        ),                   
    ),
));
?>

<script>
         $(function() {
             
             $('body').delegate('#btndelcode','click',function(){
                 var data =  []
                 $('input[type=checkbox]:checked').each(function(i){
                        data[i]=$(this).val();                        
                 })
                 $.ajax({
                     url:'<?php echo Yii::app()->createUrl('logquayso/default/dellist')?>',
                     type:'POST',
                     beforeSend:function() {
                         if ($('input[type=checkbox]:checked').length==0)
                         {
                            alert('Chọn Users Muốn Xóa');
                            return false;
                         }
                         var cf = confirm('Bạn Muốn Xác Nhận Users Đã Nhận Thưởng');
                         if (!cf) 
                            return false;
                     },
                     data:{code:data},
                     success:function(data) {
                         if (data != 0)
                            $.fn.yiiGridView.update('log-quayso-grid');
                     },                     
                 })
                 
             })

         })
</script>