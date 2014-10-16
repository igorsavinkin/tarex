<?php
class WebUser extends CWebUser {
    private $_model = null;
 
    function getRole() {
        if($user = $this->getModel()){
            // в таблице User есть поле role
            return $user->role;
        }
    }
	function getOrganization() {
        if($user = $this->getModel()){
            // в таблице User есть поле organization
            return $user->organization;
        }
    }
	function getCity() {
        if($user = $this->getModel()){
            // в таблице User есть поле city
            return $user->city;
        }
    }
	function setCity($city) {
        if($user = $this->getModel()){
            // в таблице User есть поле organization
			$user->city = $city;
			if ($user->save(false)) return 1; 
			else return 0;
        }
    }
 
    private function getModel(){
        if (!$this->isGuest && $this->_model === null){
            $this->_model = User::model()->findByPk($this->id, array('select' => 'role'));
        }
        return $this->_model;
    }
}
?>