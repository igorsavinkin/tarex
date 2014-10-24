C:\Users\CD86~1\AppData\Local\Temp\F3TDE34.tmp\index.php<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
      <?php echo $this->pageTitle; ?>
    </title>
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/order.css" rel="stylesheet" type="text/css">
    <link href="css/media.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css">
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="css/owl.theme.css" rel="stylesheet" type="text/css">
    <script src="js/jquery.js"></script>
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/tabSlideOut.js"></script>
	<script type="text/javascript" src="assets/35648952/jquery.yii.js"></script>
	<script type="text/javascript">
	jQuery(function($) {  
	 	// скрипт для  автоматической отсылки формы с языком 
		jQuery('body').on('change','#_lang',function(){jQuery.yii.submitForm(this,'',{});return false;});
	 // скрипт для  автоматической отсылки формы с городом 
	 jQuery('body').on('change','#Cityes_Name',function(){jQuery.yii.submitForm(this,'',{});return false;});
	}); 
	</script>
</head>
<body>
<?php echo $content; ?>
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
                                        <img src="images/tar_top_logo.png">
                                    </a>
                                </div>
                                <div class="tar_ad_phone">
                                    <div class="tar_ad">
                                        Россия г. Москва,<br>
                                        ул. Складочная д. 1, стр. 10
                                    </div>
                                    <div class="tar_phone">
                                        <span class="s_one">+7 (495) </span><span class="s_two">785-88-50 </span><span class="tar_red_span">(многоканальный) info@tarex.ru</span>
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
                                <!--div class="tar_lang_all">
                                    <div class="tar_lang">
                                    <div class="tar_rus_eng">
                                        <a href="#">
                                            <img src="images/tar_rus.jpg">
                                        </a>
                                        <a href="#">
                                            <img src="images/tar_eng.jpg">
                                        </a>
                                    </div>
									
                                    <form>
                                        <p class="simply"></p><p class="tar_border_lang"></p>
                                        
                                        <select>
                                            <option>Русский</option>
                                            <option>English</option>
                                        </select>
                                    </form>
                                </div>
                                </div>
                            </div><!-- tar_lang_all -->
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
									echo CHtml::textField('findbyoem-value', $value); ?>
                                    <input type="submit" class="form_submit" value="<?php echo Yii::t('general' , 'Search'); ?>">
                                 <?php echo CHtml::endForm(); ?>
                            </div>							
                            <!-- кнопки поиска по VIN и в огромном общем каталоге -->
                            <!--div class="tar_red_buttons">
                                <div class="tar_vip">
                                    <a href="#">
                                        <img src="images/tar_vip.png">
                                    </a>
                                </div>
                                <div class="tar_catalog">
                                    <a href="#">
                                        <img src="images/tar_catalog.png">
                                    </a>
                                </div>
                                <div class="pad"></div>
                            </div-->
                            <div class="tar_basket">
                                <a class="tar_bas" href="<?php echo Yii::app()->createUrl('assortment/cart');?>" >
                                    <img src="images/tar_basket.png">
									<span><?php $cartContent =  Yii::t('general', 'BASKET') . '<br />' . Yii::app()->shoppingCart->getItemsCount() .' ' . Yii::t('general', 'item(s)');
									$cost = Yii::t('general', 'for') . ' ' . Yii::app()->shoppingCart->getCost() . ' '.  Yii::t('general','RUB'); 
									echo $cartContent , '<br>', $cost; ?>
									</span> 
                                </a>
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

                    <div class="item"><img src="images/tar_slide.jpg"></div>
                    <div class="item"><img src="images/tar_slide.jpg"></div>
                    <div class="item"><img src="images/tar_slide.jpg"></div>
                    <div class="item"><img src="images/tar_slide.jpg"></div>

                </div>
            </div>
            <div class="tar_cont">
                <div class="container tar_container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tar_category_vis tar_panel tar_open">
                                <div class="tar_badge_vis">
                                    <img src="images/tar_category.png">
                                </div>
                                <div class="tar_cat_invis">
								<?php 
											$categories = Category::model()->findAll(); 
											$i=1;
											foreach($categories as $category)
											{	?>															
												 <a class="tar_cat<?php if(($i++ % 2) == 1) echo ' tar_cat_first'; ?>" href="<?php echo $this->createUrl('assortment/index', array('category'=>$category->id)); ?>">
												 <img src="images/subgroups/tar_img_<?php echo $category->id;?>.jpg">
													<span>
														<?php echo str_replace(' ', '<br>', Yii::t('general', $category->name)); ?>
													</span>
												</a><?php 		 
											} 	
										/*	$criteria = new CDbCriteria;
											$criteria->distinct = true;
											$criteria->order = 'subgroup ASC';
											$criteria->select = array('subgroup');
											$criteria->condition = 'subgroup <> "" ';
											$subs = Assortment::model()->findAll($criteria); 
											$i=1;
											foreach($subs as $sub)
											{	?>															
												 <a class="tar_cat<?php if(($i++ % 2) == 1) echo ' tar_cat_first'; ?>" href="<?php echo $this->createUrl('assortment/index', array('subgroup'=>$sub->subgroup)) ?>">
												 <img src="images/subgroups/tar_img_<?php echo $sub->getImageIndex();?>.jpg">
													<span>
														<?php echo str_replace(' ', '<br>', $sub->subgroup); ?>
													</span>
												</a><?php 		 
											} 	*/										
											?>
                                    <div class="pad"></div>
                                </div><!-- tar_cat_invis -->
                                <div class="pad"></div>
                            </div>
                            <div class="tar_category">
                                <div class="tar_badge">
                                    <img src="images/tar_category.png">
                                </div>
								<?php $i=1;
											foreach($subs as $sub)
											{	?>															
												 <a class="tar_cat<?php if(($i++ % 2) == 1) echo ' tar_cat_first'; ?>" href="<?php echo $this->createUrl('assortment/index', array('subgroup'=>$sub->subgroup)) ?>">
												 <img src="images/subgroups/tar_img_<?php echo $sub->getImageIndex();?>.jpg">
													<span>
														<?php echo str_replace(' ', '<br>', $sub->subgroup); ?>
													</span>
												</a><?php 	/**/	 
											} 					
											?>
                                <div class="pad"></div>
                            </div>
                            <div class="tar_adv">
                                <?php echo Advertisement::model()->findByAttributes(array('id'=>1, 'isActive'=>1))->content; ?>
								<?php echo Advertisement::model()->findByAttributes(array('id'=>2, 'isActive'=>1))->content; ?>
								<?php echo Advertisement::model()->findByAttributes(array('id'=>3, 'isActive'=>1))->content; ?> 
								<!--a class="tar_ad_1" href="#">
                                    <img class="advis_1" src="images/tar_ad_1.jpg">
                                </a>
                                <a class="tar_ad_2" href="#">
                                    <img class="advis_1" src="images/tar_ad_2.jpg">
                                </a-->
                            </div>
                            <div class="tar_catalog_goods">
                                <div class="tar_cat_top">
                                    <div class="tar_cat_top_in">
                                        <div class="tar_cat_top_title">
                                           <?php echo Yii::t('general', 'Manufacturers'); ?> 
                                        </div>
                                        <div class="tar_cat_top_lists">
											<ul class="tar_list_1">
											<?php 
											$criteria = new CDbCriteria;
											$criteria->order = 'id ASC';
											$criteria->condition = 'depth =1';	
											$i=0;											
											foreach (Assortment::model()->findAll($criteria) as $assort)
												{	   
													if (($i % 5) == 0 && $i>0) echo '</ul><ul class="tar_list_2">';
													$i++; 
													echo "<li><a href='" . Yii::app()->createUrl('site/FrontendPavel' , array( 'id'=>$assort->id )) . "'> " . Yii::t('general', $assort->title) . "</a></li>";	 
												}  ?>
												<span class="tar_cat_line"></span><?php										
											echo "<li><a href='" . Yii::app()->createUrl('site/FrontendPavel') . "'><font size='+1' face='Helvetica' >" . Yii::t('general', 'ALL MAKES') . "</font></a></li>";  ?> 
											</ul> 
                                            <div class="pad"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tar_cat_bot">
                                    <div class="tar_brands_car">
                                        <div class="tar_cat_bot_title">
                                             <?php echo Yii::t('general', 'Car makes'); ?>
                                        </div>
                                            <div class="tar_cars">
												<div class="tar_cat_bot_form"><b>Легковые:</b></div>
												<div class="tar_cat_bot_lists">												
													<ul>
											<?php 
												$criteria = new CDbCriteria;
												$criteria->compare('depth', 2);	
												$criteria->order = 'title ASC';			
												$manufacturers = Assortment::model()->findAll($criteria);
												$makesgr=array(); $makes=array();												
												foreach($manufacturers as $m)
												{
													if (!isset($_GET['id'])) {
														$Parent=Assortment::model()->findByPk($m->parent_id);
														if($Parent->title=="ГРУЗОВИКИ"){
															$makesgr[$m->id] =  $m->title; 
														}else{
															$makes[$m->id] =  $m->title; 
														}															
													}
													elseif ($m->parent_id == $_GET['id']) {
														$Parent=Assortment::model()->findByPk($m->parent_id);
														if($Parent->title=="ГРУЗОВИКИ"){
															$makesgr[$m->id] =  $m->title; 
														}else{
															$makes[$m->id] =  $m->title; 
														}														
													}
												}			
												$i=1;
												if (!empty($makes)) 
												{		  											
													foreach ($makes as $key => $make) 
													{  
														echo '<li>' ,CHtml::Link( $make, array('assortment/index', 'id'=>$key, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment')), '</li>'; 
														if (($i++ % 6 ) == 0) echo '</ul><ul>';
													}
												} 
												echo '</ul>'; ?>
												</div>
												<div class='pad'></div>
												<div class="tar_cat_bot_form"><b>Грузовые:</b></div>
												<div class="tar_cat_bot_lists">												
													<ul>
												<?php
											 	if (!empty($makesgr)) 
												{			
													$i=1;													
													foreach ($makesgr as $key => $make) 
													{ 														
														echo '<li>' ,CHtml::Link( $make, array('assortment/index', 'id'=>$key, 'Subsystem'=>'Warehouse automation', 'Reference'=>'Assortment')), '</li>'; 
														if (($i++ % 3 ) == 0) echo '</ul><ul>';
													}
												}  	 				
												echo '</ul>';?>                                               
                                            </div><!-- tar_cat_bot_lists-->
                                            <div class="pad"></div>
                                        </div>
                                    </div>
                                    <div class="pad"></div>
                                </div>
                            <div class="pad"></div>
                            </div>
                        </div>
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
                                                <a class="tar_part" href="#">
                                                    <img src="images/<?php echo $offerArr[1]['img']; ?>" width='213' height='213' >
                                                </a>
                                                <div class="tar_sell_part_name">
                                                    <?php echo $offerArr[1]['description']; ?><!--Название запчасти если оно длинное-->
                                                </div>
                                                <a class="tar_price" href="<?php echo $this->createUrl('assortment/addToCart', array( 'id'=>$offerArr[1]['id'])); ?>">
                                                    <span><?php echo $offerArr[1]['price']; ?></span>руб
                                                </a>
                                            </div>
                                            <div class="tar_two_sells">
                                                <div class="tar_sell_part">
                                                    <a class="tar_part" href="#">
                                                        <img src="images/<?php echo $offerArr[2]['img']; ?>" width='213' height='213' >
                                                    </a>
                                                    <div class="tar_sell_part_name">
                                                      <?php echo $offerArr[2]['description']; ?><!--Название запчасти если оно длинное-->
                                                    </div>
                                                   <a class="tar_price" href="<?php echo $this->createUrl('assortment/addToCart', array( 'id'=>$offerArr[2]['id'])); ?>">
														<span><?php echo $offerArr[2]['price']; ?>
                                                       </span>руб
                                                    </a>
                                                </div>
                                                <div class="tar_sell_part">
                                                    <a class="tar_part" href="#">
                                                        <img src="images/<?php echo $offerArr[3]['img']; ?>" width='213' height='213' >
                                                    </a>
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
                                                <a class="tar_part" href="#">
                                                    <img src="images/<?php echo $offerArr[4]['img']; ?>" width='213' height='213' >
                                                </a>
                                                <div class="tar_sell_part_name">
                                                  <?php echo $offerArr[4]['description']; ?><!--Название запчасти если оно длинное-->
                                                </div>
                                               <a class="tar_price" href="<?php echo $this->createUrl('assortment/addToCart', array( 'id'=>$offerArr[4]['id'])); ?>"> <span><?php echo $offerArr[4]['price']; ?>
                                                     </span>руб
                                                </a>
                                            </div>
                                            <div class="tar_sell_part">
                                                <a class="tar_part" href="#">
                                                    <img src="images/<?php echo $offerArr[5]['img']; ?>" width='213' height='213' >
                                                </a>
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
						 $criteria=new CDbCriteria;
						 $criteria->condition = 'content <> "" ';					 
						 $newsFromModel = News::model()->first5()->findAll($criteria);
						 $i=0;
						 $newsItem=array();
						 foreach($newsFromModel as $item)
						 {
							$date = new DateTime($item['newsDate']);
							$newsItem[$i]="<a class='tar_new_img' href='{$item['link']}'>
														<img src='images/{$item['imageUrl']}' width='212' height='139'>  
													</a>
													<div class='tar_new_title'>
														<a href='{$item['link']}'>
															{$date->format('d.m.Y H:i')}<br><b>
															{$item['title']}</b></a>
													</div>
							<div class='tar_news_text'>{$item['content']}</div>";
							$i++;
						 }
						 
				// берём носости из RSS канала если авторских новостей меньше чем 5
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
								$description = substr( preg_replace('/<img.*?\/\>/', '', $channel['item'][$i]->description), 0, 1000) . '...'; 

								$newsItem[$i] = !empty($imgSrc) ? "<a class='tar_new_img' href='{$channel['item'][$i]->link}'>
														<img src='{$imgSrc}' width='212' height='139'>  
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
                                   <?php echo $bottomAds[2]->content; ?>
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
            <a class="tar_bot_logo" href="#">
                <img src="images/tar_bot_logo.png">
            </a>
            <div class="tar_counters_vis">
                <a class="tar_counter" href="#">
                    <img src="images/tar_counter.jpg">
                </a>
                <a class="tar_counter" href="#">
                    <img src="images/tar_counter.jpg">
                </a>
                <a class="tar_counter" href="#">
                    <img src="images/tar_counter.jpg">
                </a>
                <div class="pad"></div>
            </div>
            <div class="pad"></div>
        </div>
        <div class="tar_right_cont_foot">
            <div class="tar_top_cont_foot">
                <div class="tar_foot_menu">
                    <ul class="foot_menu">
                        <li>
                            <a href="#">
                                О компании
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Контакты
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Продукция
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                Автозапчасти
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="tar_foot_social">
                    <div class="soc_icon">
                        <a href="#">
                            <img src="images/tar_twitter.jpg">
                        </a>
                        <a href="#">
                            <img src="images/tar_facebook.jpg">
                        </a>
                        <a href="#">
                            <img src="images/tar_vk.jpg">
                        </a>
                    </div>
                    <div class="soc_text">
                        Мы в соц. сетях
                    </div>
                </div>
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
                        <img src="images/tar_counter.jpg">
                    </a>
                    <a class="tar_counter" href="#">
                        <img src="images/tar_counter.jpg">
                    </a>
                    <a class="tar_counter" href="#">
                        <img src="images/tar_counter.jpg">
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


<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-56050756-1', 'auto');
  ga('send', 'pageview');

</script>

	</footer>



<script>
    $('select').each(function(){
    $(this).siblings('p.simply').text( $(this).children('option:selected').text() );
    });
    $('select').change(function(){
    $(this).siblings('p.simply').text( $(this).children('option:selected').text() );
    });
</script>

<script>
    $(document).ready(function() {

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

    });
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

<script>
    if($(window).width() > 1200){
        $(function(){
            $('.tar_badge_vis').on('click',function(){
                if($('.tar_cat_invis').is(':hidden')){
                    $('.tar_cat_invis').animate({width:'236px', height:'595px'},50);
                    $('.tar_badge_vis').animate({right:'-43px'},50);
                    $('.tar_category_vis').animate({width:'236px'},50);
                    $('.tar_cat_top').animate({marginLeft:'250px', width:'635px'},50);
                    $('.tar_cat_bot').animate({marginLeft:'250px', width:'635px'},50);
                }else{
                    $('.tar_cat_invis').animate({width:'0', height:'0'},50);
                    $('.tar_cat_top').animate({marginLeft:'0', width:'885px'},50);
                    $('.tar_cat_bot').animate({marginLeft:'0', width:'885px'},50);
                    $('.tar_category_vis').animate({width:'0'},50);
                    $('.tar_badge_vis').animate({right:'-30px'},50);
                }
            });
        });
    };
    if($(window).width() < 1200 && $(window).width() > 992){
        $(function(){
            $('.tar_badge_vis').on('click',function(){
                if($('.tar_cat_invis').is(':hidden')){
                    $('.tar_cat_invis').animate({width:'236px', height:'595px'},50);
                    $('.tar_badge_vis').animate({right:'-43px'},50);
                    $('.tar_category_vis').animate({width:'236px'},50);
                    $('.tar_cat_top').animate({marginLeft:'250px', width:'443px'},50);
                    $('.tar_cat_bot').animate({marginLeft:'250px', width:'443px'},50);
                }else{
                    $('.tar_cat_invis').animate({width:'0', height:'0'},50);
                    $('.tar_cat_top').animate({marginLeft:'0', width:'693px'},50);
                    $('.tar_cat_bot').animate({marginLeft:'0', width:'693px'},50);
                    $('.tar_category_vis').animate({width:'0'},50);
                    $('.tar_badge_vis').animate({right:'-30px'},50);
                }
            });
        });
    };
</script>

</body>
</html>