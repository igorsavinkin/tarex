<?php
class Cart extends CWidget
{
    public function run()
    {
		//echo 'Cart';
		if (Yii::app()->shoppingCart->getCount())
			{
				// есть какие-то заказы пользователя
				//новые (ещё не подтверждённые) заказы этого пользователя
				$cartimg = 'basket_green.png';  
			}
		else 
			{// нет заказов пользователя
			// нет новых (ещё не подтверждённых) заказов этого пользователя
				$cartimg =  'basket_darkblue.png'; 
			}
		
		$cartContent = '<b>' . Yii::t('general', 'BASKET') . '</b><hr />' . Yii::app()->shoppingCart->getItemsCount() .' ' . Yii::t('general', 'item(s)');
		$cost =/* ' -- ' .*/Yii::t('general', 'for') . ' ' . Yii::app()->shoppingCart->getCost() . ' '.  Yii::t('general','RUB');?>
		<div id='cart-content'>
		<?php
		echo CHtml::link('<center><!--img src="'.Yii::app()->baseUrl . '/assets/images/'. $cartimg .' "  width="46px" /><br/--><font size="0.8em" >'. $cartContent .  '<br>' .  $cost . '</font></center>', array('assortment/cart'), array('title'=>Yii::t('general','Cart'), 'style'=>'float:right; margin:5px 5px 0px 5px;padding:0px;'));
		//echo '</br>',CHtml::ajaxLink('<center><font size="0.8em" >' . Yii::t('general', 'Clear Cart') .'</font></center>', array('assortment/clearcart'), array('style'=>'float:right; margin:5px 5px 0px 5px;padding:0px;')); ?>
		</div>
		<?php
	}
}
?>