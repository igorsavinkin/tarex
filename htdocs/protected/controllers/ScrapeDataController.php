<?php

class ScrapeDataController extends Controller
{ 
	public $layout='//layouts/column2';
	public $base_url  =  'http://auto.ru';
	public $base_url_spb  =  'http://spb.auto.ru';	
	public $phone_url = 'http://auto.ru/cars/used/sale/get_phones/';
	public $patternAudi = '~/cars/audi/[^/]+?/all/~'; 
	public $patternUsed = '~http://auto.ru/cars/used/sale/[^/]+?/~'; 
 
    public $audiItems=array(  '/cars/audi/100/all/', '/cars/audi/200/all/', '/cars/audi/80/all/', '/cars/audi/90/all/', '/cars/audi/a1/all/', '/cars/audi/a2/all/', '/cars/audi/a3/all/', '/cars/audi/a4-allroad/all/', '/cars/audi/a4/all/', '/cars/audi/a5/all/', '/cars/audi/a6-allroad/all/', '/cars/audi/a6/all/', '/cars/audi/a7/all/', '/cars/audi/a8/all/', '/cars/audi/cabriolet/all/', '/cars/audi/coupe/all/', '/cars/audi/q3/all/', '/cars/audi/q5/all/', '/cars/audi/q7/all/', '/cars/audi/quattro/all/',  '/cars/audi/r8/all/', '/cars/audi/rs-q3/all/', '/cars/audi/rs3/all/', '/cars/audi/rs4/all/', '/cars/audi/rs5/all/', '/cars/audi/rs6/all/', '/cars/audi/rs7/all/', '/cars/audi/s2/all/', '/cars/audi/s3/all/', '/cars/audi/s4/all/', '/cars/audi/s5/all/', '/cars/audi/s6/all/', '/cars/audi/s7/all/', '/cars/audi/s8/all/', '/cars/audi/tt/all/', '/cars/audi/tt-rs/all/', '/cars/audi/tts/all/', '/cars/audi/v8/all/');
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}
 
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view' ,'test' , 'add', 'scrape', 'scrapelinks'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create' ,'update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin', 'delete'),
				'roles'=>array(1),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
 
	public function actionTest()
	{	
	  //  $this->insert('http://auto.ru/cars/used/sale/1005842487-cdc807/');
	  //  $this->insert('http://special.auto.ru/crane/used/sale/386328-02aa2.html');
	}
	public function actionScrape($url=null)
	{
		//echo 'cookie file = ', $this->get_cookie_file(), '<br>';
		$url = $url ? $url : $this->base_url_spb . '/cars/audi/a4/all/';  // 'http://spb.auto.ru/cars/audi/all';
		echo 'request url = ', $url, '<br>';
		$header = $this->get_web_page($url);
		echo 'header:<br>';
		print_r($header);    
	}
	public function actionScrapelinks( $limit=2, $offset=0, $model=null)
	{
		//$url = $this->base_url_spb . ScrapeData::model()->find()->link;
	// получим все ссылки на audi по моделям
	    $criteria= new CDbCriteria;
		$criteria->condition='t.link=t.marker';
		if ($model) 
		    $criteria->addCondition( 't.model="' . $model .'" ');
		$criteria->select=array('link');
		$criteria->limit = $limit;
		$criteria->offset = $offset;
		
		$audiLinks = ScrapeData::model()->findAll($criteria);
		$i=1;
		// minimum delay between two executions
		$mindelay=1000000;
		// maxium delay between two executions
		$maxdelay=2000000;
		$xpath_query='//a[@class="sales-link"]/@href'; 
		foreach($audiLinks as $modellink)
		{
   		     $link = $this->base_url_spb . $modellink->link;
			 echo $i, '. ', $link,' --- ',   date('h:i:s') ,'<br>';
			 $header = $this->get_web_page($link); 
	      	 print_r($header['headers']);
		 // получаем ссылки на этой странице по xpath
			 $links = $this->get_links_by_xpath($header['content'], $xpath_query);
             foreach($links as $link)
    		     $this->insert($link);	
			  //print_r($links);
			 echo '<hr>';
			 $i++;	
			 usleep(rand($mindelay,$maxdelay)); 	 // delay in microseconds
		}
		
		/* GET параметры для дополнительной фильтрации
		
			search[mark][0]:15 // код марки
			search[mark-folder][]:15-31569 // код марки и папки
			search[state]:1 // страна
			search[custom]:2 // растаможен ли
			search[geo_country]:1  // страна
			search[geo_region]:89, 89,32 // регион
		*/ 
	 
	}
	
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}
	public function actionAdd()
	{ 
		 foreach($this->audiItems as $item)
		 {
		      if(ScrapeData::model()->findByAttributes(array('marker'=>$item))) 
			      continue;
			  $model=new ScrapeData;
			  $model->link= $item;
			  $model->marker= $item;
			  $model->model= 'audi';
			  $model->save(false);
		 }
	}
	 
	public function actionCreate()
	{
		$model=new ScrapeData;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ScrapeData']))
		{
			$model->attributes=$_POST['ScrapeData'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
  
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['ScrapeData']))
		{
			$model->attributes=$_POST['ScrapeData'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
 
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
 
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('ScrapeData');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
 
	public function actionAdmin()
	{
		$model=new ScrapeData('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ScrapeData']))
			$model->attributes=$_GET['ScrapeData'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
/*********************** FUNCTIONS ************************/
	public function loadModel($id)
	{
		$model=ScrapeData::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
 
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='scrape-data-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	protected function get_cookie_file( $url='', $cookiesIn = '' )
	{
	      return dirname(__FILE__).'/cookie.txt';	
	}
	protected function get_web_page( $url, $cookiesIn = '' )
	{
        $options = array(
            CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,     //return headers in addition to content
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_SSL_VERIFYPEER => false,     // Disabled SSL Cert checks
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
         //   CURLOPT_COOKIE         => $cookiesIn
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
		
		// дополнительно для сохранения cookie 
		$tmpfname = dirname(__FILE__).'/cookie.txt';
		curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfname);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfname);
        $rough_content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch ); 
        curl_close( $ch );
 
        $header_content = substr($rough_content, 0, $header['header_size']);
        $body_content = trim(str_replace($header_content, '', $rough_content));
        $pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m"; // m stands for multyline, http://php.net/manual/en/reference.pcre.pattern.modifiers.php
		
        preg_match_all($pattern, $header_content, $matches); 
        $cookiesOut = implode("; ", $matches['cookie']);

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['headers']  = $header_content;
        $header['content'] = $body_content;
        $header['cookies'] = $cookiesOut;
		return $header;
	}
	function get_web_page_post( $url, $postParams=NULL)
	{
        $options = array(
		// the 2 lines pertaining to POST request
            CURLOPT_POSTFIELDS => $postParams ? http_build_query($postParams) : '',
       	    CURLOPT_POST => true, 
			
		    CURLOPT_RETURNTRANSFER => true,     // return web page
            CURLOPT_HEADER         => true,     //return headers in addition to content
            CURLOPT_FOLLOWLOCATION => true,     // follow redirects
            CURLOPT_ENCODING       => "",       // handle all encodings
            CURLOPT_AUTOREFERER    => true,     // set referer on redirect
            CURLOPT_CONNECTTIMEOUT => 120,      // timeout on connect
            CURLOPT_TIMEOUT        => 120,      // timeout on response
            CURLOPT_MAXREDIRS      => 10,       // stop after 10 redirects
            CURLINFO_HEADER_OUT    => true,
            CURLOPT_SSL_VERIFYPEER => false,     // Disabled SSL Cert checks
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
         //   CURLOPT_COOKIE         => $cookiesIn
        );

        $ch      = curl_init( $url );
        curl_setopt_array( $ch, $options );
		
		// дополнительно для сохранения cookie 
		$tmpfname = dirname(__FILE__).'/cookie.txt';
		curl_setopt($ch, CURLOPT_COOKIEJAR, $tmpfname);
		curl_setopt($ch, CURLOPT_COOKIEFILE, $tmpfname);
        $rough_content = curl_exec( $ch );
        $err     = curl_errno( $ch );
        $errmsg  = curl_error( $ch );
        $header  = curl_getinfo( $ch ); 
        curl_close( $ch );
 
        $header_content = substr($rough_content, 0, $header['header_size']);
        $body_content = trim(str_replace($header_content, '', $rough_content));
        $pattern = "#Set-Cookie:\\s+(?<cookie>[^=]+=[^;]+)#m"; 
        preg_match_all($pattern, $header_content, $matches); 
        $cookiesOut = implode("; ", $matches['cookie']);

        $header['errno']   = $err;
        $header['errmsg']  = $errmsg;
        $header['headers']  = $header_content;
        $header['content'] = $body_content;
        $header['cookies'] = $cookiesOut;
		return $header;
	}
	protected function get_links_by_xpath($html=null, $xpath_query='//a[@class="sales-link"]/@href')
	{
	     if($html)
		 {
			$html = str_replace('&nbsp;', ' ', $html);
			$html = str_replace('<br/>', ' ', $html);  
			$html = str_replace('<noindex>', '', $html);  
			$html = str_replace('</noindex>', '', $html);
			$html = str_replace('noindex', '', $html);
			//echo $html;
		// we suppress libxml internal errors 
			libxml_use_internal_errors(true);
		// Getting the text into the DOM Document for further parse 
			$DOM = new DOMDocument('1.0', 'UTF-8');
			$DOM->loadHTML('<meta http-equiv="Content-Type" content="text/html;charset=UTF-8" />' . $html);
				
		// Initiating DOM XPath Document for parse 
			$xpath = new DOMXPath($DOM);
			$xpath->registerNamespace("php", "http://php.net/xpath");
			$xpath->registerPHPFunctions(); 

	        $links = $xpath->query($xpath_query); 
			$i=0; 
			$arr=array();
			while($links->item($i)->nodeValue)
			{
                 echo $links->item($i)->nodeValue, "<br>";
				 $arr[]=$links->item($i)->nodeValue;
				// $this->insert($links->item($i)->nodeValue);		
			     $i++;
			} 
     		return $arr;
		 } 	
		 else 
		    return false;  		
	}
	protected function insert($item)
	{ 		 
	      if(ScrapeData::model()->findByAttributes(array('link'=>$item))) 
			  return;
		  $model=new ScrapeData;
		  $model->link = $item; 
		  preg_match('#\d+-[^\/]+#', $item, $matches); //echo '<br>marker = ' ,  $matches[0];		  
		  $model->marker = $matches[0];		
		/*  $res = $this->get_web_page($this->phone_url . $model->marker . '/')
		  $res=json_decode($res);
		  */
		  $model->created = date('Y-m-d');
		  return $model->save(false);
	}
}