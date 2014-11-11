<?

class LangController extends Controller
{


	public function actionIndex()
	{
		$otvet=$_GET['str'];
		if (!empty($otvet)){
			$otvet = Yii::t('general', $otvet);
			//echo 'otvet '.$otvet;
		}
		echo $otvet;		
	} 
	
	public function actionDict()
	{
		 //include('../messages/ru/general.php');
		//$this->findLocalizedFile('../messages/en/general.php', 'en', 'ru'); 	
		//$source=YiiBase::$_app->getComponent('../messages/en/general.php');
		//$source=Yii::app()->getComponent('../messages/en/general.php');
		//print_r($source);
		print_r(Yii::t_all('general','no'));
		//eval(Yii::t_all('general','no'));
		echo '<br>';
		//CPhpMessageSource::getMessageFile('general', 'ru');
	//	var_dump($source);
		
	} 
	
	public function findLocalizedFile($srcFile,$srcLanguage=null,$language=null)
	  {
		if($srcLanguage===null)
		  $srcLanguage=$this->sourceLanguage;
		if($language===null)
		  $language=$this->getLanguage();
		if($language===$srcLanguage)
		  return $srcFile;
		$desiredFile=dirname($srcFile).DIRECTORY_SEPARATOR.$language.DIRECTORY_SEPARATOR.basename($srcFile);
		return is_file($desiredFile) ? print_r($desiredFile) : print_r($srcFile);
	  } 
	


	
	
}

