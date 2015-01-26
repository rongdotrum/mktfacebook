<?php
/* @var $this UsersController */
/* @var $model Users */

$this->breadcrumbs = array(
    'Users' => array('index'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List Users', 'url' => array('index')),
    array('label' => 'Create Users', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('users-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
Yii::app()->clientScript->registerScript('lock', '
 $(document).on("click", "#users-grid a.unlock", function() {
        if (!confirm("Bạn Có Chắc Về Điều Này?"))
            return false;
        var th = this;
        var afterDelete = function() {
        };
        $.fn.yiiGridView.update("users-grid", {
            type: "POST",
            url: $(this).attr("href"),
            success: function(data) {
                $.fn.yiiGridView.update("users-grid");
                afterDelete(th, true, data);
            },
            error: function(XHR) {
                return afterDelete(th, false, XHR);
            }
        });
        return false;
    });
');
?>

<h1>Manage Users</h1>

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
    'id' => 'users-grid',
    'dataProvider' => $model->search(),
    'filter' => $model,
    'columns' => array(
// 'user_id',
        array(
            'header' => 'No.',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
        ),
        'display_name',
        //   'password',
        'email',
        'activate_status',
        //  'del_flg',
        'registerdate',
        array(
            'header' => 'Trạng Thái',
            'name' => 'del_flg',
            'value' => '$data->del_flg==0?"Mở":"Khóa"',
            'filter' => CHtml::activeDropDownList($model, 'del_flg', array(0 => 'Mở', 1 => 'Đóng'), array('empty' => ' -- Chọn Trạng Thái -- '))
        ),
        'usersource',
        //'partner_id',
        array(
            'header'=>'Parner',
            'filter'=>CHtml::activeDropDownList($model,'partner_id',GHelpers::getDropDownList('Partners','partner_id','partner_name','status = 1 and del_flg != 1'),array('empty'=>'Lọc Partner')),
            'value'=>function($data) {
              if (isset($data->partners->partner_name))  
                    return $data->partners->partner_name;
              return $data->partner_id;
            },
        ),
        'partner_key_url',
        'social_name',   
        array(
            'class' => 'bootstrap.widgets.TbButtonColumn',
            'template' => '{view}{lock}{plusgold}{update}{senditem}',
            'buttons' => array(
                'lock' => array(
                    'icon' => 'icon-lock',
                    'label' => 'Khóa',
                    'options' => array('class' => 'unlock'),
                    'url' => 'app()->createUrl("users/users/delete",array("id"=>$data->user_id))',
                ),
                'plusgold' => array(
                    'icon' => 'icon-pencil',
                    'label' => 'Cộng vàng',
                    'url' => 'app()->createUrl("users/users/plusgold",array("id"=>$data->user_id))',
                ),               
                'update' => array(
                    'icon' => 'icon-cog'
                ),
                'senditem'=> array(
                    'icon'=>'icon-gift',
                    'label' => 'Gửi item',
                    'url' => 'app()->createUrl("users/users/additem",array("id"=>$data->user_id))',
                )
            )
        ),
    ),
));
?>

