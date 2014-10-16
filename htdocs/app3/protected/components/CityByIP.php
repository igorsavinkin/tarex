<?php
class CityByIP extends CWidget
{
    public function run()
    {
		$ipus = getenv('REMOTE_ADDR');
		
//Выбор города  
		$cities = new Cityes; 
		
		$City = $this->Foccurrence($ipus,'utf-8');
		$City1 = Cityes::model()->findbyattributes(array('Name'=>$City));
		if (!empty($City1))	
		{  
			$cities->Name = $City1->Name; 	//echo 'Name'.$cities->Name;
		}
		if (!Yii::app()->user->isGuest && !empty(Yii::app()->user->city)) // если пользователь залогинен и у него есть город, то берём город из его данных 
			$cities->Name = Yii::app()->user->city;  
			
		echo CHtml::Form();  	 ?>
		
		    <p class="simply"></p>
			<p class="tar_border"></p>
			<p class="tar_location"></p>
		<?	$this->widget('ext.select2.ESelect2',array(
				'model'=> $cities,
				'attribute'=> 'Name', 
			
				'data'=>CHtml::listData(Cityes::model()->findAll(array('order'=>'Name ASC')), 'Name','Name'),
				'options'=> array( 
					'allowClear'=>false,
					'width' => '200', 
				),     
				'htmlOptions'=>array('class'=>'ch_city'),
			));
			echo '&nbsp;&nbsp;<br><center>';
			//echo CHtml::submitButton(Yii::t('general','Change city'), '', array('class'=>'red')), '</center>';
		echo CHtml::endForm();  
	}
//==== ФУНКЦИЯ ОПРЕДЕЛЕНИЕ ГОРОДА ПО IP  ======
	function Foccurrence($ip='', $to = 'windows-1251')
	{ 
		$ip = ($ip) ? $ip : $_SERVER['REMOTE_ADDR'] ; 
		try {
			$xml =  simplexml_load_file('http://ipgeobase.ru:7020/geo?ip='.$ip); //213.87.131.124 
		}  
		catch (Exception $e) {
			//echo 'Поймано исключение: ',  $e->getMessage(), "\n"; 
			return 'Москва';
		}
		if($xml->ip->city)
		{
			return iconv( "UTF-8", 'UTF-8', $xml->ip->city);
		} 			
	}
//==== КОНЕЦ ФУНКЦИИ ОПРЕДЕЛЕНИЕ ГОРОДА ПО IP  ======
}
?>