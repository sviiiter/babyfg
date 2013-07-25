<?php
    class WebUser extends CWebUser {
        private $_model = null;


        function getEmail() {
            if($user = $this->getModel()){
                return $user->email; // имя свойства = имени поля в таблице
            }
        }


        private function getModel(){
            if (!$this->isGuest && $this->_model === null){
                $this->_model = User::model()->findByPk($this->id);
            }
            return $this->_model;
        }
    }
   