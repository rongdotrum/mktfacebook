<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of WebUser
 *
 * @author Nhien(hdnhien@gmail.com)
 */
class GWebUser extends CWebUser {

    protected $_model;

    public function __construct() {
        $this->loginUrl = '/authentic/login';
    }

    /*
     * Region Extended Properties Start
     */

    public function email() {
        if ($this->isGuest)
            return "";
        //Lay thong tin nguoi dung login (Class ExtUser)
        $user = $this->getUserInfo();
        return $user->email;
    }

    public function display_name() {
        if ($this->isGuest)
            return "";
        //Lay thong tin nguoi dung login (Class ExtUser)
        $user = $this->getUserInfo();
        return $user->display_name;
    }
    
    public function social_name() {        
         if ($this->isGuest)
            return "";
        //Lay thong tin nguoi dung login (Class ExtUser)
        $user = $this->loadUser();       
        if (isset($user->social_name)) 
            return $user->social_name;
        return '';
    }

    public function loginname() {
        if ($this->isGuest)
            return "";
        //Lay thong tin nguoi dung login (Class ExtUser)
        $user = $this->getUserInfo();
        return $user->login_name;
    }

    /*
     * Region Extended Properties End
     */

  /*  public function login($identity, $duration = 0) {
        parent::login($identity, $duration);
        if ($duration > 0)
            Yii::app()->getSession()->add('model', $identity->getModel());
    }*/
     public function login($identity, $duration = 0) {
      
        if ($duration > 0)
            Yii::app()->getSession()->add('model', $identity->getModel());
        return parent::login($identity, $duration);
    }


    public function logout($destroySession = true) {
        Yii::app()->getSession()->remove('model');
        parent::logout($destroySession);
    }

    protected function afterLogin($fromCookie) {
        parent::afterLogin($fromCookie);
    }

    protected function afterLogout() {
        parent::afterLogout();
    }

    protected function beforeLogin($id, $states, $fromCookie) {
        return parent::beforeLogin($id, $states, $fromCookie);
    }

    protected function beforeLogout() {
        return parent::beforeLogout();
    }

    // Load user model.
    protected function loadUser() {
        if ($this->_model === null) {
            $this->_model = Users::model()->findByPk($this->id);
        }
        return $this->_model;
    }

    public function activate() {
        return $this->loadUser()->activate_status;
    }

}

?>
