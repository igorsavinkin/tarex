<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        Mobile1
    </title>   
	<link href="css/mobile.css" rel="stylesheet" type="text/css">
    <link href="css/reset.css" rel="stylesheet" type="text/css">
    <link href="css/order.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/bootstrap-theme.css" rel="stylesheet" type="text/css">
    <link href="css/owl.carousel.css" rel="stylesheet" type="text/css">
    <link href="css/owl.theme.css" rel="stylesheet" type="text/css">
 
    <?php Yii::app()->clientScript->registerCoreScript('jQuery'); ?>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/bootstrap.js"></script>
</head>
<body>
<div class="mob_wrapper">
    <div class="mob_header">
        <div class="mob_header_right">
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
                <div class="tar_lang_all">
                    <div class="tar_choice_city">
                        <?php $this->widget('CityByIP'); ?> 
						<!--form>
                            <p class="simply"></p>
                            <p class="tar_border"></p>
                            <p class="tar_location"></p>
                            <select class="ch_city">
                                <option>Новгородская обл.</option>
                                <option>Новгородская обл.</option>
                            </select>
                        </form-->
                    </div>
                    <div class="tar_change_city">
                        <?php echo Yii::t('general','Change city'); ?>
                    </div>
                    <div class="pad"></div>
                </div>
            </div>
        </div>
        <div class="mob_header_left">
            <div class="tar_top_logo">
                <a href="<?php echo Yii::app()->createUrl('/site/index'); ?>">
                    <img src="images/tar_top_logo.png">
                </a>
            </div>
            <div class="mob_contacts">
                <div class="tar_ad">
                    Россия г. Москва,<br>
                    ул. Складочная д. 1, стр. 10
                </div>
                <div class="tar_phone">
                    <span class="s_one">+7 (495) </span><span class="s_two">785-88-50 </span><span class="tar_red_span">(многоканальный) info@tarex.ru</span>
                </div>
            </div>
        </div>
        <div class="pad"></div>
    </div>
    <div class="mob_redline">
        <div class="mob_search">
            <?php echo CHtml::form(array('assortment/index'), 'get'); ?>
			<input type="submit" class="mob_form_submit" value="<?php echo Yii::t('general' , 'Search'); ?>" >
			<?php $value =  isset($_GET['findbyoem-value']) ? $_GET['findbyoem-value'] : '';
				$value =  ($value=='' && isset($_GET['findbyoemvalue']) ) ? $_GET['findbyoemvalue'] : '';
				echo CHtml::textField('findbyoem-value', $value, array('placeholder'=> Yii::t('general', 'OEM, Article or part name'), 'class'=>'mob_form_text') ); ?>
				
			 <?php echo CHtml::endForm(); ?>
			<!--form>
                <input type="submit" class="mob_form_submit" value="Поиск">
                <input type="text" class="mob_form_text">
            </form-->
        </div>
    </div>
    <div class="mob_cartblock">
        <div class="mob_vip">
            <a href="#">
                <img src="images/tar_vip.png">
            </a>
        </div>
        <div class="mob_catalog">
            <a href="#">
                <img src="images/tar_catalog.png">
            </a>
        </div>
        <div class="mob_basket">
            <a href="#">
                <img src="images/tar_basket.png">
            </a>
        </div>
    </div>
    <div class="mob_pageblock">
        <div class="tar_category_vis">
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
        <div class="mob_cat_block">
            <div class="mob_cat_inblock">
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
                </div>
            </div>
        </div>
        <div class="pad"></div>

        <div class="mob_cars">
            <div class="tar_cat_bot_title">
                Марки машин
            </div>
            <div class="mob_cars_block">
                <div class="mob_cars_title">
                    Легковые:
                </div>
                <div class="mob_cars_body">
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
                    <div class="pad"></div>
                </div>
                <div class="pad"></div>
            </div>
            <div class="mob_cars_block">
                <div class="mob_cars_title">
                    Грузовые:
                </div>
                <div class="mob_cars_body">
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
                    <div class="pad"></div>
                </div>
            </div>
        </div>
        <div class="mob_leaders">
            <div class="mob_leaders_title">
                Лидеры продаж
            </div>
            <div class="mob_leaders_body">
                <div id="owl-demo-mob" class="owl-carousel">
                    <div class="item">
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
                    </div>
                    <div class="item">
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
                    </div>
                    <div class="item">
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
                    </div>
                    <div class="item">
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
                    </div>
                </div>
            </div>
        </div>
        <div class="mob_leaders">
            <div class="mob_leaders_title">
                Авторские новости
            </div>
            <div class="mob_leaders_body">
                <div id="owl-demo-mob1" class="owl-carousel">
                    <div class="item">
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
                    </div>
                    <div class="item">
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
                    </div>
                    <div class="item">
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
                    </div>
                    <div class="item">
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
                    </div>
                </div>
            </div>
        </div>
    <div class="pad"></div>
    </div>
    <footer class="mob_footer">
        <div class="mob_foo_pic">
            <a href="#">
                <img src="images/tar_bot_logo.png">
            </a>
        </div>
        <div class="mob_foo_soc">
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
        </div>
        <div class="tar_copy">Копирайт сайта 2014</div>
    </footer>
</div>
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
        $("#owl-demo-mob").owlCarousel({
            navigation : true, // Show next and prev buttons
            slideSpeed : 300,
            paginationSpeed : 400,
            autoPlay: 5000,
            items : 2,
            lazyLoad : true
            // "singleItem:true" is a shortcut for:
            // items : 1,
            // itemsDesktop : false,
            // itemsDesktopSmall : false,
            // itemsTablet: false,
            // itemsMobile : false
        });
        $("#owl-demo-mob1").owlCarousel({
            navigation : true, // Show next and prev buttons
            slideSpeed : 300,
            paginationSpeed : 400,
            autoPlay: 4000,
            items : 2,
            lazyLoad : true
            // "singleItem:true" is a shortcut for:
            // items : 1,
            // itemsDesktop : false,
            // itemsDesktopSmall : false,
            // itemsTablet: false,
            // itemsMobile : false
        });
    });
</script>
</body>
</html>