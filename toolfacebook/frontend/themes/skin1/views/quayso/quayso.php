<div class="bgQuay">
    <?php
    if ($data == true) {        
        ?>
        <div id="flashContent">
            <object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" width="752" height="431" id="FlashVars_AS2" align="middle">
                <param name="movie" value="<?php echo app()->theme->baseUrl ?>/~quayso.swf" />
                <param name="quality" value="high" />
                <param name="bgcolor" value="#FFFFFF" />
                <param name="play" value="true" />
                <param name="loop" value="true" />
                <param name="wmode" value="window" />
                <param name="scale" value="showall" />
                <param name="menu" value="true" />
                <param name="devicefont" value="false" />
                <param name="salign" value="" />
                <param name="allowScriptAccess" value="sameDomain" />
                <param name="FlashVars" value="serverid=<?php echo $_GET['ID'] ?>" />
                <!--[if !IE]>-->
                <object type="application/x-shockwave-flash" data="<?php echo app()->theme->baseUrl ?>/~quayso.swf" width="752" height="431">
                    <param name="movie" value="<?php echo app()->theme->baseUrl ?>/~quayso.swf" />
                    <param name="quality" value="high" />
                    <param name="bgcolor" value="#FFFFFF" />
                    <param name="play" value="true" />
                    <param name="loop" value="true" />
                    <param name="wmode" value="window" />
                    <param name="scale" value="showall" />
                    <param name="menu" value="true" />
                    <param name="devicefont" value="false" />
                    <param name="salign" value="" />
                    <param name="allowScriptAccess" value="sameDomain" />
                    <param name="FlashVars" value="serverid=<?php echo $_GET['ID'] ?>&host=<?php echo $_SERVER['SERVER_NAME']; ?>" />
                    <!--<![endif]-->
                    <a href="http://www.adobe.com/go/getflash">
                        <img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
                    </a>
                    <!--[if !IE]>-->
                </object>
                <!--<![endif]-->
            </object>
        </div>
        <?php
    } else {
        ?>
        Server này không có số lần quay thưởng. Vui lòng nạp card để được quay thưởng
    <?php } ?>
</div>
<div class="noidungQuay">
    <div class="vongquayTop">
        <div class="buttonLink">
            <a href="javascript:;" rel="boxQuaySo1" class="active">GIỚI THIỆU</a>
        </div>
        <div class="buttonLink">
            <a href="javascript:;" rel="boxQuaySo2" class="">LỊCH SỬ</a>
        </div>

    </div>
    <div id="contents">
        <div id="boxQuaySo1" class="subboxQuaySo" style="display: block;">
            <p><b><span class="bold">Nội dung hoạt động:</span></b></p>
            <ul type="disc">
                <ul type="circle"><li>Sau khi nạp thẻ thành công, tương ứng với số tiền nạp thì hệ thống sẽ trao tặng số lần quay may mắn.</li><li>Cụ thể:<b> <span class="red"> Nạp 20k được 1 lần - 50k được 3 lần - 100k được 6 lần - 200k được 12 lần - 500k được 30 lần </span></b></li><li><b>Số lần quay của quý đồng đạo sẽ được hiển thị trên vòng quay may mắn.</b></li><li><b>Quý đồng đạo nạp vào máy chủ nào thì sẽ được số lần quay số tại máy chủ đó.</b></li><li><b>Phần thưởng của vòng quay may mắn các quý đồng đạo sẽ được liệt kê trong trang Lịch Sử.</b></li></ul><b>
                </b></ul><b>
                <p><b><span class="bold">Phần Thường</span></b></p>
                <?php
              
                if ($phanthuong->search() != null ) {                                          
                $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'phanthuong-grid',
                    'dataProvider' => $phanthuong->search(),
                    'columns' => array(
                        array(
                            'header' => 'Vị Trí(ô)',
                            'value' => '$data->position',
                        ),
                        array(
                            'header' => 'Số Lượng',
                            'value' => function($data) {
                                if (isset($data->items->count))
                                    return number_format($data->items->count);
                                else
                                    return 'Chưa có';
                            },
                        ),
                        array(
                            'header' => 'Phần Thưởng',
                            'value' => function($data) {
                                if (isset($data->items->itemname))
                                    return $data->items->itemname;
                                else
                                    return 'Chưa có';
                            },
                        )
                    ),
                ));
                }
                ?>


                <p><b><span class="bold">Các lưu ý quan trọng khi tham gia hoạt động quay số may mắn:</span></b></p>
                <ul type="disc">
                    <ul type="circle">
                        <li>Phần thưởng sẽ được chuyển ngay sau khi trúng thưởng</li>
                        <li><b>Trong quá trình đang quay số, nếu xảy ra các trường hợp sau sẽ không nhận được phần thưởng và hệ thống vẫn trừ lượt quay:</b>
                            <ul type="square">
                                <li>Treo máy.</li>
                                <li>Bị ngắt kết nối đường truyền.</li>
                                <li>Làm mới trang web quay số.</li>
                                <li>Các hình thức thoát ra khỏi trang web quay số.</li>


                            </ul> <br>
                            <font color="red" size="3">Mọi trường hợp mất mát BQT không chịu trách nhiệm vì đã có thông báo trước</font>
                        </li>
                    </ul>
                </ul>
            </b>
        </div>
        <div id="boxQuaySo2" class="subboxQuaySo" style="display: none;">
            <p><b><span class="bold">Lịch sử nhận thưởng:</span></b></p>
            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'lichsu-grid',
                'dataProvider' => $lichsu->search(),
                'columns' => array(
                    array(
                        'header' => 'Tài Khoản',
                        'value' => '$data->username'
                    ),
                    array(
                        'header' => 'Phần Thưởng',
                        'value' => '$data->content'
                    ),
                    array(
                        'header' => 'Server',
                        'value' => '$data->servers->server_name'
                    ),
                    array(
                        'header' => 'Thời Gian',
                        'value' => 'date("d-m-Y H:i:s",strtotime($data->datequay))'
                    )
                ),
            ));
            ?>
        </div>

    </div>
</div>
<script>
    function updategrid()
    {
        $.fn.yiiGridView.update("lichsu-grid");
    }
</script>