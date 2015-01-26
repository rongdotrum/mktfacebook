
<div class="contentCenter">
    <div class="two_nrtop"><!-- --></div>
    <div class="two_nr_sfqlb">
        <div class="big_box_wrap">
            <h3>Quay Số</h3>
            <div class="box_main_link">
                <a href="<?php echo app()->createUrl('site') ?>">Trang chủ</a><!--
                --> &gt;<a href="<?php echo app()->createUrl('quayso') ?>">Quay Số</a>
            </div>
            <div class="news_content_wrap">
                <div class="boxRegister">
                    <form method="get" action="<?php echo app()->createUrl('quayso/servers') ?>" id="Formlogin" class="signup">
                        <div class="pt15 wrap-form">
                            <div class="mt15">
                                <div class="lable left">Chọn Máy Chủ <span style="color:red;font-weight: bold">*</span></div>
                                <div class="input left"><?php
                                    echo CHtml::DropDownList('ID', array('empty' => 'Chọn máy chủ'), GHelpers::getDropDownList('Servers', 'server_id', 'server_name', 'status=1', 'published_date DESC'), array('id' => 'ID', 'name' => 'ID'));
                                    ?></div>
                                <div class="clear"></div>
                            </div>
                            <div class="boxtaikhoan">
                                <div class="lable left"></div>
                                <div class="left"><input type="submit" value="Tiếp tục" name="yt0" class="btn" tabindex="9"></div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="two_nrfoot"><!-- --></div>
</div>













