<?php
class FindByOEM extends CWidget
{ 
    public $hint = false;
	public function run()
    {   
        echo CHtml::form(array('assortment/index'), 'get'); ?>
			<div class="findbyoem">    
				<?php 
					$model = new Assortment;
					//echo Yii::t('general','Find a spare part by OEM:'); 
					//echo CHtml::activeTextField($model, 'oem');
					$value =  isset($_GET['findbyoem-value']) ? $_GET['findbyoem-value'] : '';
					$value =  ($value=='' && isset($_GET['findbyoemvalue']) ) ? $_GET['findbyoemvalue'] : '';
					echo CHtml::textField('findbyoem-value', $value);  //findbyoem-value
					if ($this->hint) 
						echo '<div style="position:relative;"><div style="position:absolute;font-size:1.2em;float:left;color:black;left:10;top:10;">', Yii::t('general', 'Enter OEM number, Article or part title, ex ') , '<em>712384301129, фара</em>' , /*' ',  Yii::t('general', 'or'), ' '   ,'<em>BM1010930-0R00</em>', */'</div></div>';
						?>
						<div class='input'> 
							<button href="#" class="classname"><span style="font: 1.2em bold;" ><?php echo Yii::t('general','SEARCH'); ?></span></button>
						</div>
						<?php
				//	echo '<center>', CHtml::submitButton(Yii::t('general','Search'), array('submit' =>Yii::app()->createUrl('assortment/index'), 'name'=>'search-btn', 'class'=>'classname')), '</center>';	
					/*echo CHtml::dropDownList('_lang', $currentLang, array(
						'en_us' => 'English', 'ru'=> 'Русский'), array('submit' => '')); */
				?>
			</div>
		<?php echo CHtml::endForm();
	}
}
?>