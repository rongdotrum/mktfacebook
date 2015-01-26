<?php
$cs = Yii::app()->clientScript;
$cs->registerMetaTag('text/html; charset=utf-8',null,'Content-Type');
$cs->registerMetaTag('IE=edge,chrome=1',null,'X-UA-Compatible');
$cs->registerMetaTag('vi',null,'content-language');
$cs->registerMetaTag($this->description,'description',null);
$cs->registerMetaTag($this->keywords,'keywords',null);
$cs->registerMetaTag('index,follow','robots',null);
$cs->registerMetaTag('1days','revisit-after',null);
$cs->registerMetaTag(Yii::app()->params['appfb_id'],null,null,array('property'=>'fb:app_id'));
$cs->registerMetaTag('website',null,null,array('property'=>'og:type'));
$cs->registerMetaTag($this->pageTitle,null,null,array('property'=>'og:title'));
$cs->registerMetaTag($this->description,null,null,array('property'=>'og:og:description'));
$cs->registerMetaTag(Yii::app()->createAbsoluteUrl(''),null,null,array('property'=>'og:url'));
$cs->registerMetaTag(Yii::app()->createAbsoluteUrl(''),null,null,array('property'=>'og:site_name'));
$cs->registerMetaTag($this->module->assetsUrl.'/css/'.$this->module->name.'/images/logo_slzg.png',null,null,array('property'=>'og:image'));

?>
<title><?= $this->pageTitle ?></title>