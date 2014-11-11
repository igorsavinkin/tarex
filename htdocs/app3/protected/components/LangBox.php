<?php
class LangBox extends CWidget
{
    public function run()
    {
        $currentLang = Yii::app()->language; 
		$login = (Yii::app()->user->isGuest) ? '' : '_login'; 
		//echo '$login = ', $login;
		?>
		<div class="tar_lang_all<?php echo $login; ?>">
			<div class="tar_lang">
				<div class="tar_rus_eng">
					<a href="#"> 
						<img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_rus.jpg">
					</a>
					<a href="#">
						<img src="<?php echo Yii::app()->baseUrl; ?>/images/tar_eng.jpg">
					</a>
				</div><!-- flags -->
				 <?php  echo CHtml::form(); ?>
						<p class="simply"></p><p class="tar_border_lang"></p>	
						<?php echo CHtml::dropDownList('_lang', $currentLang, array(
					'en_us' => 'English' , 'ru'=> 'Русский'), array('submit' => '')); ?>			 
				<?php echo CHtml::endForm(); ?>
				</div><!-- tar_rus_eng -->
			</div>
		</div><!-- tar_lang_all -->
	<?	
	
	}
}
?>