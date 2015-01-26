<?php

$this->widget('zii.widgets.jui.CJuiAutoComplete', array(
    "model" => $model,
    "attribute" => $attribute,
    "sourceUrl" => $sourceUrl, //$this->createAbsoluteUrl('users/aclist'),
    'options' => $options,
    'htmlOptions' => $htmlOptions,
));
?>