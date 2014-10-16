<?php  
class EventStatusController extends Controller {

	public function accessRules()
	{
		return array( 
			array('allow', 
				'actions'=>array('update','admin','index','create','delete', 'ipsearch', 'curlip'),
				'roles'=>array(1),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public $layout = '//layouts/FrontendLayoutPavel';
	public function loadModel($id)
	{
		$model=EventStatus::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actioncurlip()
	{
		$ip = '213.87.131.124';
		$ch = curl_init("http://ipinfo.io/" . $ip); 
		
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER , 1);
		$page = curl_exec($ch); 
		
		curl_close($ch); 
		echo 'page = ', $page;
		echo '<br>city = ', json_decode($page)['city'];
	}
	
	public function actionIpsearch()
	{
		$ip = '213.87.131.124';
	//	$ip = ($ip) ? $ip : $_SERVER['REMOTE_ADDR'];
		
		echo '<h2>Ip Search</h2>' , $ip;
		libxml_use_internal_errors(true); 
		
//		$data = file_get_contents("http://api.hostip.info?ip=". $_SERVER['REMOTE_ADDR']);
//		echo '<br> server ip =' , $_SERVER['REMOTE_ADDR']  , '<br> result = ', $data;$data = 
		
	/*	$data = file_get_contents("http://ipgeobase.ru:7020/geo?ip=". $ip);
		echo '<br> my ip (geobase) =' , $ip  , '<br> result = ', $data;
	*/	
	//	$data = file_get_contents("http://api.hostip.info/city.php?ip=12.215.42.19");
		//echo '<br>city = ', $data;
		
	//	$xml = @simplexml_load_file('http://ipgeobase.ru:7020/geo?ip='.$ip);
//		$xml = @simplexml_load_file('http://api.hostip.info/?ip='.$ip);
//		echo '<br>xml = ', $xml;
		 
	/*	if ($xml)
		{
			if($xml->ip->city)
				return iconv( "UTF-8", 'UTF-8', $xml->ip->city);
		}*/
		
 	} 	
	
	public function actionAdmin()
	{
		$model=new EventStatus('search'); //!!! Только здесь меняем 
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EventStatus']))
			$model->attributes=$_GET['EventStatus'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 	
	
	public function actionIndex()
	{
		$model=new EventStatus('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EventStatus']))
			$model->attributes=$_GET['EventStatus'];

		$this->render('admin',array(
			'model'=>$model,
		));
	} 
	
	public function actionUpdate($id)
	{	
		if( $id == 'new' ) 
			$model = new EventStatus;     		
        else  
			$model = EventStatus::model()->findByPk($id);			

		if(isset($_POST['EventStatus'])) { 
			$model->attributes=$_POST['EventStatus'];  
		 	if($model->save()) 
				$this->redirect(array('admin'));
		} 

		$this->render('update' ,array(
			'model'=>$model 
		));
	} 
	
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete(); 
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}	
}