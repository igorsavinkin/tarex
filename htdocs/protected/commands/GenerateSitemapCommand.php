<?php
class GenerateSitemapCommand extends CConsoleCommand
{
    public function actionIndex()
	{	 	 	
	/*  марка, марка + модель (cогласно фильтрам-чекбоксам) - не самое главное, 
	    марка + подгруппа (кузов и т. п.) , марка + модель + подгруппа
        пустые убирать из sitemap 
	*/		
		$count=0;
		$file = fopen(Yii::app()->basePath . '/../sitemap.xml', 'w'); 
		fwrite($file, '<?xml version="1.0" encoding="UTF-8"?>
		<urlset
        xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
        xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9
                http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">');
//Особые страницы выводим  
		foreach(array('company', 'contacts', 'products', 'spareparts') as $page) :  		
			fwrite($file, "<url>
				<loc>" .  Yii::app()->createUrl('/site/index', array('page'=>$page  )) . "</loc>
				<changefreq>monthly</changefreq>
				<priority>0.5</priority>
			</url>");	
			$count++;	
		endforeach;
		//echo Yii::app()->createUrl('/site/index', array('page'=>$page  )), '<br>'; 
	//	fwrite($file, "<!-------------------------------------------->");
//Марка - выводим страницы с марками машин 
		$criteria = new CDbCriteria;
		$criteria->compare('depth', 2); 		
		$criteria->select = 'id, title';			
		$makes = Assortment::model()->findAll($criteria);
		foreach($makes as $make) :  
			//echo 'make = ', $make->title, '; id = ', $make->id  , '<br>';
			$conditionMake =   'make = "' .  $make->title . '" ';
		    if (Assortment::model()->count($conditionMake . ' AND measure_unit <>"" ')) 
			{
				$item= "<url>
					<loc>" .  Yii::app()->createUrl('/assortment/index', array('id'=>$make->id))  . "</loc>
					<changefreq>monthly</changefreq>
					<priority>0.5</priority>
				</url>";					
				fwrite($file, $item);
				$count++;	
			}
	// Марка + подгруппа (кузов, оптика и т. п.) 		
	//		fwrite($file, "<!-------------------------------------------->");
			foreach(Category::model()->findAll() as $category)
			{		
	// Проверим, если она пустая, тогда не включаем 
			   $condition = $conditionMake . ' AND groupCategory = ' . $category->id;
			  // echo 'condition: ',  $condition, '<br>';
			   $numberOfItems = Assortment::model()->count($condition);
			   if ($numberOfItems) 
			   {     
					//echo 'the items are ', $numberOfItems, '<br>';	 
					fwrite($file, "<url><loc>" .  Yii::app()->createUrl('/assortment') . '/' . $category->id. '/' . $make->id . "</loc>
					<changefreq>monthly</changefreq>
					<priority>0.5</priority>
					</url>");  
					$count++;	
				}
				
			}
		endforeach;   
	//	fwrite($file, "<!-------------------------------------------->");
		fwrite($file,'</urlset>');
		fclose($file);	
	//	echo 'file is written: ', CHtml::Link('sitemap.xml',  '/sitemap.xml',  array('target'=>'_blank'));
	//	echo '<br>total: ', $count , ' urls'; 
		mail( Yii::app()->params['adminEmail'], 'Writing sitemap.xml thru command at '. date('H:i:s'), 'Writing is ok, "GenerateSitemap" command & action "index"  <br> File ' . CHtml::Link('sitemap.xml', 'http://tarex.ru/sitemap.xml',  array('target'=>'_blank')) . '<br> Total composed '. $count . ' urls', 'Content-type: text/html');	// check mail - 
	}  
	  
}