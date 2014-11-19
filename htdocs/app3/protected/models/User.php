<?php
/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property integer $isActive
 * @property string $created
 * @property integer $parentId
 * @property integer $role
 * @property integer $ban
 * @property string $phone
 * @property string $city
 * @property string $address
 * @property integer $isLegalEntity
 * @property string $email
 * @property integer $organization
 * @property integer $discount
 * @property integer $paymentDelay
 * @property integer $debtLimit
 * @property string $legalAddress
 * @property string $Bank
 * @property string $CorrespondentAccount
 * @property string $OrganizationInfo
 * @property string $INN
 * @property string $KPP
 * @property integer $PaymentMethod
 * @property string $BIC
 * @property string $CurrentAccount
 * @property integer $ShippingMethod
 * @property string $OKVED
 * @property string $OKPO
 * @property integer $KnowingSource
 * @property integer $scopeOfActivity
 * @property string $email2
 * @property string $CEOname
 * @property string $AccountantName
 * @property string $priceConfig
 * @property string $carMakes
 * @property string $operationCondition
 * @property string $name
 */
class User extends CActiveRecord
{
	const ROLE_ADMIN = '1';
    const ROLE_DIRECTOR = '2';
	const ROLE_ACCOUNTER = '3';
    const ROLE_SENIOR_MANAGER = '4';
    const ROLE_MANAGER = '5';
    const ROLE_USER = '6';
	const ROLE_USER_RETAIL='7'; 
    const ROLE_BANNED = 'banned';
	
	public $password_repeat, $theSameAddress, $city_new, $pageSize, $agree;
	
	public $old_password, $new_password; // дополнительная переменная для смены пароля
	
	public $verifyCode;
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user}}';
	}
	
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('isActive, parentId, role, ban, isLegalEntity, organization, discount, paymentDelay, debtLimit, PaymentMethod, ShippingMethod, KnowingSource, scopeOfActivity, ShablonId, agree', 'numerical', 'integerOnly'=>true),
			array('username, password, address, legalAddress, Bank, OrganizationInfo,  notes, name', 'length', 'max'=>255),
			array('phone, email, isCustomer, isEmployee, isSeller', 'length', 'max'=>50),
			array('city, CorrespondentAccount, INN, KPP, BIC, CurrentAccount, OKVED, OKPO, email2, CEOname, AccountantName, Group', 'length', 'max'=>63),
			array('priceConfig, Accounts, Childs', 'length', 'max'=>1000),
			
			array('verifyCode', 'captcha', 'allowEmpty'=>!CCaptcha::checkRequirements(),'on' => 'register'),			
			
			array('password', 'compare', 'compareAttribute'=>'password_repeat',  'on'=>'register', 'message'=> Yii::t('general',"Password repeat does not match password")   ), 	
			
			//array('username, password, email, role, organization, agree', 'required' , 'except'=>'retail,insert'),  
		
			array('password_repeat, agree, email, password, phone', 'required' , 'on'=>'register'), 
			array('agree', 'required' , 'requiredValue' => 1, 'message' => Yii::t('general','You should agree term to use our service') , 'on'=>'register'), 
			
			 array('phone', 'phoneNumber'),
			
			array('email, username, phone, PaymentMethod, ShippingMethod', 'required' , 'on'=>'retail'), 
			
			array('username, email', 'unique'),
			// создадим свои (custom) правилa валидации
			array('password', 'passwordStrength', 'on'=>'register'),
			  
			array('isLegalEntity', 'bankDetailsRequired', 
					'bankDetailsFields'=>'OrganizationInfo,CorrespondentAccount,INN,KPP,BIC,CurrentAccount,Bank',
					'on'=>'retail,insert'
					),
			array('PaymentMethod', 'bankDetailsRequired2', 
					'bankDetailsFields'=>'OrganizationInfo,CorrespondentAccount,INN,KPP,BIC,CurrentAccount,Bank',
					'on'=>'retail'
					),
			
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, username, password, isActive, created, parentId, role, ban, phone, city, address, isLegalEntity, email, organization, discount, paymentDelay, debtLimit, legalAddress, Bank, CorrespondentAccount, OrganizationInfo, INN, KPP, PaymentMethod, BIC, CurrentAccount, ShippingMethod, OKVED, OKPO, KnowingSource, scopeOfActivity, email2, CEOname, Accounts ,Childs,AccountantName, priceConfig, carMakes, operationCondition, name, ShablonId, city_new, pageSize, agree, notes', 'safe', 'on'=>'search, insert, register'),
		);
	}
 
	public function relations()
	{ 
		return array(
			'parent'=> array(self::BELONGS_TO, 'User', 'parentId'),  		
		);
	}
	public function phoneNumber($attribute,$params='')
	{
		if(preg_match("/^\+?[\d-()\s]{8,}$/", $this->$attribute) === 0)
		{   
			$this->addError($attribute,
				Yii::t('general','Contact phone should be in the following form' ) . ': +7495 1234567 ' . Yii::t('general','or') . ' 495-123-45-67' );  
		}   
	}
	public function passwordStrength($attribute, $params) 
	{
		$pattern = '/.{6,}/'; // any six or more characters 
		if(!preg_match($pattern, $this->$attribute))
		  $this->addError($attribute, 'Пароль должен содержать не менее 5-ти символов!');
	} 
	public function bankDetailsRequired($attribute, $params) 
	{
		if ($this->$attribute) // ecли атрибут нулевой, тогда не проверяем 
		{
			$this->checkFormFields($params['bankDetailsFields']);
		}     
	}
	public function bankDetailsRequired2($attribute, $params) 
	{
		if ($this->$attribute == '1') // ecли атрибут == 1 (безнал), тогда  проверяем 
		{
			$this->checkFormFields($params['bankDetailsFields']); 		
		}   
	} 
	public function checkFormFields($params /* array*/)
	{
		$patternAccount = '/\d{20}/'; // двадцать цифр
		$patternBic = '/\d{9}/'; // девять цифр
		$patternINN = '/\d{10,12}/'; // от десяти до двенадцати цифр
		$fields = explode(',', $params); // получаем имена обязательных полей
		foreach ($fields as $field)
		 { 
			 if($this->$field == '') 
				$this->addError($this->$field, Yii::t('general', $this->getAttributeLabel($field) ) .' '. Yii::t('general', 'should not be empty')); 
			if( $field == 'CurrentAccount' OR $field == 'CorrespondentAccount' ) 
			{ 
				if(!preg_match($patternAccount, $this->$field))
					$this->addError($this->$field, Yii::t('general', $this->getAttributeLabel($field) ) .' '. Yii::t('general', 'should contain exact 20 digits')); 
			}				
			elseif( $field == 'BIC' ) 
			{ 
				if(!preg_match($patternBic, $this->$field))
					$this->addError($this->$field, Yii::t('general', $this->getAttributeLabel($field) ) .' '. Yii::t('general', 'should contain exact 9 digits')); 
			}
			elseif( $field == 'INN' ) 
			{ 
				if(!preg_match($patternINN, $this->$field))
					$this->addError($this->$field, Yii::t('general', $this->getAttributeLabel($field) ) .' '. Yii::t('general', 'should contain between 10 and 12 digits')); 
			}
		 } 		
	} 
	public function uniqueCustom($attribute) 
	{
		$usernames=User::model()->findAll()->username;
		if ($usernames && (false !== array_search($attribute, $usernames) ) ) {
		    $this->addError($attribute, 'Такое имя пользователя уже есть в системе!');
		};
	}
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('general','ID'),
			'username' => Yii::t('general','Client id'),//Yii::t('general','User name'),
			'password' => Yii::t('general','Password'),
			'isActive' => Yii::t('general', 'User is active'),
			'created' => Yii::t('general','Created'),
			'parentId' => Yii::t('general','Parent'),
			'role' => Yii::t('general','User Role'),
			'ban' => Yii::t('general','закрыт ли для него доступ. По умолчанию открыт.'),
			'Group' => Yii::t('general','Group'),
			'phone' => Yii::t('general','Phone'),
			'city' => Yii::t('general','City'),
			'address' => Yii::t('general','Address'),
			'isLegalEntity' => Yii::t('general','is Legal Entity'),
			'email' => Yii::t('general','Email'),
			'organization' => Yii::t('general','Organization'), //'Организация',
			'OrganizationInfo' => Yii::t('general','Organization name'), //'Наименование Организации', 
			'discount' => Yii::t('general','Discount'),
			'INN' => Yii::t('general','INN'),
			'KPP' => Yii::t('general','KPP'),
				'PaymentMethod' => Yii::t('general', 'Payment Method' ),			
			'BIC' => Yii::t('general', 'BIC'),
			'CurrentAccount' =>  Yii::t('general', 'Current Account' ),
			'ShippingMethod' => Yii::t('general', 'Shipping Method'),
			'OKVED' => Yii::t('general', 'OKVED' ),
			'OKPO' =>  Yii::t('general',  'OKPO'),
			'KnowingSource' => Yii::t('general', 'How did you hear about us'),
		//	'scopeOfActivity' =>  Yii::t('general', 'scope of Organization activity' ),
			'scopeOfActivity' =>  Yii::t('general', 'Scope Of Activity' ),
			'CEOname' => Yii::t('general', 'CEO Name' ), //Yii::t('general', 'CEO Name' ),
			'AccountantName' => Yii::t('general', 'Contact person'), //Yii::t('general', 'Accountant Name' ),
			'carMakes' => Yii::t('general', 'Car makes'),
			'priceConfig' => Yii::t('general', 'Price config' ),
			'file' => 'Загрузить файл c прайсом',
			'old_password'=>Yii::t('general','Old password'),
			'new_password'=>Yii::t('general','New password'),
			'discount'=>Yii::t('general','Discount') . ', %',
			'operationCondition'=>Yii::t('general','Operation conditions'),
			'CorrespondentAccount' => Yii::t('general','Correspondent Account'),
			'Bank' => Yii::t('general', 'Bank'),
			'ShablonId' => Yii::t('general','Data Load Template'),
			'name' => Yii::t('general','Contractor'), // здесь в этом поле мы храним имя "контрактор" (как бы второе имя для пользователя)
			'password_repeat'=>Yii::t('general','Repeat Password'),
			'verifyCode'=>Yii::t('general','Verify code'), 
			'isEmployee'=>Yii::t('general','is Employee'),
			'isCustomer'=>Yii::t('general','is Customer'),
			'isSeller'=>Yii::t('general','is Seller'), 
			'agree'=>Yii::t('general','Agree with the contract'), 
			'notes'=>Yii::t('general','Notes'), 
			 
		);
	} 
 
	public function search($employee=null)
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('isActive',$this->isActive);
		$criteria->compare('created',$this->created,true);
		if (Yii::app()->user->role == User::ROLE_MANAGER) // если менеджер то видит только своих подчинённых		
		{
			$criteria2= new CDbCriteria;
			$criteria2->select = array('id');
			$criteria2->compare('parentId', Yii::app()->user->id);
			$children = User::model()->findAll($criteria2);	// print_r($children); 	
			foreach($children as $child) 		
				$subbbordinates[]=$child->id;	
			$criteria->addInCondition('id', $subbbordinates);
		}
		else
			$criteria->compare('parentId',$this->parentId);
		if ($employee)
		{			
			if ($this->role && Yii::app()->user->role <= $this->role )
				$criteria->compare('role', $this->role);
			else {	
				$roles = array(); for($i=User::ROLE_MANAGER; $i >= Yii::app()->user->role; $i-- ) { $roles[] = $i; }	
				$criteria->addInCondition('role', $roles);
			}
		} else {	
			$criteria->compare('role',$this->role);
			$criteria->addCondition('role >= '. User::ROLE_USER);
		}
		$criteria->compare('ban',$this->ban);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('isLegalEntity',$this->isLegalEntity);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('organization',$this->organization);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('paymentDelay',$this->paymentDelay);
		$criteria->compare('debtLimit',$this->debtLimit);
		$criteria->compare('legalAddress',$this->legalAddress,true);
		$criteria->compare('Bank',$this->Bank,true);
		$criteria->compare('CorrespondentAccount',$this->CorrespondentAccount,true);
		$criteria->compare('OrganizationInfo',$this->OrganizationInfo,true);
		$criteria->compare('INN',$this->INN,true);
		$criteria->compare('KPP',$this->KPP,true);
		$criteria->compare('PaymentMethod',$this->PaymentMethod);
		$criteria->compare('BIC',$this->BIC,true);
		$criteria->compare('CurrentAccount',$this->CurrentAccount,true);
		$criteria->compare('ShippingMethod',$this->ShippingMethod);
		$criteria->compare('OKVED',$this->OKVED,true);
		$criteria->compare('OKPO',$this->OKPO,true);
		$criteria->compare('KnowingSource',$this->KnowingSource);
		$criteria->compare('scopeOfActivity',$this->scopeOfActivity);
		$criteria->compare('email2',$this->email2,true);
		$criteria->compare('CEOname',$this->CEOname,true);
		$criteria->compare('AccountantName',$this->AccountantName,true);
		$criteria->compare('priceConfig',$this->priceConfig,true);
		$criteria->compare('carMakes',$this->carMakes,true);
		$criteria->compare('operationCondition',$this->operationCondition,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('isCustomer',$this->name,true);
		$criteria->compare('isEmployee',$this->name,true);
		$criteria->compare('isSeller',$this->name,true); 
		
		$criteria->order='id DESC'; 
		
		/*if(Yii::app()->user->role>2){
			$criteria->compare('isCustomer', 1);
		}*/
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		//	'pagination'=>array('pageSize'=>$pageSize),
		));
	}
	
	public function stool()
	{ 
	 	$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		
		$criteria->compare('created',$this->created,true);
		$criteria->compare('parentId',$this->parentId);
		$criteria->compare('role',$this->role);
		$criteria->compare('ban',$this->ban);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('isLegalEntity',$this->isLegalEntity);
		$criteria->compare('email',$this->email,true);
		
		$criteria->compare('discount',$this->discount);
		$criteria->compare('paymentDelay',$this->paymentDelay);
		$criteria->compare('debtLimit',$this->debtLimit);
		$criteria->compare('legalAddress',$this->legalAddress,true);
		$criteria->compare('Bank',$this->Bank,true);
		$criteria->compare('CorrespondentAccount',$this->CorrespondentAccount,true);
		$criteria->compare('OrganizationInfo',$this->OrganizationInfo,true);
		$criteria->compare('INN',$this->INN,true);
		$criteria->compare('KPP',$this->KPP,true);
		$criteria->compare('PaymentMethod',$this->PaymentMethod);
		$criteria->compare('BIC',$this->BIC,true);
		$criteria->compare('CurrentAccount',$this->CurrentAccount,true);
		$criteria->compare('ShippingMethod',$this->ShippingMethod);
		$criteria->compare('OKVED',$this->OKVED,true);
		$criteria->compare('OKPO',$this->OKPO,true);
		$criteria->compare('KnowingSource',$this->KnowingSource);
		$criteria->compare('scopeOfActivity',$this->scopeOfActivity);
		$criteria->compare('email2',$this->email2,true);
		$criteria->compare('CEOname',$this->CEOname,true);
		$criteria->compare('AccountantName',$this->AccountantName,true);
		$criteria->compare('priceConfig',$this->priceConfig,true);
		$criteria->compare('carMakes',$this->carMakes,true);
		$criteria->compare('operationCondition',$this->operationCondition,true);
		$criteria->compare('name',$this->name,true);
	   
	// pre-set parameters
		$criteria->compare('isCustomer', '1');  
		//$criteria->compare('isEmployee', '1');   
		$criteria->compare('isActive', '1'); 
		if(Yii::app()->user->role != User::ROLE_ADMIN) 
			$criteria->compare('organization', Yii::app()->user->organization);		  
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria, 
			'pagination'=>array('pageSize'=>3),
		));
	} 
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	public function newlyRegistered()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('isActive', 0 );
		$criteria->compare('isLegalEntity', $this->isLegalEntity,true);
		$criteria->compare('phone', $this->phone,true);
		$criteria->compare('city',$this->city,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('created', $this->created,true);
		$criteria->compare('organization', Yii::app()->params['organization']);
		//$criteria->compare('role', User::ROLE_USER_RETAIL);
		$criteria->compare('ban',$this->ban);
		$criteria->compare('email',$this->email,true);
		$criteria->order = 'created DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	public function getParentDropDown() 
	{
		$managers = CHtml::listData(User::model()->findAll('role = '. User::ROLE_MANAGER .' OR role = '. User::ROLE_SENIOR_MANAGER), 'id', 'username');		
		return CHtml::dropDownList('User[parentId]', $this->parentId, $managers);         
	}
	public function allChildren($userId)
	{
		$criteria = new CDbCriteria;
		$criteria->select='id';
		$criteria->compare('parentId', $userId);
		$users = self::model()->findAll($criteria);
		foreach($users as $user)
			$arr[]=$user->id;
	    return $arr; // ? $arr : false;
	}
	
}
