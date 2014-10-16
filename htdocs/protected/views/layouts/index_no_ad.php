<!DOCTYPE html>
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
                                <form>
                                    <input type="text" class="form_text">
                                    <input type="submit" class="form_submit" value="Поиск">
                                </form>
                            </div>
                            <div class="tar_red_buttons">
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
                            </div>
                            <div class="tar_basket">
                                <a class="tar_bas" href="#">
                                    <img src="images/tar_basket.png">
                                    <span>
                                        <span>Корзина</span><br>
                                        0 товар(ов)<br>
                                        на 0 рублей
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
                                    <a class="tar_cat tar_cat_first" href="#">
                                        <img src="images/tar_img_1.jpg">
                                        <span>
                                            Гидравлическая<br>система
                                        </span>
                                    </a>
                                    <a class="tar_cat" href="#">
                                        <img src="images/tar_img_2.jpg">
                                        <span>
                                            Система<br>охлаждения
                                        </span>
                                    </a>
                                    <a class="tar_cat tar_cat_first" href="<?php echo $this->createUrl('assortment/index', array('subgroup'=>'Оптика')) ?>">
                                        <img src="images/tar_img_3.jpg">
                                        <span>
                                            Оптика
                                        </span>
                                    </a>
                                    <a class="tar_cat" href="#"> 
                                        <img src="images/tar_img_4.jpg">
                                        <span>
                                            Детали кузова
                                        </span>
                                    </a>
                                    <a class="tar_cat tar_cat_first" href="#">
                                        <img src="images/tar_img_5.jpg">
                                        <span>
                                            Система<br>подвески
                                        </span>
                                    </a>
                                    <a class="tar_cat" href="#">
                                        <img src="images/tar_img_6.jpg">
                                        <span>
                                            Топливная<br>система
                                        </span>
                                    </a>
                                    <a class="tar_cat tar_cat_first" href="#">
                                        <img src="images/tar_img_7.jpg">
                                        <span>
                                            Тормозная<br>система
                                        </span>
                                    </a>
                                    <a class="tar_cat" href="#">
                                        <img src="images/tar_img_8.jpg">
                                        <span>
                                            Ходовая<br>система
                                        </span>
                                    </a>
                                    <div class="pad"></div>
                                </div>
                                <div class="pad"></div>
                            </div>
                            <div class="tar_category">
                                <div class="tar_badge">
                                    <img src="images/tar_category.png">
                                </div>
                                <a class="tar_cat tar_cat_first" href="#">
                                    <img src="images/tar_img_1.jpg">
                                    <span>
                                        Гидравлическая<br>система
                                    </span>
                                </a>
                                <a class="tar_cat" href="#">
                                    <img src="images/tar_img_2.jpg">
                                    <span>
                                        Система<br>охлаждения
                                    </span>
                                </a>
                                <a class="tar_cat tar_cat_first" href="#">
                                    <img src="images/tar_img_3.jpg">
                                    <span>
                                        Оптика
                                    </span>
                                </a>
                                <a class="tar_cat" href="#">
                                    <img src="images/tar_img_4.jpg">
                                    <span>
                                        Детали кузова
                                    </span>
                                </a>
                                <a class="tar_cat tar_cat_first" href="#">
                                    <img src="images/tar_img_5.jpg">
                                    <span>
                                        Система<br>подвески
                                    </span>
                                </a>
                                <a class="tar_cat" href="#">
                                    <img src="images/tar_img_6.jpg">
                                    <span>
                                        Топливная<br>система
                                    </span>
                                </a>
                                <a class="tar_cat tar_cat_first" href="#">
                                    <img src="images/tar_img_7.jpg">
                                    <span>
                                        Тормозная<br>система
                                    </span>
                                </a>
                                <a class="tar_cat" href="#">
                                    <img src="images/tar_img_8.jpg">
                                    <span>
                                        Ходовая<br>система
                                    </span>
                                </a>
                                <div class="pad"></div>
                            </div>
                            <!--div class="tar_adv">
                                <a class="tar_ad_1" href="#">
                                    <img class="advis_1" src="images/tar_ad_1.jpg">
                                </a>
                                <a class="tar_ad_2" href="#">
                                    <img class="advis_1" src="images/tar_ad_2.jpg">
                                </a>
                            </div-->
                            <div class="tar_catalog_goods">
                                <div class="tar_cat_top_no_ad">
                                    <div class="tar_cat_top_in">
                                        <div class="tar_cat_top_title">
                                            Каталог товаров
                                        </div>
                                        <div class="tar_cat_top_lists">
                                            <ul class="tar_list_1">
                                                <li>
                                                    <a href="#">
                                                        Европа
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Америка
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Корея
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Япония
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul class="tar_list_2">
                                                <li>
                                                    <a href="#">
                                                        Грузовики
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Универсальные
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#">
                                                        Россия
                                                    </a>
                                                </li>
                                                <span class="tar_cat_line"></span>
                                                <li>
                                                    <a href="#">
                                                        Все марки
                                                    </a>
                                                </li>
                                            </ul>
                                            <div class="pad"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tar_cat_bot_no_ad">
                                    <div class="tar_brands_car">
                                        <div class="tar_cat_bot_title">
                                            Марки машин
                                        </div>
                                            <div class="tar_cars">
                                                <div class="tar_cat_bot_form">
                                                    Легковые:
                                                </div>
                                                <div class="tar_cat_bot_lists">
                                                    <ul>
                                                        <li>
                                                            <a href="#">Alfa Romeo</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Cadillac</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Citroen</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Dodge</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">GAZ</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Infiniti</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Lexus</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Mitsubishi</a>
                                                        </li>
                                                    </ul>
                                                    <ul>
                                                        <li>
                                                            <a href="#">Audi</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Chevrolet</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Daewoo</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Fiat</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Honda</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Jeep</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Mazda</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Moskvich</a>
                                                        </li>
                                                    </ul>
                                                    <ul>
                                                        <li>
                                                            <a href="#">BMW</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Chrysler</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Diahatsu</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Ford</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Hyundai</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">KIA</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Mersedes</a>
                                                        </li>
                                                        <li>
                                                            <a href="#">Nissan</a>
                                                        </li>
                                                    </ul>
                                                    <div  class="tar_two_last">
                                                        <ul>
                                                                <li>
                                                                    <a href="#">Opel</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Porche</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Saab</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Subaru</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">VAZ</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Лампы</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Moskvich</a>
                                                                </li>
                                                            </ul>
                                                        <ul>
                                                                <li>
                                                                    <a href="#">Peugeot</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Range Rover</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Skoda</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Suzuki</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Volkswagen</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Оптика</a>
                                                                </li>
                                                                <li>
                                                                    <a href="#">Nissan</a>
                                                                </li>
                                                            </ul>
                                                        <div class="pad"></div>
                                                    </div>
                                                    <div class="pad"></div>
                                                </div>
                                                <div class="pad"></div>
                                            </div>
                                            <div class="tar_freight">
                                            <div class="tar_cat_bot_form">
                                                Грузовые:
                                            </div>
                                            <div class="tar_cat_bot_lists">
                                                <ul>
                                                    <li>
                                                        <a href="#">DAF</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">MAN</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Renault</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Volvo</a>
                                                    </li>
                                                </ul>
                                                <ul>
                                                    <li>
                                                        <a href="#">Isuzu</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Mersedes-Benz</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Scania</a>
                                                    </li>
                                                </ul>
                                                <ul>
                                                    <li>
                                                        <a href="#">Iveco</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Nissan</a>
                                                    </li>
                                                    <li>
                                                        <a href="#">Toyota</a>
                                                    </li>
                                                </ul>
                                            </div>
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
                                    Лидеры продаж
                                </div>
                                <div class="tar_sell_cont_no_ad"> 
                                    <div class="tar_first_sells">
                                        <div class="tar_first_sell">
                                            <div class="tar_sell_part tar_sell_part_1">
                                                <a class="tar_part" href="#">
                                                    <img src="images/tar_no_photo.jpg">
                                                </a>
                                                <div class="tar_sell_part_name">
                                                    Название запчасти если оно длинное
                                                </div>
                                                <a class="tar_price" href="#">
                                                    <span>500.00</span>руб
                                                </a>
                                            </div>
                                            <div class="tar_two_sells">
                                                <div class="tar_sell_part">
                                                    <a class="tar_part" href="#">
                                                        <img src="images/tar_no_photo.jpg">
                                                    </a>
                                                    <div class="tar_sell_part_name">
                                                        Название запчасти если оно длинное
                                                    </div>
                                                    <a class="tar_price" href="#">
                                                        <span>500.00</span>руб
                                                    </a>
                                                </div>
                                                <div class="tar_sell_part">
                                                    <a class="tar_part" href="#">
                                                        <img src="images/tar_no_photo.jpg">
                                                    </a>
                                                    <div class="tar_sell_part_name">
                                                        Название запчасти если оно длинное
                                                    </div>
                                                    <a class="tar_price" href="#">
                                                        <span>500.00</span>руб
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
                                                    <img src="images/tar_no_photo.jpg">
                                                </a>
                                                <div class="tar_sell_part_name">
                                                    Название запчасти если оно длинное
                                                </div>
                                                <a class="tar_price" href="#">
                                                    <span>500.00</span>руб
                                                </a>
                                            </div>
                                            <div class="tar_sell_part">
                                                <a class="tar_part" href="#">
                                                    <img src="images/tar_no_photo.jpg">
                                                </a>
                                                <div class="tar_sell_part_name">
                                                    Название запчасти если оно длинное
                                                </div>
                                                <a class="tar_price" href="#">
                                                    <span>500.00</span>руб
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
                        Авторские новости
                    </div>
                    <div class="tar_news_cont">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="tar_first_news">
                                        <div class="tar_first_new">
                                            <div class="tar_news_part tar_news_part_1">
                                                <a class="tar_new_img" href="#">
                                                    <img src="images/tar_car_1.jpg">
                                                </a>
                                                <div class="tar_new_title">
                                                    <a href="#">
                                                        Пример названия новости если оно длинное
                                                    </a>
                                                </div>
                                                <div class="tar_news_text">
                                                    В течение всего дня свыше 50
                                                    команд интеллектуалов выяснят<br>
                                                    кто из них умнее на 48 вопросах<br>
                                                    “Что Где Когда”
                                                </div>
                                            </div>
                                            <div class="tar_two_news">
                                                <div class="tar_news_part">
                                                    <a class="tar_new_img" href="#">
                                                        <img src="images/tar_car_2.jpg">
                                                    </a>
                                                    <div class="tar_new_title">
                                                        <a href="#">
                                                            Пример названия новости если оно длинное
                                                        </a>
                                                    </div>
                                                    <div class="tar_news_text">
                                                        В течение всего дня свыше 50
                                                        команд интеллектуалов выяснят<br>
                                                        кто из них умнее на 48 вопросах<br>
                                                        “Что Где Когда”
                                                    </div>
                                                </div>
                                                <div class="tar_news_part">
                                                    <a class="tar_new_img" href="#">
                                                        <img src="images/tar_car_1.jpg">
                                                    </a>
                                                    <div class="tar_new_title">
                                                        <a href="#">
                                                            Пример названия новости если оно длинное
                                                        </a>
                                                    </div>
                                                    <div class="tar_news_text">
                                                        В течение всего дня свыше 50
                                                        команд интеллектуалов выяснят<br>
                                                        кто из них умнее на 48 вопросах<br>
                                                        “Что Где Когда”
                                                    </div>
                                                </div>
                                                <div class="pad"></div>
                                            </div>
                                            <div class="pad"></div>
                                        </div>
                                    </div>
                                    <div class="tar_last_news">
                                        <div class="tar_last_new">
                                            <div class="tar_news_part">
                                                <a class="tar_new_img" href="#">
                                                    <img src="images/tar_car_2.jpg">
                                                </a>
                                                <div class="tar_new_title">
                                                    <a href="#">
                                                        Пример названия новости если оно длинное
                                                    </a>
                                                </div>
                                                <div class="tar_news_text">
                                                    В течение всего дня свыше 50
                                                    команд интеллектуалов выяснят<br>
                                                    кто из них умнее на 48 вопросах<br>
                                                    “Что Где Когда”
                                                </div>
                                            </div>
                                            <div class="tar_news_part">
                                                <a class="tar_new_img" href="#">
                                                    <img src="images/tar_car_1.jpg">
                                                </a>
                                                <div class="tar_new_title">
                                                    <a href="#">
                                                        Пример названия новости если оно длинное
                                                    </a>
                                                </div>
                                                <div class="tar_news_text">
                                                    В течение всего дня свыше 50
                                                    команд интеллектуалов выяснят<br>
                                                    кто из них умнее на 48 вопросах<br>
                                                    “Что Где Когда”
                                                </div>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="tar_ad_part">
                                    <a class="tar_ad_img" href="#">
                                        <img src="images/tar_ad_img_1.jpg">
                                    </a>
                                    <div class="pad"></div>
                                </div>
                            </div>
                            <div class="col-md-4 tar_last_ad_1">
                                <div class="tar_ad_part">
                                    <a class="tar_ad_img" href="#">
                                        <img src="images/tar_ad_img_2.jpg">
                                    </a>
                                    <div class="pad"></div>
                                </div>
                            </div>
                            <div class="col-md-4 tar_last_ad">
                                <div class="tar_ad_part">
                                    <a class="tar_ad_img" href="#">
                                        <img src="images/tar_ad_img_3.jpg">
                                    </a>
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
					// added for no ad
					 $('.tar_cat_top_no_ad, .tar_cat_bot_no_ad').animate({marginLeft:'250', width:'885px'},50);
                }else{
                    $('.tar_cat_invis').animate({width:'0', height:'0'},50);
                    $('.tar_cat_top').animate({marginLeft:'0', width:'885px'},50);
					$('.tar_cat_bot').animate({marginLeft:'0', width:'885px'},50);
                    $('.tar_category_vis').animate({width:'0'},50);
                    $('.tar_badge_vis').animate({right:'-30px'},50);
					// added for no ad    
					$('.tar_cat_top_no_ad, .tar_cat_bot_no_ad').animate({marginLeft:'0', width:'1135px'},50);
                    
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
				// added for no ad    
					$('.tar_cat_top_no_ad, .tar_cat_bot_no_ad').animate({marginLeft:'250', width:'693px'},50);                    
                }else{
                    $('.tar_cat_invis').animate({width:'0', height:'0'},50);
                    $('.tar_cat_top').animate({marginLeft:'0', width:'693px'},50);
                    $('.tar_cat_bot').animate({marginLeft:'0', width:'693px'},50);
                    $('.tar_category_vis').animate({width:'0'},50);
                    $('.tar_badge_vis').animate({right:'-30px'},50);
					$('.tar_cat_top_no_ad, .tar_cat_bot_no_ad').animate({marginLeft:'0', width:'943px'},50);
                }
            });
        });
    };
</script>

</body>
</html>