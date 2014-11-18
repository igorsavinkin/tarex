<?
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/seotools/seotools.class.php');
	$ST = new Seotools; 
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" type="image/ico" href="/app2/img/favicon.ico">

    <title><?
$meta_title = $ST->get('title');
$meta_keywords = $ST->get('keywords');
$meta_desc = $ST->get('description');
if ($meta_title) {echo $meta_title;}
else {echo $this->pageTitle;} ?>
</title> 
<?if ($meta_keywords) echo '<meta name="keywords" content="'. $meta_keywords .'" />';
if ($meta_desc) 	echo '<meta name="description" content="'. $meta_desc .'" />';?>
	<link href="<?php echo Yii::app()->baseUrl; ?>/css/in.css" rel="stylesheet" type="text/css">
	<link href="<?php echo Yii::app()->baseUrl; ?>/css/form.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/reset.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/order.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/media.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/bootstrap-theme.css" rel="stylesheet" type="text/css"> 
    <link href="<?php echo Yii::app()->baseUrl; ?>/css/gridview.css" rel="stylesheet" type="text/css">
  
	<?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
	<?php Yii::app()->clientScript->registerCoreScript('jQuery'); ?>  
	<script src="<?php echo Yii::app()->baseUrl; ?>/js/bootstrap.js"></script> 
	<script type="text/javascript">
		jQuery(function($) {  
			// скрипт для  автоматической отсылки формы с языком 
			jQuery('body').on('change','#_lang',function(){jQuery.yii.submitForm(this,'',{});return false;});
		 // скрипт для  автоматической отсылки формы с городом 
		 jQuery('body').on('change','#Cityes_Name',function(){jQuery.yii.submitForm(this,'',{});return false;});
		}); 
	</script>
	<?php
		  //  echo 'URI = ',  Yii::app()->request->requestUri;
			
			$RoleId=Yii::app()->user->role;
			$UserName=Yii::app()->user->name;
			$UserId=Yii::app()->user->id;
			$OrganizationId=Yii::app()->user->organization;			
			
			$Language = isset($_GET['Language']) ? $_GET['Language'] : Yii::app()->getLanguage();
			echo "<script language='javascript'> 		 
				var RoleId=".$RoleId."; 
				var UserName='".$UserName."'; 
				var UserId='".$UserId."'; 
				var OrganizationId='".$OrganizationId."'; 
				var Language='".$Language."'; 
				";
			echo "//console.log('Language '+Language);";
			echo "</script>";
		?>
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
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_top_logo.png">
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
                              <div class="tar_usermenu">
                                    <a class="tar_name" href="<?php echo Yii::app()->createUrl('/user/update', array('id'=>Yii::app()->user->id)); ?>"><?php echo Yii::app()->user->username; ?></a><br>
                                      
                                    <span><?php echo Yii::app()->user->email; ?></span>
                                    <br>
                                    <?php echo CHtml::Link(Yii::t('general', 'Logout'), array('/site/logout'), array('class'=>"tar_logout")); ?>
                                </div> 
									<?php $this->widget('LangBox'); ?>
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
									echo CHtml::textField('findbyoem-value', $value, array('placeholder'=> Yii::t('general', 'OEM, Article or part name')) ); ?>
                                    <input type="submit" class="form_submit" value="<?php echo Yii::t('general' , 'Search'); ?>">
                                 <?php echo CHtml::endForm(); ?>
                            </div>

							 <div class="tar_basket">
                                <a class="tar_bas" href="<?php echo Yii::app()->createUrl('assortment/cart');?>" >
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_basket.png">
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
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_vip.png">
                                    </a>
                                </div>
                                <div class="tar_catalog">
                                    <a href="#">
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_catalog.png">
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
            <div class="tar_icons">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tar_icons_block">
                                <div class="tar_icons_left">
                                    Mobile v.2.0 Tarex MOBILE version
                                </div>
                                <div class="tar_icons_right">
                                    <div class="tar_icons_border">
							 <?php 
								$Subsystem= Yii::app()->session['Subsystem'];
								$Reference =  isset($_GET['Reference']) ? $_GET['Reference'] : Yii::app()->session['Reference'];
								$MainMenu=MainMenu::model()->FindAll(
									array(
										'select'=>'Subsystem,Img',
										'order'=> 'DisplayOrder',
										'distinct'=>true,
										'condition'=>'RoleId LIKE :RoleId',
										'params'=>array(':RoleId'=>'%' . Yii::app()->user->role . '%'),
									)										
								);		
								foreach ($MainMenu as $r)
								{  
									$checked = ($Subsystem==$r->Subsystem) ? 'checked' : '';
								 	if($r->Img != '')  
									{		 
										$_GET['Subsystem'] = $r->Subsystem; // меняем Subsystem
										echo "<div class='tar_icons_item {$checked}'>",  CHtml::Link("<img src='/app3/images/subsystem/".$r->Img."' alt='".Yii::t('general', $r->Subsystem)."' title='".Yii::t('general', $r->Subsystem)."'>", array( $this->id. '/' . $this->getAction()->id) + $_GET) , '</div>';
									}
								}  ?> 
                                    </div>
                                </div><!-- tar_icons_right -->
                                <div class="pad"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tar_bluemenu">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <?php 
							if (!empty($Subsystem))
							{
								$references=MainMenu::model()->FindAll(
									array(
										'order'=> 'DisplayOrder',
										'condition'=>'Subsystem=:Subsystem AND RoleId LIKE :RoleId',
										'params'=>array(':Subsystem'=>$Subsystem, ':RoleId'=>'%' . Yii::app()->user->role . '%'),
									)
								);							 	
								$itemsInColumn = ceil(count($references) / 4);
								//echo '$itemsInColumn = ', $itemsInColumn, '<br>'; //echo '$LeftMenu->itemCount = ', count($references), '<br>';
// all icons are here:  http://marcoceppi.github.io/bootstrap-glyphicons/img/glyphicons.png
								if (count($references)) 
								{ 
									echo '<div class="tar_bluemenu_block">  
												<div class="col-lg-3 col-md-4 col-sm-6">
													<ul>';
									$i=0;
									foreach ($references as $r)
									{
										$Img=$r->ReferenceImg;
										$link = $this->createUrl($r->Link."/admin", array('Subsystem'=>$r->Subsystem ,'Reference'=>$r->Link)); 								 	
										echo "<li><a href='{$link}' ";
										echo  ($r->Link == $Reference) ? "class='selected' >" : ">";
										if (''!=$r->ReferenceImg) echo "<img src='images/referenceimg/{$r->ReferenceImg}' alt='Icon'>";
										echo "<span>" , Yii::t('general', $r->Reference) , "</span></a></li>";
										$i++;
										if (($i % $itemsInColumn) == 0) 
										  echo '</ul></div><div class="col-lg-3 col-md-4 col-sm-6"><ul>';
									}	 
									echo "</ul>
										</div><!--col-lg-3 col-md-4 col-sm-6 -->
									</div><!-- tar_bluemenu_block -->"; 
								}									
							}							
							?> 
                        </div>
                    </div>
                </div>
            </div>
            <div class="tar_cont">
                <div class="container tar_container ma_bo">
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
					</div><!-- row -->
                    <div class="row">
                        <div class="col-md-12"><!--Категории -->
                            <div class="tar_category_vis tar_panel tar_open">
                                <div class="tar_badge_vis"> 
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_category.png">
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
										 <img src="<?php echo Yii::app()->baseUrl .'/images/subgroups/' .  $category->image; ?>" >
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
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_category.png">
                                </div>
                                <a class="tar_cat tar_cat_first" href="#">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_img_1.jpg">
                                    <span>
                                        Гидравлическая<br>система
                                    </span>
                                </a>
                                <a class="tar_cat" href="#">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_img_2.jpg">
                                    <span>
                                        Система<br>охлаждения
                                    </span>
                                </a>
                                <a class="tar_cat tar_cat_first" href="#">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_img_3.jpg">
                                    <span>
                                        Оптика
                                    </span>
                                </a>
                                <a class="tar_cat" href="#">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_img_4.jpg">
                                    <span>
                                        Детали кузова
                                    </span>
                                </a>
                                <a class="tar_cat tar_cat_first" href="#">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_img_5.jpg">
                                    <span>
                                        Система<br>подвески
                                    </span>
                                </a>
                                <a class="tar_cat" href="#">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_img_6.jpg">
                                    <span>
                                        Топливная<br>система
                                    </span>
                                </a>
                                <a class="tar_cat tar_cat_first" href="#">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_img_7.jpg">
                                    <span>
                                        Тормозная<br>система
                                    </span>
                                </a>
                                <a class="tar_cat" href="#">
                                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_img_8.jpg">
                                    <span>
                                        Ходовая<br>система
                                    </span>
                                </a>
                                <div class="pad"></div>
                            </div>
                            <div class="tar_component">
                                <?php // содержимое из cоответствующего view 
																 echo $content; 
															?> 
								<a href='#' id='up' style='float:right;z-index:1000;position:fixed; bottom: 20px; right:20px'><img src='images/btn-up.png' width='35px'/></a>							
								<!--div class="tar_pathway">                                  
									<ul>
                                        <li>
                                            <a href="#">Главная</a>
                                        </li>
                                        <li>
                                            <a href="#">Mitsubishi</a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="tar_caption">                                
                                </div-->
                                <!--div class="tar_component_body">
									
                                </div-->
                            </div>
                        </div>
                    </div><!-- row -->
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
						   <!-------------------------- вот разделительная линия ---------->
							<div class="col-md-12">
								<div class="tar_best_sellers">
									<div class="tar_best_title">
									<!--  Лидеры продаж-->
									  <?php echo Yii::t('general','Special Offers'); 
									  $carMakes = User::model()->findByPk(Yii::app()->user->id)->carMakes;
									  //$spOffers = SpecialOffer::model()->first5()->findAll();
									  $spOffers = SpecialOffer::model()->matchMakes($carMakes)->findAll(); //print_r($spOffers);
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
														<img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[1]['img']; ?>" width='213' height='213' >
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
															<img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[2]['img']; ?>" width='213' height='213' >
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
															<img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[3]['img']; ?>" width='213' height='213' >
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
														<img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[4]['img']; ?>" width='213' height='213' >
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
														<img src="<?php echo Yii::app()->baseUrl; ?>/img/foto/<?php echo $offerArr[5]['img']; ?>" width='213' height='213' >
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
							</div><!-- col-md-12 -->
					   
					   
					   
                            <!--div class="col-md-4">
                                <div class="tar_ad_part">
                                    <?php echo $bottomAds[0]->content; ?>
									<!--a class="tar_ad_img" href="#">
                                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_ad_img_1.jpg">
                                    </a>
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
                        </div><!-- row -->
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
                <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_bot_logo.png">
            </a>
            <div class="tar_counters_vis">
                <a class="tar_counter" href="#">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_counter.jpg">
                </a>
                <a class="tar_counter" href="#">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_counter.jpg">
                </a>
                <a class="tar_counter" href="#">
                    <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_counter.jpg">
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
                        <li>
                            <a href="<?php echo Yii::app()->createUrl('/site/index', array('page'=>'sitemap')); ?>">
                                <?php echo Yii::t('general', 'Sitemap'); ?>  
                            </a>
                        </li>						
                    </ul>
                </div>
                <div class="tar_foot_social">
                    <div class="soc_icon">
                        <a href="#">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_twitter.jpg">
                        </a>
                        <a href="#">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_facebook.jpg">
                        </a>
                        <a href="#">
                            <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_vk.jpg">
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
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_counter.jpg">
                    </a>
                    <a class="tar_counter" href="#">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_counter.jpg">
                    </a>
                    <a class="tar_counter" href="#">
                        <img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_counter.jpg">
                    </a>
                    <div class="pad"></div>
                </div>
            </div>
            <div class="pad"></div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="tar_copy">&copy; Igor Savinkin, Tarex Corp.</div>
            </div>
        </div>
    </div>
</footer>
<!-- **************************** start of searchByVIN box ***********************/ -->
 <div id='searchbyvin' class="tar_recover_form"> 
	<div class="tar_in_head">
		<span><?php echo Yii::t('general','Search parts by VIN'); ?> </span>
		<a href="#" class='back-link' >
				<img src="images/tar_x.png">
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
<?php 
Yii::app()->clientScript->registerScript('searchbyvin-script', "
$('#opendialog').click(function(data){ 	 
		$('#searchbyvin').show();
		return false;
	});
$('.back-link').click(function(data){	 
		$('#searchbyvin').hide();
		return false;
	});", CClientScript::POS_END);	
?>
<script>
    $('select').each(function(){
    $(this).siblings('p.simply').text( $(this).children('option:selected').text() );
    });
    $('select').change(function(){
    $(this).siblings('p.simply').text( $(this).children('option:selected').text() );
    });
</script>
<script>
    if($(window).width() >= 1200){
        $(function(){
            $('.tar_badge_vis').on('click',function(){
                if($('.tar_cat_invis').is(':hidden')){
                    $('.tar_cat_invis').animate({width:'236', height:'610' },50);
                    $('.tar_badge_vis').animate({right:'-43'},50);
                    $('.tar_component').animate({marginLeft:'282'},50);
                    $('.tar_category_vis').animate({width:'236'},50, function(){
                        $('.tar_category_vis').css('overflow','visible');
                    });
                }else{
                    $('.tar_cat_invis').animate({width:'0', height:'0'},50);
                    $('.tar_component').animate({marginLeft:'33'},50);
                    $('.tar_badge_vis').animate({right:'-30'},50);
                    $('.tar_category_vis').animate({width:'0'},50, function(){
                        $('.tar_category_vis').css('overflow','visible');
                    });
                }
            });
            $('.tar_badge_vis').trigger('click');
        });
    };
    if($(window).width() < 1200 && $(window).width() > 975){
        $(function(){
            $('.tar_badge_vis').on('click',function(){
                if($('.tar_cat_invis').is(':hidden')){
                    $('.tar_cat_invis').animate({width:'236', height:'595'},50);
                    $('.tar_badge_vis').animate({right:'-43'},50);
                    $('.tar_component').animate({marginLeft:'250'},50);
                    $('.tar_category_vis').animate({width:'236'},50, function(){
                        $('.tar_category_vis').css('overflow','visible');
                    });
                }else{
                    $('.tar_cat_invis').animate({width:'0', height:'0'},50);
                    $('.tar_component').animate({marginLeft:'33'},50);
                    $('.tar_badge_vis').animate({right:'-30'},50);
                    $('.tar_category_vis').animate({width:'0'},50, function(){
                        $('.tar_category_vis').css('overflow','visible');
                    });
                }
            });
            $('.tar_badge_vis').trigger('click');
        });
    };
</script>

</body>
</html>