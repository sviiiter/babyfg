<?php
    class WebUser extends CWebUser {
        private $_model = null;

        function getEmail() {
            if($user = $this->getModel()){
                return $user->email; // имя свойства = имени поля в таблице
            }
        }

        public function getRole() {
            if($user = $this->getModel()){              
                // в таблице User есть поле role
                return $user->role;
            }
        }        

        public function getRoleName() {
            if($user = $this->getModel()){              
                // в таблице User есть поле role
                return $user->rolename;
            }
        }         
        
        private function getModel(){
            if (!$this->isGuest && $this->_model === null){
                $this->_model = User::model()->findByPk($this->id);
            }

            return $this->_model;
        }
    }
   