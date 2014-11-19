<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <title>
      <?php echo $this->pageTitle; ?>
    </title> 
  <link href="<?php echo Yii::app()->baseUrl; ?>/css/in.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/form.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/reset.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/order.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/media.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-theme.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/owl.theme.css" rel="stylesheet" type="text/css">
	
    <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jQuery'); ?>
	<script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/owl.carousel.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->baseUrl; ?>/js/tabSlideOut.js"></script>
	
	<script type="text/javascript">
	jQuery(function($) {   
		// скрипт для  автоматической отсылки формы с языком 
		jQuery('body').on('change','#_lang',function(){jQuery.yii.submitForm(this,'',{});return false;});		
	   // скрипт для  автоматической отсылки формы с городом 
	   jQuery('body').on('change','#Cityes_Name',function(){jQuery.yii.submitForm(this,'',{});return false;});
	   // emulate click
	  
	}); //  document.getElementByClassName('tar_badge_vis').click();
	
	
	</script>
</head>
	
<body>  
<div class="tar_wrapper">
    <div class="in_wrapper">
        <div class="tar_header">
            <div class="tar_top_head">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tar_left_top_head">
                                <div class="tar_top_logo">
                                    <a href="<?php echo Yii::app()->createUrl('/site/index'); ?>">
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_top_logo.png"  alt=""/>
                                    </a>
                                </div>
                                <div class="tar_ad_phone">
                                    <div class="tar_ad">
                                        Россия г. Москва,<br>
                                        ул. Складочная д. 1, стр. 10
                                    </div>
                                    <div class="tar_phone">
                                        <span class="s_one">+7 (495) </span><span class="s_two">785-88-50 </span><span class="tar_red_span">(многоканальный)<a href="mailto:auto@tarex.ru">auto@tarex.ru</a></span>
                                    </div>
                                </div>
                            </div>
                            <div class="tar_choice_all">
                                <div class="tar_choice_city">
									<?php $this->widget('CityByIP'); ?> 
                                </div>
                                <div class="tar_change_city" >
                                    <?php echo Yii::t('general','Change city'); ?>
                                </div>
                                <div class="pad"></div>
                            </div><!-- tar_choice_all -->
                            <div class="tar_reg_in_lang">
                                <div class="tar_reg">
                                    <a href="<?php echo Yii::app()->createUrl('/user/register'); ?>">
                                        <?php echo Yii::t('general', 'Register'); ?></a>
                                </div>
                                <div class="tar_in">
                                    <a href="<?php echo Yii::app()->createUrl('/site/login'); ?>">
                                        <?php echo Yii::t('general','Sign in'); ?>  
                                    </a>
                                </div>
								<?php  $this->widget('LangBox'); ?>
                          </div>
                    </div>
                </div>
            </div>
            <div class="tar_bottom_head">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tar_search">
                                <?php echo CHtml::form(array('assortment/index'), 'get'); 
                                   $value =  isset($_GET['findbyoem-value']) ? $_GET['findbyoem-value'] : '';
									$value =  ($value=='' && isset($_GET['findbyoemvalue']) ) ? $_GET['findbyoemvalue'] : '';
									echo CHtml::textField('findbyoem-value', $value, array('placeholder'=> Yii::t('general', 'OEM, Article or part name') )); ?>
                                    <input type="submit" class="form_submit" value="<?php echo Yii::t('general' , 'Search'); ?>" >
                                 <?php echo CHtml::endForm(); ?>
                            </div>	

							<div class="tar_basket">
                                <a class="tar_bas" href="<?php echo Yii::app()->createUrl('assortment/cart');?>" >
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_basket.png" alt="" />
									<span id='cart-content'><?php $cartContent =  Yii::t('general', 'BASKET') . '<br />' . Yii::app()->shoppingCart->getItemsCount() .' ' . Yii::t('general', 'item(s)');
									$cost = Yii::t('general', 'for') . ' ' . Yii::app()->shoppingCart->getCost() . ' '.  Yii::t('general','RUB'); 
									echo $cartContent , '<br>', $cost; ?>
									</span> 
                                </a>
                            </div>							
                   <!-- кнопки поиска по VIN и в огромном общем каталоге -->
                            <div class="tar_red_buttons">
                                <div class="tar_vip">
                                    <a id='opendialog' href="#">
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_vip.png" alt="" />
                                    </a>
                                </div>
                                <div class="tar_catalog">
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_catalog.png" alt="" />
                                    </a>
                                </div>
                                <div class="pad"></div>
                            </div>
                            
                            <div class="pad"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tar_body">
            <div class="tar_slider">
                <div id="owl-demo" class="owl-carousel owl-theme"> 
                    
					<?php
					$criteria= new CDbCriteria;
					$criteria->condition = 'isActive = 1 AND blockId LIKE "Slider%" ';
					
					foreach(Advertisement::model()->findAll($criteria) as $item)
					{ ?>	
				    <div class="item">
						<?php echo $item->content; ?>
					</div>
					<?php 
					} // end foreach 
					?>
                    <!--div class="item">
						<img src="images/tar_slide.jpg">
					</div-->

                </div>
            </div>
            <div class="tar_cont">
                <div class="container tar_container"> 
					<div class="row">	
						<?php $flashMessages = Yii::app()->user->getFlashes(); 
							if ($flashMessages) { 
								echo '<ul class="flashes">';
								foreach($flashMessages as $key => $message) {
									echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
								}
								echo '</ul>';
							}?>
				   </div><!-- row -->
                   <div class="row<?php echo ('assortment' != Yii::app()->controller->id) ? ' hidden' : ''; ?>">	
						<?php $this->renderPartial('//layouts/_carmakes'); ?>
				   </div>
				   <div class="row">	 				
						<div class="col-md-12">
                            <div class="tar_category_vis tar_panel tar_open">
                                <div class="tar_badge_vis">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_category.png" alt="" />
                                </div>
                                <div class="tar_cat_invis">
								<?php 
											$categories = Category::model()->findAll('isActive = 1'); 
											$i=1;
											foreach($categories as $category)
											{
												if (!Assortment::model()->count('groupCategory = '. $category->id)) continue;	
											?>															
												 <a class="tar_cat<?php if(($i++ % 2) == 1) echo ' tar_cat_first'; ?>" href="<?php echo $this->createUrl('assortment/index', array('Assortment[groupCategory]'=>$category->id)); ?>">
												 <img src="<?php echo Yii::app()->baseUrl .'/images/subgroups/' .  $category->image; ?>" alt="" />
													<span>
														<?php echo str_replace(' ', '<br>', Yii::t('general', $category->name)); ?>
													</span>
												</a><?php 		 
											} 	 									
											?>
                                    <div class="pad"></div>
                                </div><!-- tar_cat_invis -->
                                <div class="pad"></div>
                            </div> 
                            <div class="tar_category">
                                <div class="tar_badge">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_category.png" alt="" />
                                </div> 
                                <div class="pad"></div>
                            </div>
                            <div class="tar_adv">
                                <?php 
								if (Yii::app()->controller->id == 'site') 
								{
									$criteria= new CDbCriteria;
									$criteria->condition = 'isActive = 1 AND blockId LIKE "Right%" ';	
									$criteria->order='id ASC';	
									$numItems = Advertisement::model()->count($criteria);	
									$i=0;	
									foreach(Advertisement::model()->findAll($criteria) as $item)
									{  	
										if(++$i != $numItems) echo '<div class="tar_ad_1">';
										echo $item->content;
										if($i != $numItems) echo '</div>'; 										
									} // end foreach 
									/*
									echo '<div class="tar_ad_1">',  Advertisement::model()->findByAttributes(array('id'=>1, 'isActive'=>1))->content , '</div>'; 
									echo '<div class="tar_ad_1">', Advertisement::model()->findByAttributes(array('id'=>2, 'isActive'=>1))->content, '</div>';   
									echo Advertisement::model()->findByAttributes(array('id'=>3, 'isActive'=>1))->content; */
								}						
								?> 
								<!--a class="tar_ad_1 ( .tar_ad_1 { margin-bottom: 18px;})" href="#">
                                    <img class="advis_1" src="images/tar_ad_1.jpg">
                                </a--> 
							</div>
							<div class="tar_catalog_goods">
								<!--div style='height:auto;margin-left:30px;padding-left:30px;'-->
							
								<?php // содержимое из cоответствующего view 
									 echo $content; 
								?>
							
								<a href='#' id='btn-up' style=''><img src='images/btn-up.png' width='35px' alt="" /></a>
								<!--/div><!--tar_cat_top_regular-->
								<div class="pad"></div>
							</div><!-- tar_catalog_goods -->
						</div> <!-- col-md-12 -->
							
 <!-------------------------- вот разделительная линия ---------->
						<div class="col-md-12">
                            <div class="tar_best_sellers">
                                <div class="tar_best_title">
                                <!--  Лидеры продаж-->
								  <?php echo Yii::t('general','Special Offers'); 
								  $spOffers = SpecialOffer::model()->first5()->findAll();
								  $i=1;
								  $offerArr=array();
								  foreach($spOffers as $offer)
								  {
										$offerArr[$i++]=array(
											'img'=>!empty($offer->photo) ? $offer->photo : 'tar_no_photo.jpg', 
											'description'=>$offer->description, 
											'price'=>$offer->price ,
											'id'=>$offer->assortmentId);
								  } ?>
                                </div>
                                <div class="tar_sell_cont">
                                    <div class="tar_first_sells">
                                        <div class="tar_first_sell">
                                            <div class="tar_sell_part tar_sell_part_1" >
                                                <!--a class="tar_part" href="#"-->
                                                    <img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[1]['img']; ?>" width='213' height='213' alt="" />
                                                <!--/a-->
                                                <div class="tar_sell_part_name">
                                                    <?php echo $offerArr[1]['description']; ?><!--Название запчасти если оно длинное-->
                                                </div>
                                                <a class="tar_price" href="<?php echo $this->createUrl('assortment/addToCart', array( 'id'=>$offerArr[1]['id'])); ?>">
                                                    <span><?php echo $offerArr[1]['price']; ?></span>руб
                                                </a>
                                            </div>
                                            <div class="tar_two_sells">
                                                <div class="tar_sell_part">
                                                    <!--a class="tar_part" href="#"-->
                                                        <img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[2]['img']; ?>" width='213' height='213' alt="" />
                                                    <!--/a-->
                                                    <div class="tar_sell_part_name">
                                                      <?php echo $offerArr[2]['description']; ?><!--Название запчасти если оно длинное-->
                                                    </div>
                                                   <a class="tar_price" href="<?php echo $this->createUrl('assortment/addToCart', array( 'id'=>$offerArr[2]['id'])); ?>">
														<span><?php echo $offerArr[2]['price']; ?>
                                                       </span>руб
                                                    </a>
                                                </div>
                                                <div class="tar_sell_part">
                                                    <!--a class="tar_part" href="#"-->
                                                        <img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[3]['img']; ?>" width='213' height='213' alt="" />
                                                    <!--/a-->
                                                    <div class="tar_sell_part_name">
                                                      <?php echo $offerArr[3]['description']; ?><!--Название запчасти если оно длинное-->
                                                    </div>
                                                   <a class="tar_price" href="<?php echo $this->createUrl('assortment/addToCart', array( 'id'=>$offerArr[3]['id'])); ?>"> 
														<span><?php echo $offerArr[3]['price']; ?>
                                                        </span>руб
                                                    </a>
                                                </div>
                                                <div class="pad"></div>
                                            </div>
                                            <div class="pad"></div>
                                        </div>
                                    </div>
                                    <div class="tar_two_last_sells">
                                        <div class="tar_last_sell">
                                            <div class="tar_sell_part">
                                                <!--a class="tar_part" href="#"-->
                                                    <img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[4]['img']; ?>" width='213' height='213' alt="" />
                                                <!--/a-->
                                                <div class="tar_sell_part_name">
                                                  <?php echo $offerArr[4]['description']; ?><!--Название запчасти если оно длинное-->
                                                </div>
                                               <a class="tar_price" href="<?php echo $this->createUrl('assortment/addToCart', array( 'id'=>$offerArr[4]['id'])); ?>"> <span><?php echo $offerArr[4]['price']; ?>
                                                     </span>руб
                                                </a>
                                            </div>
                                            <div class="tar_sell_part">
                                                <!--a class="tar_part" href="#"-->
                                                    <img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[5]['img']; ?>" width='213' height='213' alt="" />
                                                <!--/a-->
                                                <div class="tar_sell_part_name">
                                                  <?php echo $offerArr[5]['description']; ?><!--Название запчасти если оно длинное-->
                                                </div>
                                               <a class="tar_price" href="<?php echo $this->createUrl('assortment/addToCart', array( 'id'=>$offerArr[5]['id'])); ?>"> <span><?php echo $offerArr[5]['price']; ?>
                                                     </span>руб
                                                </a>
                                            </div>
                                            <div class="pad"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pad"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tar_news">
                    <div class="tar_best_title">
                       <!--   Авторские новости-->			 
					  <?php echo Yii::t('general','Feed news'); 						 			 
						 $newsFromModel = News::model()->first5()->findAllByAttributes(array('isActive' => 1));
						 $i=0;
						 $newsItem=array();
						 foreach($newsFromModel as $item)
						 {
							if (empty($item->RSSchannel)) 
							{
								$date = new DateTime($item['newsDate']);
								$newsItem[$i]="<a class='tar_new_img' href='{$item['link']}'>
															<img src='images/{$item['imageUrl']}' width='212' height='139' alt=/"/">  
														</a>
														<div class='tar_new_title'>
															<a href='{$item['link']}'>
																{$date->format('d.m.Y H:i')}<br><b>
																{$item['title']}</b></a>
														</div>
								<div class='tar_news_text'>{$item['content']}</div>";
								
							} else 
								$newsItem[$i] = getInfoFromRSS($item->RSSchannel);
							$i++;
						 } 
						 function getInfoFromRSS($url)
						 {
							$rawFeed = file_get_contents($url); 				
							$xml = new SimpleXMLElement($rawFeed);  
							$channel = (array)$xml->channel; 
							$dateTime = new DateTime($channel['item'][0]->pubDate);	
				// надо вырезать все вхождения <img /> и первое из них занести в img для newsItem					 
							preg_match_all('/<img\s*.*?src="(.*?)"/', $channel['item'][0]->description, $matches);  
							$imgSrc= $matches[1][0];  
						   // удаляем все <img ... /> и вырезаем для показа первые 1000 символов. Добавляем в конце "> чтобы закрыть открытый тег в случае чего
							$description = substr( preg_replace('/<img.*?\/\>/', '', $channel['item'][0]->description), 0, 1000) . '">...'; 							
							$newsItem = !empty($imgSrc) ? "<a class='tar_new_img' href='{$channel['item'][0]->link}'>
														<img src='{$imgSrc}' width='212' height='139' alt=/"/">  
													</a>" : ""; 					
							$newsItem .= "<div class='tar_new_title'>
														<a href='{$channel['item'][0]->link}'>
															{$dateTime->format('d.m.Y H:i')}<br><b>
															{$channel['item'][0]->title}</b></a>
													</div>
										<div class='tar_news_text'>{$description}</div>";	
						    return $newsItem;
						 }
				// берём новости из RSS канала если авторских новостей меньше чем 5
						if ($i<5) 
						{
							$news = Advertisement::model()->findByAttributes(array('blockId'=>'RSS Feed'));
							$url= explode(',' , $news->content)[0]; // берём первый адрес из многих разделённый запятыми
							$rawFeed = file_get_contents($url); 
							// give an XML object to be iterate
							$xml = new SimpleXMLElement($rawFeed);  
							$channel = (array)$xml->channel; //print_r($channel['item']);	
							// $i - сохраняется из предыдущего цикла 
							for( ; $i<5;$i++)
							{	  
								$dateTime = new DateTime($channel['item'][$i]->pubDate);
					   // надо вырезать все вхождения <img /> и первое из них занести в img для newsItem					 
								preg_match_all('/<img\s*.*?src="(.*?)"/', $channel['item'][$i]->description, $matches); //echo '<br>';   //var_dump($matches); echo '<br>'; 
								$imgSrc= $matches[1][0]; //echo $link;
						   // удаляем все <img ... /> и вырезаем для показа первые 1000 символов.
								$description = substr( preg_replace('/<img.*?\/\>/', '', $channel['item'][$i]->description), 0, 1000) . '">...'; 

								$newsItem[$i] = !empty($imgSrc) ? "<a class='tar_new_img' href='{$channel['item'][$i]->link}'>
														<img src='{$imgSrc}' width='212' height='139 alt=/"/">  
													</a>" : ""; 					
								$newsItem[$i] .= "<div class='tar_new_title'>
														<a href='{$channel['item'][$i]->link}'>
															{$dateTime->format('d.m.Y H:i')}<br><b>
															{$channel['item'][$i]->title}</b></a>
													</div>
										<div class='tar_news_text'>{$description}</div>";
							} 
						}						  
						?>
                    </div>
                    <div class="tar_news_cont">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tar_first_news">
                                        <div class="tar_first_new">
                                            <div class="tar_news_part tar_news_part_1">
                                            <?php echo $newsItem[0];  /*      <!--a class="tar_new_img" href="#">
                                                    <img src="images/tar_car_1.jpg">
                                                </a-->
                                                <div class="tar_new_title">
                                                  <a href="<?php echo $channel['item'][0]->link; ?>">
														<?php $dateTime = new DateTime($channel['item'][0]->pubDate);  
														echo  $dateTime->format('d.m.Y H:i'); ?><br><b>
														<?php echo $channel['item'][0]->title; ?></b>
													   <!--Пример названия новости если оно длинное-->
                                                    </a>
                                                </div>
                                                <div class="tar_news_text">
													<?php echo $channel['item'][0]->description; ?>
                                                </div>
												*/ ?>
                                            </div>
                                            <div class="tar_two_news">
                                                <div class="tar_news_part">
                                                <?php  echo $newsItem[1];  ?>
                                                </div>
                                                <div class="tar_news_part">
                                                <?php  echo $newsItem[2];  ?>
                                                </div>
                                                <div class="pad"></div>
                                            </div>
                                            <div class="pad"></div>
                                        </div>
                                    </div>
                                    <div class="tar_last_news">
                                        <div class="tar_last_new">
                                            <div class="tar_news_part">
                                              <?php echo $newsItem[3];  ?>
                                            </div>
                                            <div class="tar_news_part">
                                              <?php echo $newsItem[4];  ?>
                                            </div>
                                            <div class="pad"></div>
                                        </div>
                                    </div>
                                    <div class="pad"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tar_bot_ad">
                    <div class="container">
						<?php 
							$criteria = new CDbCriteria;
							$criteria->condition = "blockId LIKE 'Bottom%' AND isActive = 1 ";
							$criteria->limit = 3;						
							$bottomAds = Advertisement::model()->findAll($criteria);	//print_r($bottomAds);						
						?>
					   <div class="row">
                            <div class="col-md-4">
                                <div class="tar_ad_part">
                                    <?php echo $bottomAds[0]->content; ?>
									<!--a class="tar_ad_img" href="#">
                                        <img src="images/tar_ad_img_1.jpg">
                                    </a-->
                                    <div class="pad"></div>
                                </div>
                            </div>
                            <div class="col-md-4 tar_last_ad_1">
                                <div class="tar_ad_part">
                                    <?php echo $bottomAds[1]->content; ?>
                                    <div class="pad"></div>
                                </div>
                            </div>
                            <div class="col-md-4 tar_last_ad">
                                <div class="tar_ad_part">
                                   <?php if (isset($bottomAds[2])) echo $bottomAds[2]->content; ?>
                                    <div class="pad"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer>
    <div class="container">
        <div class="tar_left_cont_foot">
            <a class="tar_bot_logo" href="<?php echo Yii::app()->createUrl('/site/index'); ?>">
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_bot_logo.png" alt="">
            </a>
            <div class="tar_counters_vis">
                <!-- Yandex.Metrika informer -->
<a href="https://metrika.yandex.ru/stat/?id=18697171&amp;from=informer"
target="_blank" rel="nofollow"><img src="//bs.yandex.ru/informer/18697171/1_1_FFFFFFFF_EFEFEFFF_0_pageviews"
style="width:80px; height:15px; border:0;" alt="??????.???????" title="??????.???????: ?????? ?? ??????? (?????????)" onclick="try{Ya.Metrika.informer({i:this,id:18697171,lang:'ru'});return false}catch(e){}" alt="" /></a>
<!-- /Yandex.Metrika informer -->

<!-- Yandex.Metrika counter -->
<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter18697171 = new Ya.Metrika({id:18697171,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/18697171" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->
<!--LiveInternet counter--><script type="text/javascript"><!--
document.write("<a href='//www.liveinternet.ru/click' "+
"target=_blank><img src='//counter.yadro.ru/hit?t26.5;r"+
escape(top.document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";h"+escape(document.title.substring(0,80))+";"+Math.random()+
"' alt='' title='LiveInternet: ???????? ????? ??????????? ??"+
" ???????' "+
"border='0' width='88' height='15'><\/a>")
//--></script><!--/LiveInternet-->
                <div class="pad"></div>
            </div>
            <div class="pad"></div>
        </div>
        <div class="tar_right_cont_foot">
            <div class="tar_top_cont_foot">
                <div class="tar_foot_menu">
                    <ul class="foot_menu">
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('/site/index', array('page'=>'company')); ?>">
                                <?php echo Yii::t('general', 'About TAREX'); ?>  
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('/site/index', array('page'=>'contacts')); ?>">
                                <?php echo Yii::t('general', 'Contacts'); ?>  
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('/site/index', array('page'=>'products')); ?>">
                                <?php echo Yii::t('general', 'Products'); ?> 
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('/site/index', array('page'=>'spareparts')); ?>">
                                <?php echo Yii::t('general', 'Spare parts'); ?> 
                            </a>
                        </li>
                    </ul>
                </div>
		<div class="soc_text"><span>Иконки соц.сетей временно отключены</span>
		<br/> 
		<span style="margin-left: 630px;">Иконки соц.сетей</span></div>
                <!--div class="tar_foot_social">
                    <div class="soc_icon">
                        <a href="#">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_twitter.jpg" alt="" />
                        </a>
                        <a href="#">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_facebook.jpg" alt="" />
                        </a>
                        <a href="#">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_vk.jpg" alt="" />
                        </a>
                    </div>
                    <div class="soc_text">
                        Мы в соц. сетях
                    </div>
                </div-->
                <div class="pad"></div>
            </div>
            <div class="tar_bot_cont_foot">
                <div class="foot_text">
                    <p>Автозапчасти оптом предлагаются нами по ценам, с которыми вы можете ознакомиться в соответствующем разделе сайта.<br>
                    Приобретая запчасти оптом, Вы получаете гарантию не только высокого заводского качества, но и гарантию отличной цены.
                    </p>
                    <p>
                    Не стоит забывать также о том, что сейчас на рынке автозапчастей реализуется большое количество контрафактной, некачественной
                    продукции и правильный выбор поставщика убережет Вас от всех неприятностей, которые могут возникнуть в будущем.
                    </p>
                </div>
                <div class="tar_counters">

                    <a class="tar_counter" href="#">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_counter.jpg" alt="" />
                    </a>
                    <a class="tar_counter" href="#">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_counter.jpg" alt="" />
                    </a>
                    <a class="tar_counter" href="#">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_counter.jpg" alt="" />
                    </a>
                    <div class="pad"></div>
                </div>
            </div>
            <div class="pad"></div>
        </div>
    </div>
	<!-- Yandex.Metrika counter -->
<script type="text/javascript">
var yaParams = {/*Здесь параметры визита*/};
</script>

<script type="text/javascript">
(function (d, w, c) {
    (w[c] = w[c] || []).push(function() {
        try {
            w.yaCounter26747061 = new Ya.Metrika({id:26747061,
                    webvisor:true,
                    clickmap:true,
                    trackLinks:true,
                    accurateTrackBounce:true,params:window.yaParams||{ }});
        } catch(e) { }
    });

    var n = d.getElementsByTagName("script")[0],
        s = d.createElement("script"),
        f = function () { n.parentNode.insertBefore(s, n); };
    s.type = "text/javascript";
    s.async = true;
    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

    if (w.opera == "[object Opera]") {
        d.addEventListener("DOMContentLoaded", f, false);
    } else { f(); }
})(document, window, "yandex_metrika_callbacks");
</script>
<noscript><div><img src="//mc.yandex.ru/watch/26747061" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
<!-- /Yandex.Metrika counter -->


<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56050756-1', 'auto');
  ga('send', 'pageview');

</script>
	</footer>

<!-- **************************** start of searchByVIN box ***********************/ -->
 <div id='searchbyvin' class="tar_recover_form"> 
	<div class="tar_in_head">
		<span><?php echo Yii::t('general','Search parts by VIN'); ?> </span>
		<a href="#" class='back-link' >
				<img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_x.png" alt="" />
		</a> 
	</div>
	<div class="tar_recover_in_form" >
		<div class='tar_in_text_1'>
		 <?php echo Yii::t('general','Under development...'); //echo Yii::t('general', 'Enter the VIN number to search for'), ':';?><br /> 	
		</div>			 
		<?php /* $form=$this->beginWidget('CActiveForm', array(
			'id'=>'assortment-form',
			'enableAjaxValidation'=>false,
			'method'=>'get',
			'action'=>array('assortment/searchbyvin'),
			'htmlOptions' => array( 
			),
		)); ?>
		<input type='text' name='vin' size='42' class='input_text'  > 
		 */ ?>
		<center><?php //echo CHtml::submitButton(Yii::t('general', 'Search'), array('class'=>'in_form_submit')); ?>
		</center>		 
       		
	</div><!-- tar_recover_in_form -->
	
	<?php //$this->endWidget(); ?>
	
</div><!-- id='searchbyvin' --> 

<?php /*
Yii::app()->clientScript->registerScript('searchbyvin-script', "
$('#opendialog').click(function(data){ 	 
		$('#searchbyvin').show();
		return false;
	});
$('.back-link').click(function(data){	 
		$('#searchbyvin').hide();
		return false;
	});", CClientScript::POS_END);	 

Yii::app()->clientScript->registerScript('hide-for-assortment', "
	var width = ($(window).width() > 1200) ? '885' : '693';
	$('.tar_cat_top').css({marginLeft:'0', width: width + 'px'});
	$('.tar_cat_bot').css({marginLeft:'0', width: width + 'px'});
	$('.tar_cat_invis').css({width:'0', height:'0'});		 
	$('.tar_category_vis').animate({width:'0' }, 0, function(){
		$('.tar_category_vis').css('overflow','visible'); // on complete
	});  
        $('.tar_category_vis').css('width','0px');
	$('.tar_badge_vis').css({right:'-30px'});
	//	$('.tar_category_vis').addClass('hidden');
	//	getElementByClassName('tar_cat_invis').setAttribute('style','width:0');		
	
	$('#owl-demo').owlCarousel({

		navigation : true, // Show next and prev buttons
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		autoPlay: 5000

    // 'singleItem:true' is a shortcut for:
    // items : 1,
    // itemsDesktop : false,
    // itemsDesktopSmall : false,
    // itemsTablet: false,
    // itemsMobile : false

		});
	
});", CClientScript::POS_END);
*/
?>
<script type="text/javascript">   	
	$('select').each(function(){
    $(this).siblings('p.simply').text( $(this).children('option:selected').text() );
    });
    $('select').change(function(){
    $(this).siblings('p.simply').text( $(this).children('option:selected').text() );
    });
</script>

<script type="text/javascript">
    $(document).ready(function() { 
	
	// для контроллера 	assortment  мы скрываем меню категорий 
		if (window.location.search.indexOf('?r=assortment') == 0) 
		{
			var w  = ($(window).width() > 1200) ? '885' : '693';
			$('.tar_cat_top').css({marginLeft:'0', width: w + 'px'});
			$('.tar_cat_bot').css({marginLeft:'0', width: w + 'px'});
			$('.tar_cat_invis').css({width:'0', height:'0'});		
		        $('.tar_category_vis').animate({width:'0' }, 0, function(){
				$('.tar_category_vis').css('overflow','visible'); // on complete
			});  
			//  $('.tar_category_vis').css('width','0px');
			//  $('.tar_category_vis').addClass('hidden');
			//	getElementByClassName('tar_cat_invis').setAttribute("style","width:0");
			
			$('.tar_badge_vis').css({right:'-30px'});
		}
	// для поиска по VIN	
		$('#opendialog').click(function(data){ 	 
			$('#searchbyvin').show();
			return false;
		});
		$('.back-link').click(function(data){	 
			$('#searchbyvin').hide();
			return false;
		});
		
	// Карусель
		$("#owl-demo").owlCarousel({

		navigation : true, // Show next and prev buttons
		slideSpeed : 300,
		paginationSpeed : 400,
		singleItem:true,
		autoPlay: 5000

    // "singleItem:true" is a shortcut for:
    // items : 1,
    // itemsDesktop : false,
    // itemsDesktopSmall : false,
    // itemsTablet: false,
    // itemsMobile : false

		});

	}); // end of jQuery(document).ready
</script>


<!--<script type="text/javascript">-->
    <!--$(function(){-->
        <!--$('.tar_panel').tabSlideOut({							//Класс панели-->
            <!--tabHandle: '.tar_badge_vis',						//Класс кнопки-->
            <!--pathToTabImage: 'images/tar_category.png',				//Путь к изображению кнопки-->
            <!--imageHeight: '133px',						//Высота кнопки-->
            <!--imageWidth: '41px',						//Ширина кнопки-->
            <!--tabLocation: 'left',						//Расположение панели top - выдвигается сверху, right - выдвигается справа, bottom - выдвигается снизу, left - выдвигается слева-->
            <!--speed: 300,								//Скорость анимации-->
            <!--action: 'click',								//Метод показа click - выдвигается по клику на кнопку, hover - выдвигается при наведении курсора-->
            <!--topPos: '0',							//Отступ сверху-->
            <!--fixedPosition: false						//Позиционирование блока false - position: absolute, true - position: fixed-->
        <!--});-->
    <!--});-->
<!--</script>-->

<script type="text/javascript">
    if($(window).width() > 1200){
        $(function(){
            $('.tar_badge_vis').on('click',function(){
                if($('.tar_cat_invis').is(':hidden')){
                   $('.tar_category_vis').animate({width:'240px'},50, 
						 function(){ $('.tar_category_vis').css('overflow','visible'); });
                 		     $('.tar_cat_invis').css('display','block');
		    $('.tar_cat_top').animate({marginLeft:'250px', width:'635px'},50);
		    $('.tar_cat_bot').animate({marginLeft:'250px', width:'635px'},50);
		    $('.tar_cat_invis').animate({width:'240px', height:'560px'},50);
                    $('.shift-right40').css({marginLeft:'275px'});
		    $('.breadcrumbs').css({marginLeft:'277px'});
                }else{
                    $('.tar_category_vis').animate({width:'0'},50, function(){ $('.tar_category_vis').css('overflow','visible');  });  
                    $('.tar_cat_top').animate({marginLeft:'0', width:'885px'},50);
		    $('.tar_cat_bot').animate({marginLeft:'0', width:'885px'},50);
		    $('.tar_cat_invis').animate({width:'0', height:'0'},50);
                    $('.tar_badge_vis').css({right:'-30px'}); 
		    $('.tar_cat_invis').css('display','none');
		    $('.shift-right40').css({marginLeft:'40px'});
		    $('.breadcrumbs').css({marginLeft:'40px'});
                }
            });
        });
    };
    if($(window).width() < 1200 && $(window).width() > 992){
        $(function(){
            $('.tar_badge_vis').on('click',function(){
                if($('.tar_cat_invis').is(':hidden')){
                     $('.tar_category_vis').animate({width:'240px'},50, function(){
						$('.tar_category_vis').css('overflow','visible');  });
                     $('.tar_cat_top').animate({marginLeft:'250px', width:'443px'},50);
		    $('.tar_cat_bot').animate({marginLeft:'250px', width:'443px'},50);
		    $('.tar_cat_invis').css('display','block');
		    $('.tar_cat_invis').animate({width:'240px', height:'560px'},50);
		    $('.shift-right40').css({marginLeft:'275px'});
		    $('.breadcrumbs').css({marginLeft:'277px'});
                }else{
                    $('.tar_category_vis').animate({width:'0'},50,  function(){ $('.tar_category_vis').css('overflow','visible'); }); 
		     $('.tar_cat_top').animate({marginLeft:'0', width:'693px'},50);
		    $('.tar_cat_bot').animate({marginLeft:'0', width:'693px'},50);
		    $('.tar_cat_invis').animate({width:'0', height:'0'},50);
                    $('.tar_badge_vis').css({right:'-30px'}); 
		    $('.tar_cat_invis').css('display','none');
 		    $('.shift-right40').css({marginLeft:'40px'});
		    $('.breadcrumbs').css({marginLeft:'277px'});
                }
            });
        });
    };
</script>
</body>
</html>