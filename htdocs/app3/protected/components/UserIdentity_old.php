<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	private $_id;
	// Custom error Constants
    const ERROR_USERNAME_NOT_ACTIVE = 3;   
    const ERROR_USER_IS_BANNED = 4; 
	const ERROR_EMAIL_NOT_ACTIVE = 5;
    const ERROR_EMAIL_NOT_PRESENT = 6;
	/* 
		The predifined constants from abstract class CBaseUserIdentity
		const ERROR_NONE=0;
		const ERROR_USERNAME_INVALID=1;
		const ERROR_PASSWORD_INVALID=2;
		const ERROR_UNKNOWN_IDENTITY=100; 
	*/
	/**
	 * Authenticates a user.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return errorCode; 
	 * if authentication succeeds errorCode = 0.
	 */
	public function authenticate()
	{
		$users = User::model()->findByAttributes(array('username'=>$this->username));
		// добавлено мной, проверка пользователь не забанен ли
		if($users->ban == 1) 
			$this->errorCode = self::ERROR_USER_IS_BANNED;
			
		elseif($users == null) 
			$this->errorCode=self::ERROR_USERNAME_INVALID;
			
		elseif (strcmp($this->password, $users->password))
			$this->errorCode=self::ERROR_PASSWORD_INVALID;
			
		// добавлено мной, проверка пользователь подтвердил ли регистрацию
		elseif($users->isActive == 0)
			$this->errorCode=self::ERROR_USERNAME_NOT_ACTIVE;
		else
			{
				$this->_id = $users->id;
				$this->setState('organization', $users->organization); 
				$this->setState('role', $users->role); 
				$this->setState('email', $users->email);
				$this->errorCode=self::ERROR_NONE;
			}
		return $this->errorCode;
	}	
	public function getId()
    {
        return $this->_id;
    } 
}