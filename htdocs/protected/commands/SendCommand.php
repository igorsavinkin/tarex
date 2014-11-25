<?php
class SendCommand extends CConsoleCommand
{
    public function actionIndex($type=5, $limit=5) 
	{ 
		$priceLists =array(1,2,3); 
		$priceLists = PriceListSetting::model()->findAll();
		$count=0;
		foreach($priceLists as $pl)
		{
			//mail('igor.savinkin@gmail.com', 'check command', 'check is ok, priceLists number is ' . count );
			$count++;
		}
		mail('igor.savinkin@gmail.com', 'check command', 'check is ok, type is ' . $type);
	} 
}