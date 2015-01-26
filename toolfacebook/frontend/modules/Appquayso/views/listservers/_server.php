<li style="position:relative;">
    <?php
    $href = app()->createUrl($this->module->name.'/channelplay/entergame/') . '?serverid=' . urlencode(Encrypts::instance()->Encrypt('server', $data->server_id));
    $i = $widget->dataProvider->getPagination()->currentPage * $widget->dataProvider->getPagination()->pageSize + $index + 1;
    if ($i <= GConst::SHOW_SERVER_LIMIT)
        echo CHtml::image($this->module->assetsUrl . '/css/'.$this->module->name.'/images/butNew.png', ' ', array('style' => 'position:absolute;left:91.5%;top:1.5%'));
    switch ($data->statusserver) {
        case 1:
            $class = 'goodServer';
            break;
        case 2:
            $class = 'nearServer';
            break;
        case 3:
            $class = '';
            break;
        case 4:
            $class = 'mainTainServer';
            break;
        default:
            $class = 'goodServer';
            break;
    };
    echo CHtml::link($data->server_name, $href, array('class' => $class));
    ?>
</li>
