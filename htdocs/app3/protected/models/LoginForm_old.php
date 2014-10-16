<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $email;
	public $password;
	public $rememberMe;

	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		return array(
			// username and password are required
			array('email, password', 'required'),
			// rememberMe needs to be a boolean
			array('rememberMe', 'boolean'),
			// password needs to be authenticated
			array('password', 'authenticate'),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'rememberMe'=>Yii::t('general', "Remember me"),// 'Запомнить меня',
			'username' => Yii::t('general', "Username"),
			'password' => Yii::t('general', "Password"),
			'email' => Yii::t('general', "Email"),
		);
	}

	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
	public function authenticate($attribute,$params)// don't forget, THIS IS password VALIDATOR
	{
		if(!$this->hasErrors())
		{
			$this->_identity=new UserIdentity($this->username, $this->password);
			/*старая версия: if(!$this->_identity->authenticate())
				$this->addError('password','Incorrect username or password.'); */
			/* новая версия  http://www.yiiframework.com/wiki/463/custom-login-error-messages/ */
			if($this->_identity->authenticate() == UserIdentity::ERROR_USERNAME_INVALID)
				$this->addError('username','Неправильное имя пользователя.');				
			else if($this->_identity->authenticate() == UserIdentity::ERROR_PASSWORD_INVALID)
				$this->addError('password','Неправильный пароль.');				
			else if($this->_identity->authenticate() == UserIdentity::ERROR_USERNAME_NOT_ACTIVE)
				$this->addError('username', 'Пользователь не активен. Пожалуйста подтвердите регистрацию используя ссылку в вашем письме и попытайтесь снова');				
			else if($this->_identity->authenticate() == UserIdentity::ERROR_USER_IS_BANNED)
				$this->addError('username', 'Этот пользователь забанен. Пожалуйста обратитель к '. CHtml::link('администратору сайта', 'mailto:' . Yii::app()->params['adminEmail']) . '.');
		}
	}

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new UserIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===UserIdentity::ERROR_NONE)
		{
			$duration=$this->rememberMe ? 3600*24*30 : 0; // 30 days
			Yii::app()->user->login($this->_identity,$duration);
			return true;
		}
		else
			return false;
	}
}
