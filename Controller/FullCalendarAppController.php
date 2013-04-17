<?php
/*
 * Controller/FullCalendarAppController.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */

class FullCalendarAppController extends AppController {

<<<<<<< HEAD
//	public $components = array('Acl', 'Session');
	public $components = array(
		'Session',
		'FilterResults.FilterResults' => array(
				'auto' => array(
								'paginate' => false,
								'explode'  => true,  // recommended
							),
							'explode' => array(
								'character'   => ' ',
								'concatenate' => 'AND',
							)
						)
					);

	public $helpers = array(
		'Html', 'Form', 'Session',
		'FilterResults.FilterForm' => array(
						'operators' => array(
								'LIKE'       => 'containing',
								'NOT LIKE'   => 'not containing',
								'LIKE BEGIN' => 'starting with',
								'LIKE END'   => 'ending with',
								'='  => 'equal to',
								'!=' => 'different',
								'>'  => 'greater than',
								'>=' => 'greater or equal to',
								'<'  => 'less than',
								'<=' => 'less or equal to'
						)
					)
				);

	public $cacheAction = array(
		'add/*' => '+1 day',
    	'view/*' => '+1 hour',
    	'index/*'  => false
	);

=======
//	var $components = array('Acl', 'Session');
	var $components = array('Session');
	var $helpers = array('Html', 'Form', 'Session', 'Js'=>array('Jquery'));
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99

}
?>
