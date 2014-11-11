<?php
class PhpAuthManager extends CPhpAuthManager{
    const ADMIN = '1';
    const DIRECTOR = '2';   
	const BOOKKEEPER = '3';
    const SRMANAGER = '4'; 
    const MANAGER = '5';
    const USER = '6';
    const USER_RETAIL = '7';
	
	public function init(){
        // Иерархию ролей расположим в файле auth.php в директории config приложения
        if($this->authFile===null){
            $this->authFile=Yii::getPathOfAlias('application.config.auth').'.php';
        }
 
        parent::init();
 
        // Для гостей у нас и так роль по умолчанию guest.
        if(!Yii::app()->user->isGuest){
            // Связываем роль, заданную в БД с идентификатором пользователя,
            // возвращаемым UserIdentity.getId()
            $this->assign(Yii::app()->user->role, Yii::app()->user->id);
        }
    }
}
?>