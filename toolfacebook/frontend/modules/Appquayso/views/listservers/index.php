<?php $this->renderPartial('/partial/topnews', array('title' => 'Danh Sách Server')) ?>
<div class="boxContent">
    <div class="newsTop"><!-- --></div>
    <div class="newsCenter">
        <div class="subCenter">
            <div style="width:548px;margin:0 auto">
                <div class="boxServer">

                    <div id="listServer">
                        <div class="statusServer">
                            <div class="good"><span style="border: 1px solid;"><!-- --></span>Tốt</div>
                            <div class="near"><span style="border: 1px solid;"><!-- --></span>Gần đầy</div>
                            <div class="full"><span style="border: 1px solid;"><!-- --></span>Đầy</div>
                            <div class="full"><span style="border: 1px solid;opacity:0.3;"><!-- --></span>Sắp mở</div>
                            <div class="maintain"><span style="border: 1px solid;"><!-- --></span>Bảo trì</div>
                        </div>

                        <hr>
                        <div>
                            <h4 class = "h4title">Tất cả máy chủ đã mở:</h4>
                        </div>
                        <ul class="ListServer">
                            <?php
                                foreach ($model as $server):
                                $href = app()->createUrl($this->module->name.'/Channelplay/entergame', array('serverid' =>  Encrypts::instance()->Encrypt('server',$server->server_id), 'line' => 'wt'));
                                    ?>
                                    <li style="position:relative;">
                                    <a class="goodServer" href="<?= $href ?>"><?= $server->server_name ?></a>
                                    </li>
                                <?php
                                endforeach;
                            ?>
                        </ul>

                        <ul id="tabHeader"><!-- --></ul>
                    </div>
                    <div style="clear:both"></div>
                </div>

                <style type="text/css">
                    .yiiPager li.previous,.yiiPager li.next  {
                        display:none;
                    }
                    .list-view .pager{
                        text-align: center;
                        width:305px;
                    }
                    ul.ListServer{
                        height: 160px;
                        margin-left: 5px;
                    }
                    .list-view-loading
                    {
                        background:none;
                    }
                    #listServer h4,#listServer #countbox{
                        color:white;
                    }

                </style>
            </div>
        </div>
    </div>
    <div class="newsBottom"></div>
</div>
<style>
    .h4title{
        margin-bottom:2px;
        margin-top:0px;
        margin-left: 5px;
    }
    #listServer{
        background: none;
        /*width: 850px;*/
        margin: 0 auto;
        padding: 25px 0 0 23px;
    }
    .boxServer{
        margin: 0px;
    }
    #listServer h4,#listServer #countbox,.statusServer{
        color:black;
    }
    ul.ListServer li{
        margin: 12px;
    }
    #listServer h4
    {
        margin-left:20px !important;
    }
    .yiiPager li.page a {

        color:black;
    }
    ul.ListServer {
        height:auto;
        overflow:visible;
    }
    .list-view .pager {
        margin:10px auto;
    }
    .list-view .pager {
        line-height:122px;
    }
</style>
