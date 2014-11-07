<?php class SitemapController extends Controller
{
    public function actionIndex()
    {
	echo 'sitemap';
	   $urls = array();
   
        // Новости
        $news = News::model()->findAll();
        foreach ($news as $new){
            $urls[] = $this->createUrl('news/view', array('id'=>$new->id));
        } 
 
        //  
        $products = Assortment::model()->findAll();
        foreach ($products as $product){
            $urls[] = $this->createUrl('assortment/view', array('id'=>$product->id));
        }
 
        // ...
 
        $host = Yii::app()->request->hostInfo;
 
        echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
        echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        foreach ($urls as $url){
            echo '<url>
                <loc>' . $host . $url . '</loc>
                <changefreq>daily</changefreq>
                <priority>0.5</priority>
            </url>';
        }
        echo '</urlset>';   
        Yii::app()->end();            
    }
}
?>