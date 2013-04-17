<?php
/*
 * Model/Event.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */
 
class Event extends FullCalendarAppModel {
	
	public $name = 'Event';
	public $displayField = 'title';
	public $actsAs = array('Containable','Search.Searchable');
	
	public $virtualFields = array(
		'day' => "DAY(Event.start)",
    	'month' => "MONTH(Event.start)",
    	'year' => "YEAR(Event.start)"
	);

	public $validate = array(
		'title' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter the name of the event.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				'on' => 'create' // Limit validation to 'create' or 'update' operations
			),
		),
		'city' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter a city for the event.',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create' // Limit validation to 'create' or 'update' operations
			),
		),
		/*'state_region_id' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter a state/region for the event.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				'on' => 'create' // Limit validation to 'create' or 'update' operations
			),
		),*/
		'start' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter a start time for the event.',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				'on' => 'create' // Limit validation to 'create' or 'update' operations
			),
		),
		'contact_name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter a contact for the event.',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create' // Limit validation to 'create' or 'update' operations
			),
		),
		'contact_email' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'You must enter the event coordinator\'s email address.',
				'allowEmpty' => true,
				'required' => false,
				//'last' => false, // Stop validation after this rule
				'on' => 'create' // Limit validation to 'create' or 'update' operations
			),
		)
	);

	public $hasMany = array(
		'EventAttendee' => array(
			'className' => 'EventAttendee',
			'foreignKey' => 'event_id',
			'dependent' => true,
		),
		'CheeseCheckin' => array(
			'className' => 'CheeseCheckin',
			'foreignKey' => 'event_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => array('CheeseCheckin.created' => 'DESC')
		)
	);

	public $belongsTo = array(
		'EventType' => array(
			'className' => 'FullCalendar.EventType',
			'foreignKey' => 'event_type_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Country' => array(
			'className' => 'Country',
			'foreignKey' => 'country_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'StateRegion' => array(
			'className' => 'StateRegion',
			'foreignKey' => 'state_region_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Place' => array(
			'className' => 'Place',
			'foreignKey' => 'place_id',
			'counterCache' => 'place_review_count',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'counterCache' => true,
			'fields' => '',
			'order' => ''
		),
		'ShortUrl' => array(
			'className' => 'ShortUrl',
			'foreignKey' => 'short_url_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * Handles returning all of the cities that have events associated with them
	 * @param string $findType The type of find (list, all, first, etc)
	 * @return array The cities associated with events
	 */
	public function getCities($findType = 'list'){
		return $this->find($findType,array(
				'conditions' => array(
					'Event.active' => 1
				),
				'fields' => array('Event.city','Event.city'),
				'group' => array('Event.city')
			));
	}

	/**
	 * Approves and makes it visible to the public
	 * @param bool active Whether or not it should be active or not
	 * @param int id The id of the item to approve or unapprove
	 * @param int place_ic The place id of the item to approve or unapprove
	 * @return bool success
	 */
	public function approve($active=true,$id = null,$place_id = null) {
		if(!empty($id)){
			$item = $this->read(null,$id);
			$this->id = $item['Event']['id'];
			$this->saveField('active',$active);

			//Update the total places event, if associated with a place
			if(!empty($place_id)){
				$this->Event->Place->updateEventTotals();
			}

		}else{
			return $this->saveField('active',$active);
		}
	}

	/** 
	* Checks to see if the event is active or not.
	* @param int $model_id The event
	* @return bool Whether or not the event is active.
	*/
	public function isActive($model_id){
		$item = $this->read(null,$model_id);
		if($item['Event']['active'] == 1){
			return true;
		}else{
			return false;
		}
	}

	/**
	 * This method handles saving the geocode data
	 * @param int $model_id The place id
	 * @param array The geocode result
	 * @return bool whether or not the save was a success
	 */
	public function saveGeoCodeData($model_id,$result){
		$this->id = $model_id;
		if(!empty($result)){
			$this->set(array(
				'lat' => $result['latitude'],
				'lng' => $result['longitude'],
				'googleaddress' => $result['googleaddress']
			));
			if($this->save($this->data,false)){
				return true;
			}else{
				return false;
			}
		}else{
			return false;
		}
	}

}
?>
