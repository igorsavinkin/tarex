<?php 
$number= 20;
$start= 0;
$url = "https://www.googleapis.com/customsearch/v1element?key=AIzaSyCVAXiUzRYsML1Pv6RwSG1gunmMikTzQqY&rsz=filtered_cse&num={$number}&start={$start}&hl=en&prettyPrint=false&source=gcsc&gss=.com&sig=28ae2b20598e87432c64a154583c2fc6&cx=011658049436509675749:mpshzk7cxw8&q=scott%20more%3Ausa&sort=&googlehost=www.google.com&oq=scott&gs_l=partner.12...0.0.1.16910.0.0.0.0.0.0.0.0..0.0.gsnos%2Cn%3D13...0.0..1ac..25.partner..0.5.94.Wzma1JLr3Cw&callback=google.search.Search.apiary8033&nocache=1495914440316"; 

$page = file_get_contents($url); 
$page = substr($page, 48); 
$page =  substr($page, 0, -2);  

//echo 'strlen = ',strlen($page), '<br>'; 
echo '<pre>', $page, '</pre>'; 

//echo '<pre>', json_encode($page, JSON_PRETTY_PRINT), '</pre>';
?>