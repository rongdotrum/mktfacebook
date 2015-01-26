<script>
    $(function() {

        $('input[name="fullpermission"]').on('click', function() {
            t = $('input[name="fullpermission"]:checked').val();
            if (t != 4)
            {
                $('#setpermission').find('input[type=checkbox]').attr('checked', 'yes');
                $('#setpermission:not(.fullpermission)').find('input:radio[value=' + t + ']').attr('checked', 'checked');
            }
            else
            {
                $('#setpermission').find('input[type=checkbox]').removeAttr('checked');
                $('#setpermission').find('input:radio[value=4]').attr('checked', 'checked');

            }

        })


    })
</script>

<a style="display:block;cursor:pointer"  onclick="js:$('.fullpermission').toggle()">Chọn Tất Cả</a>
<div class="fullpermission" style="display:none">
    <?php
    echo CHtml::radioButtonList('fullpermission', 4, CHtml::listData(Permission::model()->findAll(), 'permission_id', 'description'));
    ?>

</div>