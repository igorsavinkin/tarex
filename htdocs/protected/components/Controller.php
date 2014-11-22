<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	public $menu=array();
	
	public $pagesize;
	
	public $breadcrumbs=array();  
	 
	public function FConvertDate($date){			
		$Year=substr($date,0,4);
		$Mn=substr($date,5,2);
		$Day=substr($date,8,2);		   
		return Yii::app()->language == 'en_us' ? $Year.'-'.$Mn.'-'.$Day  :  $Day.'.'.$Mn.'.'.$Year;    
	}
// свойство ($_isMobile), regex и функция для определения мобильное ли это устройсво или нет.
	private $_isMobile;

	const RE_MOBILE='/(nokia|iphone|android|motorola|^mot\-|softbank|foma|docomo|kddi|up\.browser|up\.link|htc|dopod|blazer|netfront|helio|hosin|huawei|novarra|CoolPad|webos|techfaith|palmsource|blackberry|alcatel|amoi|ktouch|nexian|samsung|^sam\-|s[cg]h|^lge|ericsson|philips|sagem|wellcom|bunjalloo|maui|symbian|smartphone|midp|wap|phone|windows ce|iemobile|^spice|^bird|^zte\-|longcos|pantech|gionee|^sie\-|portalmmm|jig\s browser|hiptop|^ucweb|^benq|haier|^lct|opera\s*mobi|opera\*mini|320x320|240x320|176x220)/i';

	public function getIsMobile()
	{
		if ($this->_isMobile===null)
			$this->_isMobile=isset($_SERVER['HTTP_X_WAP_PROFILE']) || isset($_SERVER['HTTP_PROFILE']) ||
				preg_match(self::RE_MOBILE, $_SERVER['HTTP_USER_AGENT']);
		return $this->_isMobile;
	}
	
	private $_pageTitle;
	public function getPageTitle()
	{
        if($this->_pageTitle!==null) {
                return Yii::t('general', $this->_pageTitle);
        } else {
                $controller = Yii::t('general', ucfirst(basename($this->getId())));
                
                if($this->getAction()!==null && strcasecmp($this->getAction()->getId(),$this->defaultAction)) {
                        $action = Yii::t('general', ucfirst($this->getAction()->getId()));
                        return $this->_pageTitle=Yii::app()->name.' - '.Yii::t('general', '{action} {controller}', array('{action}' => $action, '{controller}' => $controller));
                } else {
                        return $this->_pageTitle=Yii::app()->name.' - '.$controller;
                }
		}
	}
	
	function init()
    {
        parent::init();   
		Yii::app()->clientScript->registerMetaTag("Автозапчасти для иномарок оптом по выгодным ценам, доставка в регионы - Тарекс тел. +7 (495) 785-88-50", 'description');
		Yii::app()->clientScript->registerMetaTag('запчасти, опт, spare parts, wholesales, Russia, Россия', 'keywords');
		// page size for the gridview
        try {
			if (Yii::app()->user->isGuest) $this->pagesize = Yii::app()->params['defaultPageSize'];
		}  catch(Exception $e)  { } //echo '$_GET[pageSize] = ' ,  $_GET['pageSize'];	
        if (isset($_GET['pageSize'])) {  
				$this->pagesize = $_GET['pageSize']; // echo 'pagesize = ' , $pagesize;
            if (!Yii::app()->user->isGuest) Yii::app()->user->setState('pageSize', (int) $_GET['pageSize']);
            unset($_GET['pageSize']); 
        }	 	
// если это номенклатура с фильтром, тогда мы ставим максимальное число позиций на странице		
		if ('assortment'==Yii::app()->controller->id && (isset($_GET['Series']) OR isset($_GET['Body'])) ) {	
			//echo 'max page size<br>';
			$this->pagesize =  Yii::app()->params['maxPageSize']; 
 		}
		
		if (Yii::app()->user->isGuest) 
			$this->layout='//layouts/index_new'; 
		else 
			$this->layout='//layouts/page3'; 

		if ($this->getIsMobile()) {
			//echo '<br>Mobile device<br />'; // it works
			$this->layout='//layouts/mobile1';
		} 
		
        $app = Yii::app();
        if (isset($_POST['_lang']))
        {
            $app->language = $_POST['_lang'];
            $app->session['_lang'] = $app->language;
        }
        else if (isset($app->session['_lang'])) //en_us
        {
            $app->language = $app->session['_lang'];
        }
		//echo 'GET = '; print_r($_GET);echo '<br>';
		if (isset($_GET['Subsystem']))
			$app->session['Subsystem'] = $_GET['Subsystem'];  
        //$app->params['Subsystem'] = $_GET['Subsystem'];
		// echo '$Subsystem in Controller =',  $app->session['Subsystem'], '<br>';
       
		
		if (isset($_GET['Reference'])) 
           // $app->params['Reference'] = $_GET['Reference'];
            $app->session['Reference'] = $app->params['Reference'];
   
      /*  else if (isset($app->session['Reference']))
        {
             $app->params['Reference']  = $app->session['Reference'];
        }*/
// очищаем переменные сессии (Subsystem & Reference) если переход на главную страницу
		if ('site/index' == Yii::app()->controller->id.'/'.Yii::app()->controller->action->id ) 
		{
			$app->session['Subsystem'] = '';
			$app->session['Reference'] = '';  
		}
		// смена города
		/*
		  1) У пользователя смотрим city - если заполнен значит по умолчанию это его город
		  2) Если не заполнен - определяем
		  3) Определили = записали пользователю
		  4) Поменял = записали пользователю
		  User->city
		*/ 
	  	if (isset($_POST['Cityes']['Name'])) 
			{ // меняем город 
				Yii::app()->user->setState('city', $_POST['Cityes']['Name']);
				if (Yii::app()->user->id) 
				{
					$user = User::model()->findByPk(Yii::app()->user->id);
					$user->city = $_POST['Cityes']['Name'];
					$user->save(false);	//	echo 'city saved in db';
				}
			}		 
		//echo '<b>my city : ', Yii::app()->user->city, '</b>';
	}
	
	public function saveInSearchTerm($input, $price=null, $relatedClientId=null)
	{
		$criteria = new CDbCriteria;
		$criteria->condition = 'name = :value'; 
		$criteria->params = array(':value' => $input);				
		$criteria->limit = 1;				
		$searchTerm = SearchTerm::model()->find($criteria);
    		
		if (isset($searchTerm)) { 
			$searchTerm->frequency++ ; // we only increment "frequency"
		} else {
			$searchTerm = new SearchTerm;
			$searchTerm->name = $input;
			$searchTerm->marketPrice = $price;
			$searchTerm->relatedClientId = $relatedClientId;
			$searchTerm->frequency = 1;
			$searchTerm->firstOccurance = date('Y-m-d');
		}
		$searchTerm->save();	
	}
}
