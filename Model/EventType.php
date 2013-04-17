<?php
/*
 * Model/EventType.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */
 
class EventType extends FullCalendarAppModel {
<<<<<<< HEAD
	
	public $name = 'EventType';
	public $displayField = 'name';
	public $actsAs = array('Containable');

	public $validate = array(
=======
	var $name = 'EventType';
	var $displayField = 'name';
	var $validate = array(
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
			),
		),
	);

<<<<<<< HEAD
	public $hasMany = array(
=======
	var $hasMany = array(
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99
		'Event' => array(
			'className' => 'FullCalendar.Event',
			'foreignKey' => 'event_type_id',
			'dependent' => false,
		)
	);

}
?>
