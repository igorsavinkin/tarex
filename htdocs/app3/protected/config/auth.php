<?php

return array(
    // администратор, владельцы сервиса
    '1' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Админ',
        'children' => array(
            '2',         // позволим админу всё, что позволено директору (менеждеру)
        ),
        'bizRule' => null,
        'data' => null
    ),
	// director
    '2' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Директор',
        'children' => array(
            '3', '4'         // позволим директору всё что позволено старшему менеждеру и бухгалтеру 
        ),
        'bizRule' => null,
        'data' => null
    ),
	// Бухгалтер
    '3' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Бухгалтер',
        'children' => array(
            //'3',          // никаких прав не имеет от других
        ),
        'bizRule' => null,
        'data' => null
    ),
	// Старший менеджер
    '4' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Старший менеджер',
        'children' => array(
            '5'       // позволим старшему менеждеру всё что позволено менеждеру 
        ),
        'bizRule' => null,
        'data' => null
    ),
	// Менеджер
    '5' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Менеджер',
        'children' => array(
            '6'       // позволим  менеждеру всё что позволено пользователю 
        ),
        'bizRule' => null,
        'data' => null
    ),	
	// Клиент (оптовый)
    '6' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Клиент',
        'children' => array(
            '7',  // позволим оптовому клиенту всё что позволено розничному клиенту 
        ),
        'bizRule' => null,
        'data' => null
    ),
	// Розничный клиент
    '7' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Розничный клиент',
        'children' => array(
            'guest', // унаследуемся от гостя
        ),
        'bizRule' => null,
        'data' => null
    ),
	'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Guest',
        'bizRule' => null,
        'data' => null
    ),	
);
?>