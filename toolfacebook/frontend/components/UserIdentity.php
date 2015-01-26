<?php

    /**
    * UserIdentity.php
    *
    * This class represents a user identity and this is able to authenticate a user.
    *
    * @author: antonio ramirez <antonio@clevertech.biz>
    * Date: 7/22/12
    * Time: 8:36 PM
    *
    *
    */
    class UserIdentity extends CUserIdentity {

        /**
        * @var integer id of logged user
        */
        private $_id;

        /**
        *
        * @var UserInfo model object
        */
        private $_model;

        public function __construct($username,$password=null)
        {
            // sets username and password values
            parent::__construct($username,$password);
            $attribute = strpos($this->username, '@') ? 'email' : 'display_name';
            $user = ExtUsers::model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username))); //->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username)));
            if (!empty($user)) {
                $user->regenerateValidationKey();
                $this->_id = $user->user_id;
                $this->_model = $user;
                $this->username = $user->display_name;
                $this->setState('vkey', $user->validation_key);
                $this->errorCode = self::ERROR_NONE;
            }
        }

        /**
        * Authenticates username and password
        * @return boolean CUserIdentity::ERROR_NONE if successful authentication
        */
        public function authenticate() {
            $attribute = strpos($this->username, '@') ? 'email' : 'display_name';
            $user = ExtUsers::model()->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username))); //->find(array('condition' => $attribute . '=:loginname', 'params' => array(':loginname' => $this->username)));

            if ($user === null) {
                $this->errorCode = self::ERROR_USERNAME_INVALID;
            } else if (!$user->verifyPassword($this->password)) {
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            } else {
                $user->regenerateValidationKey();
                $this->_id = $user->user_id;
                $this->_model = $user;
                $this->username = $user->display_name;
                $this->setState('vkey', $user->validation_key);
                $this->errorCode = self::ERROR_NONE;
            }
            return !$this->errorCode;
        }

        /**
        * Creates an authenticated user with no passwords for registration
        * process (checkout)
        * @param string $username
        * @return self
        */
        public static function createAuthenticatedIdentity($id, $username) {
            $identity = new self($username, '');
            $identity->_id = $id;
            $identity->errorCode = self::ERROR_NONE;
            return $identity;
        }

        /**
        *
        * @return integer id of the logged user, null if not set
        */
        public function getId() {
            return $this->_id;
        }

        public function getModel() {
            return $this->loadUser();
        }

        protected function loadUser() {

            if ($this->_model === null) {
                $this->_model = ExtUsers::model()->findByPk($this->_id);
            }
            return $this->_model;
        }

    }
