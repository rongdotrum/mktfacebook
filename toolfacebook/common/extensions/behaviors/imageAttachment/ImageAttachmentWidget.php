<?php

/**
 * Widget to provide interface for image upload to models with
 * ImageAttachmentBehavior.
 * @example
 *
 *   $this->widget('ext.imageAttachment.ImageAttachmentWidget', array(
 *       'model' => $model,
 *       'behaviorName' => 'previewImageAttachmentBehavior',
 *       'apiRoute' => 'api/saveImageAttachment',
 *   ));
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 */
class ImageAttachmentWidget extends CWidget {

    /**
     * Route to ImageAttachmentAction
     * @var string
     */
    public $apiRoute;
    public $assets;

    /**
     * Behaviour name in model to use
     * @var string
     */
    public $behaviorName;

    /**
     * Model with behaviour
     * @var CActiveRecord
     */
    public $model;
    public $htmlOptions;
    public $crop = false;
    public $saveDb = false;

    /**
     * @return ImageAttachmentBehavior
     */
    public function getBehavior() {
        return $this->model->{$this->behaviorName};
    }

    public function init() {
        $this->assets = Yii::app()->getAssetManager()->publish(dirname(__FILE__) . '/assets');
    }

    public function run() {
        /** @var $cs CClientScript */
        $cs = Yii::app()->clientScript;
        $cs->registerCssFile($this->assets . '/imageAttachment.css');

        $cs->registerCoreScript('jquery');

        $cs->registerScriptFile($this->assets . '/jquery.iframe-transport.js');
        $cs->registerScriptFile($this->assets . '/jquery.imageAttachment.js');
        if ($this->crop)
            $cs->registerScriptFile($this->assets . '/crop_script.js');

        if ($this->apiRoute === null)
            throw new CException('$apiRoute must be set.', 500);


        $options = array(
            'hasImage' => $this->behavior->hasImage(),
            'previewUrl' => $this->behavior->getUrl(isset($this->htmlOptions['size']) ? $this->htmlOptions['size'] : 'preview'),
            'previewWidth' => isset($this->htmlOptions['previewWidth']) ? $this->htmlOptions['previewWidth'] : $this->behavior->previewWidth,
            'previewHeight' => isset($this->htmlOptions['previewHeight']) ? $this->htmlOptions['previewHeight'] : $this->behavior->previewHeight,
            'apiUrl' => $this->getController()->createUrl($this->apiRoute, array(
                'model' => get_class($this->behavior->owner),
                'behavior' => $this->behaviorName,
                'id' => $this->behavior->owner->getPrimaryKey(),
                'savedb' => $this->saveDb,
            )),
            'crop' => $this->crop,
        );

        if (Yii::app()->request->enableCsrfValidation) {
            $options['csrfTokenName'] = Yii::app()->request->csrfTokenName;
            $options['csrfToken'] = Yii::app()->request->csrfToken;
        }

        $optionsJS = CJavaScript::encode($options);
        $cs->registerScript('imageAttachment#' . $this->id, "$('#{$this->id}').imageAttachment({$optionsJS});");

        $this->render('imageAttachment');
    }

}

