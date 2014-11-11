<h2>Чекбоксы и textField  </h2>

<h5><!--em>Since version 1.1.2, a special option named 'uncheckValue' is available that can be used to specify the value returned when the checkbox is not checked. When set, a hidden field is rendered so that when the checkbox is not checked, we can still obtain the posted uncheck value. If 'uncheckValue' is not set or set to NULL, the hidden field will not be rendered. </em-->Box 1 - сохраняет своё состояние при посылке запроса (принимая значение из входного парамeтра массива POST)</h5>
<h5><!--em>Since version 1.1.2, a special option named 'uncheckValue' is available that can be used to specify the value returned when the checkbox is not checked. When set, a hidden field is rendered so that when the checkbox is not checked, we can still obtain the posted uncheck value. If 'uncheckValue' is not set or set to NULL, the hidden field will not be rendered. </em-->Box 2 - имеет <a href='http://www.yiiframework.com/doc/api/1.1/CHtml#checkBox-detail'>скрытое поле</a> чтобы отследить его величину (значение) в POST запросе.</h5>
<?php
echo CHtml::form();
echo CHtml::checkBox('box1', CHtml::encode($_POST['box1']) ); 
echo CHtml::label('Box 1', 'box1');
?>
<br>
Здесь (для <b>box1</b>) мы поставили значение (<a href='http://www.yiiframework.com/doc/api/1.1/CHtml#checkBox-detail'>whether the check box is checked</a>) этого чекбокса из предыдущего POST запроса <b>CHtml::encode($_POST['box1'])</b> - второй параметр, который принимает начальное значение. То же самое применимо к textField, второй параметр: <b>CHtml::encode($_POST['simpleField'])</b>. 
<br> 
	Теперь в зависимости от величины $_POST['box1'] этот чекбокс будет сохранять (при выводе принимать) своё посылаемое значение.
<hr><br>
<?echo CHtml::checkBox('box2' , false , array('uncheckValue'=>0));  echo CHtml::label('Box 2 со скрытым полем за ним (скрытый чекбокс)', 'box2');

?><br>
Когда box2 не отмечен, будет посылаться величина <b>$_POST['box2'] = 0</b> благодаря скрытому чекбоксу с тем же именем, который определяется третьим параметром: <b>array('uncheckValue'=>0)</b>. Для box1 - ничего не будет выдаваться в POST запросе если он не отмечен.
<br>
Когда box2 отмечен, будут посылаться в одном POST запросе последовательно две величины <b>$_POST['box2'] = 0</b> и <b>$_POST['box2'] = 1</b> (см. F12->Network). В принципе последняя <b>$_POST['box2'] = 1</b> будет перекрывать первую (с нулём). Поэтому внизу ниже формы я поставил вывод содержимого этого запроса для box2.
<hr> 
Simple Field 
<?php echo CHtml::textField('simpleField'  , CHtml::encode($_POST['simpleField']) ); ?>
<br>
<? 
echo CHtml::submitButton('Submit');
echo CHtml::endForm();
echo '<br>$_POST[box2] = ',  CHtml::encode($_POST['box2']); 
?>
<h5>КОД ПРИМЕРА</h5>
<pre>
echo CHtml::form();
echo CHtml::checkBox('box1', CHtml::encode($_POST['box1']) ); 
echo CHtml::label('Box 1', 'box1');

echo CHtml::checkBox('box2' , false , array('uncheckValue'=>0));  
echo CHtml::label('Box 2 со скрытым полем за ним (скрытый чекбокс)', 'box2');

echo CHtml::submitButton('Submit');
echo CHtml::endForm();
echo '$_POST[box2] = ',  CHtml::encode($_POST['box2']); 

echo 'Simple Field',  CHtml::textField('simpleField'  , CHtml::encode($_POST['simpleField']) );
</pre>