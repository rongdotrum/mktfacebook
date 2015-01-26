<?php
Yii::setPathOfAlias('news', __DIR__ . '/../../news');
$theme = 'cuugioi';
return CMap::mergeArray(
    array(), (file_exists(__DIR__ . "/theme/$theme.php") ? require(__DIR__ . "/theme/$theme.php") : array())
)
?>
