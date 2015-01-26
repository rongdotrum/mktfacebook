<?php

/**
 * SiteController.php
 *
 * @author: antonio ramirez <antonio@clevertech.biz>
 * Date: 7/23/12
 * Time: 12:25 AM
 */
class SiteController extends Controller {

    //    public function filters() {
    //        return array(
    //            array(
    //                'COutputCache',
    //                'duration' => 100,
    //                'varyByParam' => array('id'),
    //            ),
    //        );
    //    }

    public function accessRules() {
        return array(
            // not logged in users should be able to login and view captcha images as well as errors
            array('allow', 'actions' => array('index', 'captcha', 'lgoin', 'error', 'KK')),
            // logged in users can do whatever they want to
            array('allow', 'users' => array('@')),
            // not logged in users can't do anything except above
            array('deny'),
        );
    }

    /**
     * Declares class-based actions.
     * @return array
     */
    public function actions() {
        return array(
            // captcha action renders the CAPTCHA image displayed on the contact page
            'captcha' => array(
                'class' => 'CCaptchaAction',
                'backColor' => 0xFFFFFF,
            ),
            'gauto.' => array(
                'class' => 'common.widgets.gautocomplete.GTextAutoComplete',
                'aclist' => array(
                    'model' => r()->getQuery('model'),
                    'attribute' => r()->getQuery('attribute'),)
            ),
            'oauth' => array(
                // the list of additional properties of this action is below
                'class' => 'common.extensions.hoauth.HOAuthAction',
                // Yii alias for your user's model, or simply class name, when it already on yii's import path
                // default value of this property is: Users
                'model' => 'Users',
                // map model attributes to attributes of user's social profile
                // model attribute => profile attribute
                // the list of avaible attributes is below
                'attributes' => array(
                        'email' => 'email',
                        'display_name' => 'identifier',
                        'activate_status' => 1,
                        'social_name'=>'displayName',
                        'password' => md5('!@#$social!@#$'),
                    ),
                ),

        );
    }

    public function MainAction($Urlmodule, $UrlSite, $Module, $CatId) {

        $Id = app()->request->getParam('id');

        if ($Id != '') {
            $process = new GNewsProcess();
            $News = $process->GetNewsDetail($Id);
            $this->pageTitle = $News->Title.'-'.$this->pageTitle;
            $Cat = $process->GetCat($News['CatId']);
            $this->render('/news/detail', array('Cat' => $Cat, 'News' => $News, 'Urlmodule' => $Urlmodule, 'UrlSite' => $UrlSite, 'module' => $Module));
        } else {

            $UrlSite = app()->createUrl('site');
            $process = new GNewsProcess();
            if ($CatId == '')
            {
                $dataProvider = $process->getListNewsTonghop();
                $this->pageTitle = 'Tin tức tổng hợp - '.$this->pageTitle;
            }
            else {
                $dataProvider = $process->getListNewsCat($CatId);
                $this->pageTitle = $Module.' - '.$this->pageTitle;
            }
             
            $this->render('/news/list', array('UrlSite' => $UrlSite, 'module' => $Module, 'dataProvider' => $dataProvider, 'Urlmodule' => $Urlmodule));
        }
    }

    public function actionTonghop() {

        $Urlmodule = app()->createUrl('site/tonghop');
        $UrlSite = app()->createUrl('site');
        $Module = 'Tổng hợp';
        $CatId = '';
        $this->MainAction($Urlmodule, $UrlSite, $Module, $CatId);
    }



    public function actionTintuc() {        
        $cat = app()->request->getParam('cat');
        $Urlmodule = app()->createUrl("article/$cat");
        $UrlSite = app()->createUrl('site');
        $process = new GNewsProcess();
        $ObjectCat = $process->getCatObject($cat);        
        $Module = $ObjectCat['CatName'];
        if ($Module == '')
            $Module = 'Tổng hợp';
        $CatId = $ObjectCat['CatId'];
        $this->MainAction($Urlmodule, $UrlSite, $Module, $CatId);
    }

  

    /* open on startup */

    public function actionIndex() {

        if (isset($_GET['PowerFight'])) {
            $powerfight = new PowerFight('search');
            $powerfight->unsetAttributes();  // clear any default values
            $powerfight->attributes = $_GET['PowerFight'];
            $this->render('/GWGPowerFight/GWGPowerFight', array('powerfight' => $powerfight));
        }
        else
            $this->render('/site/index');
    }

    /**
     * This is the action to handle external exceptions.
     */
    public function actionError() {
        if ($error = Yii::app()->errorHandler->error) {
            if (Yii::app()->request->isAjaxRequest)
                echo $error['message'];
            else
                $this->render('error', $error);
        }
    }

}
