<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
    $this->renderPartial('/partial/_meta');
?>
    <link type="text/css" rel="stylesheet" href="<?php echo $this->module->assetsUrl .'/css/'.$this->module->name.'/maintenance.css'?>" />
        <?php
        $time = strtotime($model['published_date']);
        $time = getdate($time);
        ?>
        <script type="text/javascript" LANGUAGE="JavaScript">
            dateFuture = new Date(<?php echo $time['year'] . ', ' . ((int) $time['mon'] - 1) . ', ' . $time['mday'] . ', ' . $time['hours'] . ', ' . $time['minutes'] . ', ' . $time['seconds'] ?>);
            function GetCount()
            {
                dateNow = new Date();
                //grab current date
                amount = dateFuture.getTime() - dateNow.getTime();                //calc milliseconds between dates
                delete dateNow;

                // time is already past
                if (amount < 0) {
                     document.location.reload();
                }
                // date is still good
                else {
                    days = 0;
                    hours = 0;
                    mins = 0;
                    secs = 0;
                    out = "";

                    amount = Math.floor(amount / 1000);//kill the "milliseconds" so just secs

                    days = Math.floor(amount / 86400);//days
                    amount = amount % 86400;

                    hours = Math.floor(amount / 3600);//hours
                    amount = amount % 3600;

                    mins = Math.floor(amount / 60);//minutes
                    amount = amount % 60;

                    secs = Math.floor(amount);//seconds

                    if (days != 0) {
                        out += days + " ngày" + ((days != 1) ? "s" : "") + ", ";
                    }
                    if (days != 0 || hours != 0) {
                        out += hours + ":";
                    }
                    if (days != 0 || hours != 0 || mins != 0) {
                        out += mins + ":";
                    }
                    out += secs + " giây";
                    days = addnumber(days);
                    document.getElementById('ngay').innerHTML = days;
                    hours = addnumber(hours);
                    document.getElementById('gio').innerHTML = hours;
                    mins = addnumber(mins);
                    document.getElementById('phut').innerHTML = mins;
                    secs = addnumber(secs);
                    document.getElementById('giay').innerHTML = secs;
                    setTimeout("GetCount()", 1000);
                }
            }
            window.onload = function() {
                nowdate = new Date();
                if (dateFuture.getTime() > nowdate.getTime())
                    GetCount();
            }//call when everything has loaded
            function addnumber(time) {
                if (time < 10)
                    time = "0" + time;
                if (time == null)
                    time = "00";
                return time;
            }
        </script>
    </head>
    <body>
        <div id="wrapper">
            <div id="top">
                <div id="head" style="margin:0 auto;text-align: center;">
                    <div id="server">
                        <h1><?php echo $model["server_name"]; ?></h1>
                    </div>
                    <div id="date">
                        <h1><?php echo str_replace("/", "-", date("d/m/Y", strtotime($model["published_date"]))); ?></h1>
                    </div>
                    <div id="time">
                        <div id="ngay">00</div>
                        <div id="gio">00</div>
                        <div id="phut">00</div>
                        <div id="giay">00</div>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>
            <div id="content">
                <div id="left" align="center">
                    <div id="button">
                          <div id="button">
                                    <a href="<?= $this->url_home ?>" id="trangchu" target="_blank">FanPage</a>
                                    <a href="<?= Yii::app()->params['facebook'] ?>" id="fanpage" target="_blank">FanPage</a>
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
