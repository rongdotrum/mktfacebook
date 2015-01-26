<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="language" content="en"/>
        <link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/favicon.ico" type="image/x-icon"/>
        <!-- blueprint CSS framework -->
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_assets; ?>/screen.css"
              media="screen, projection"/>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_assets; ?>/print.css"
              media="print"/>
        <!--[if lt IE 8]>
        <link rel="stylesheet" type="text/css" href="<?php echo $this->_assets; ?>/ie.css"
              media="screen, projection"/>
        <![endif]-->
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
        <?php cs()->registerScriptFile(app()->request->baseUrl . '/js/common.js', CClientScript::POS_HEAD) ?>
    </head>
    <body>
        <div class="container" id="page">
            <?php
            $this->widget('application.widgets.GWGNavbar');
            /* $this->widget('bootstrap.widgets.TbNavbar', array(
              'type' => 'inverse', // null or 'inverse'
              'brand' => 'G4G Control Panel',
              'brandUrl' => '/',
              'collapse' => true, // requires bootstrap-responsive.css
              'items' => array(
              array('class' => 'bootstrap.widgets.TbMenu',
              'items' => array(
              array('label' => 'Home', 'url' => array('/site/index')),
              array('label' => 'Tin tức', 'url' => array('/news/')),
              array('label' => 'Thể Loại', 'url' => array('/newscat/')),
              array('label' => 'Máy Chủ', 'url' => array('/server/')),
              array('label' => 'Tài khoản', 'url' => '#', 'items' => array(
              array('label' => 'Tài khoản hệ thống', 'url' => array('/systemusers/')),
              array('label' => 'Tài khoản người dùng', 'url' => array('/users/')),
              )),
              array('label' => 'Quản Lý Mục', 'url' => '#', 'items' => array(
              array('label' => 'controllers', 'url' => array('/controllers/')),
              // array('label' => 'Tài khoản người dùng', 'url' => array('/users/')),
              ), 'visible' => app()->user->getId() == 1 ? true : false),
              //array('label' => 'Nhóm', 'url' => array('/groups/')),
              )),
              array(
              'class' => 'bootstrap.widgets.TbMenu',
              'htmlOptions' => array('class' => 'pull-right'),
              'items' => array(
              array('label' => 'Login', 'url' => array('/site/login'), 'visible' => Yii::app()->user->isGuest),
              array('label' => 'Logout (' . Yii::app()->user->name . ')', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest)
              ),
              ),
              ),
              )); */
            ?>
            <!-- mainmenu -->
            <div class="container" style="margin:80px 15px 0">
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php
                    $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                    ));
                    ?><!-- breadcrumbs -->
                <?php endif ?>

                <?php echo $content; ?>
                <hr/>
                <div id="footer">
                    Copyright &copy; 2013 Bản quyền của Công ty OneSoft
                </div>
                <!-- footer -->
            </div>
        </div>
        <!-- page -->
    </body>
</html>
