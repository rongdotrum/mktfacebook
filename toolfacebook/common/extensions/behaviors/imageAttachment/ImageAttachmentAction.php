<?php

/**
 * Action to handle calls from ImageAttachmentWidget,
 * and apply changes to model with ImageAttachmentBehavior
 *
 * @example
 *
 *    public function actions()
 *    {
 *        return array(
 *            'saveImageAttachment' => 'ext.imageAttachment.ImageAttachmentAction',
 *        );
 *    }
 *
 * @author Bogdan Savluk <savluk.bogdan@gmail.com>
 *
 */
class ImageAttachmentAction extends CAction {

    public function run($model, $behavior) {
        $id = $_GET['id'];
        $saveDb = $_GET['savedb'];
        $remove = isset($_POST['remove']) ? $_POST['remove'] : false;
        $crop = isset($_POST['crop']) ? $_POST['crop'] : false;
        $model = CActiveRecord::model($model)->findByPk($id);
        if ($remove) {
            $model->{$behavior}->removeImages();
            echo CJSON::encode(array());
        } elseif ($crop) {
            $img = isset($_POST['image']) ? $_POST['image'] : null;
            if ($img) {
                $img = str_replace('data:image/jpeg;base64,', '', $img);
                $img = str_replace(' ', '+', $img);
                $data = base64_decode($img);
                $file = $model->{$behavior}->directory . '/original/' . md5($id) . '.jpg';
                if ($success = file_put_contents($file, $data))
                    $model->{$behavior}->updateImages();
            }
            return;
        } else {
            $imageFile = CUploadedFile::getInstanceByName('image');
            $model->{$behavior}->setImage($imageFile->getTempName());
            if (empty($model->avatar_path) && $saveDb) {
                $avatar_path = $model->{$behavior}->getUrl('preview');
                $pos = strpos($avatar_path, '?_=');
                $count = strlen($avatar_path);
                $model->avatar_path = substr($avatar_path, strpos($avatar_path, app()->user->id), $pos - $count);
                $model->active_flag = 1;
                $model->upload_datetime = date('Y-m-d H:s:i');
                $model->del_flg = 1;
                $model->save();
            }
            echo CJSON::encode(array(
                'previewUrl' => $model->{$behavior}->getUrl('preview'),
            ));
        }
    }

}

