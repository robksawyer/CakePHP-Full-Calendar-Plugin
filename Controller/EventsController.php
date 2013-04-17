<?php
/*
 * Controller/EventsController.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */

class EventsController extends FullCalendarAppController {

<<<<<<< HEAD
	public $name = 'Events';
	
	public $helpers = array('Tools.Datetime','Attachment','Tools.GoogleMapV3');
	
	public $components = array('Location');

	public $paginate = array(
		'limit' => 15
	);


	/**
	 * This method handles displaying all events for a certain day of the month
	 * @param string $year The year
	 * @param string $month The month
	 * @param string $day The day of the month
	 */
	public function index($year='',$month='',$day=null) {
		if(empty($year)) $year = date('Y');
		if(empty($month)) $month = date('m');
		//if(empty($day)) $day = date('d');

		//Make sure they have leading zeros, otherwise the search fails
		if(!empty($day)){
			$day = str_pad($day, 2, 0, STR_PAD_LEFT);
		}
		if(!empty($month)){
			$month = str_pad($month, 2, 0, STR_PAD_LEFT);
		}
		$this->Event->recursive = 1;
		
		$this->Event->contain(array('Country','EventType','Place','User','StateRegion'));
		if(!empty($day)){
			$default_conditions = array(
				'Event.start LIKE' => strval($year."-".$month.'-'.$day).'%',
				'Event.active' => 1
			);
		}else{
			$default_conditions = array(
				'Event.month =' => $month,
				'Event.active' => 1
			);
		}

		// Add filter
		$this->FilterResults->addFilters(
			array(
				'city' => array(
					'Event.city' => array(
						'operator' => 'LIKE',
						'value' => array(
							'before' => '%', // optional
							'after'  => '%'  // optional
						)
					)
				),
				'state_region' => array(
					'Event.state_region_id' => array(
						'operator' => '=',
						'explode' => false
					)
				),
				'country' => array(
					'Event.country_id' => array(
						'operator' => '=',
						'explode' => false
					)
				),
				'event_type' => array(
					'Event.event_type_id' => array(
						'operator' => '=',
						'explode' => false
					)
				)
			)
		);

		$this->FilterResults->setPaginate('order', 'Event.start ASC'); // optional
		$this->FilterResults->setPaginate('limit', 10); // optional

		// Define conditions
		$conditions = $this->FilterResults->getConditions();
		$conditions = array_merge($conditions,$default_conditions);
		$this->FilterResults->setPaginate('conditions', $conditions);
		//
		//Find all of the events in the month
		$this->Event->recursive = 0;
		$monthEvents = $this->Event->find('all',array(
				'conditions'=>array(
					'Event.month =' => ltrim($month,'0'), //Note: Event.month is a virtual field
					'Event.active' => 1
				)
			));

		if(!empty($day)){
			$niceDate = date('l F jS, Y',strtotime($year.'-'.$month.'-'.$day));
		}else{
			$niceDate = date('F, Y',strtotime($year.'-'.$month));
		}
		
		$cities = $this->Event->getCities('list');
		//Add States Here
		$stateRegions = $this->Event->StateRegion->find('list');
		$countries = $this->Event->Country->find('list');
		$eventTypes = $this->Event->EventType->find('list');
		$this->set(compact('niceDate','cities','stateRegions','eventTypes','countries','year','month','day','monthEvents'));
		$this->set('events', $this->paginate());
	}


	/**
	 * This method handles displaying all events for a certain day of the month
	 * @param string $place_id The place id
	 * @param string $year The year
	 * @param string $month The month
	 * @param string $day The day of the month
	 */
	public function place($place_id,$year='',$month='',$day=null) {
		$this->Event->Place->id = $place_id;
		if (!$this->Event->Place->exists()) {
			throw new NotFoundException(__('Invalid place'));
		}

		if(empty($year)) $year = date('Y');
		if(empty($month)) $month = date('m');
		//if(empty($day)) $day = date('d');

		//Make sure they have leading zeros, otherwise the search fails
		if(!empty($day)){
			$day = str_pad($day, 2, 0, STR_PAD_LEFT);
		}
		if(!empty($month)){
			$month = str_pad($month, 2, 0, STR_PAD_LEFT);
		}
		
		$this->Event->recursive = 1;
		
		$this->Event->contain(array('Country','EventType','Place','User','StateRegion'));
		if(!empty($day)){
			$default_conditions = array(
				'Event.start LIKE' => '%'.strval($year."-".$month.'-'.$day).'%',
				'Event.place_id' => $place_id,
				'Event.active' => 1
			);
		}else{
			$default_conditions = array(
				'Event.month' => $month,
				'Event.place_id' => $place_id,
				'Event.active' => 1
			);
		}

		// Add filter
		$this->FilterResults->addFilters(
			array(
				'city' => array(
					'Event.city' => array(
						'operator' => 'LIKE',
						'value' => array(
							'before' => '%', // optional
							'after'  => '%'  // optional
						)
					)
				),
				'state_region' => array(
					'Event.state_region_id' => array(
						'operator' => '=',
						'explode' => false
					)
				),
				'country' => array(
					'Event.country_id' => array(
						'operator' => '=',
						'explode' => false
					)
				),
				'event_type' => array(
					'Event.event_type_id' => array(
						'operator' => '=',
						'explode' => false
					)
				)
			)
		);

		$this->FilterResults->setPaginate('order', 'Event.start ASC'); // optional
		$this->FilterResults->setPaginate('limit', 10); // optional

		// Define conditions
		$conditions = $this->FilterResults->getConditions();
		$conditions = array_merge($conditions,$default_conditions);
		$this->FilterResults->setPaginate('conditions', $conditions);
		//
		//Find all of the events in the month
		$this->Event->recursive = 0;
		$monthEvents = $this->Event->find('all',array(
				'conditions'=>array(
					'Event.month' => ltrim($month,'0'), //Note: Event.month is a virtual field
					'Event.place_id' => $place_id
				)
			));

		if(!empty($day)){
			$niceDate = date('l F jS, Y',strtotime($year.'-'.$month.'-'.$day));
		}else{
			$niceDate = date('F, Y',strtotime($year.'-'.$month));
		}
		
		$cities = $this->Event->getCities('list');
		//Add States Here
		$stateRegions = $this->Event->StateRegion->find('list');
		$countries = $this->Event->Country->find('list');
		$eventTypes = $this->Event->EventType->find('list');
		$place = $this->Event->Place->read(null,$place_id);
		$this->set(compact('place','niceDate','cities','stateRegions','eventTypes','countries','year','month','day','monthEvents'));
		$this->set('events', $this->paginate());

		$this->render('index');
	}

	/**
	 * 
	 */
	public function admin_index() {
		$this->Event->recursive = 1;
		$this->set('events', $this->paginate());
	}

	/**
	 * This method controls the active event view
	 * @param int id The event id
	 * @return null
	 */
	public function view($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}

		$event = $this->Event->find('first', array(
			'conditions' => array(
				'Event.id' => $id
			),
			'contain' => array(
				'User' => array('fields' => array('id','name','username','profile_image_url','email')),
				'Place' => array(
					'Country' => array('fields' => array('code','name')),
					'StateRegion' => array('fields' => array('code','name')),
					'Attachment' => array('fields' => array('name','path_small','path_med'))
				),'ShortUrl','EventType','EventAttendee'
			)
		));
		if(!$event['Event']['active']){
			$this->redirect(array('action'=>'view_unapproved',$id));
		}
		//Check to see if the place has been geocoded
		if(empty($event['Event']['lat']) || empty($event['Event']['lng']) || empty($event['Event']['googleaddress'])){
			//Get the lat/lng of the event
			$address = $this->Location->buildAddress($event,'Event');
			//debug($address);
			$geoCodedResult = $this->Location->geocodeAddress($address);
			if(!empty($geoCodedResult)){
				$success = $this->Event->saveGeoCodeData($event['Event']['id'],$geoCodedResult);
				if($success){
					$event = $this->Event->read(null,$event['Event']['id']);
				}
			}
			//debug($geoCodedResult);
		}

		//Generate a short URL for the view
		if(empty($event['ShortUrl']) || empty($event['ShortUrl']['id'])){
			$baseUrl = Router::url(array('plugin'=>'full_calendar','controller'=>'events','action'=>'view',$id),true);
			$shortUrl = $this->Event->ShortUrl->generateShortUrl($baseUrl,'evt'.$id);
			if(!empty($shortUrl)){
				$this->Event->saveField('short_url_id',$shortUrl['ShortUrl']['id'],false);
				$event = $this->Event->read(null,$id);
			}
		}

		$attendeeStatus = $this->Event->EventAttendee->getUserStatus($this->current_user['id'],$id);
		$isActive = $this->Event->isActive($id);
		$usersAttending = $this->Event->EventAttendee->getUsersForStatus(1,$id);
		$usersPossiblyAttending = $this->Event->EventAttendee->getUsersForStatus(2,$id);
		$this->set(compact('attendeeStatus','isActive','event','usersAttending','usersPossiblyAttending'));
	}

	/**
	 * This method controls the inactive event view
	 * @param int id The event id
	 * @return null
	 */
	public function view_unapproved($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		$this->Event->recursive = 2;
		$this->Event->contain(array(
			'User'=>array('EventAttendee'=>array('conditions'=>array(
					'EventAttendee.user_id' => $this->current_user['id'],
					'EventAttendee.event_id' => $id
				) //This controls the not attending, attending, possibly buttons
			)),
			'EventType','EventAttendee',
			'Place'=>array('Country','StateRegion',
				'Attachment'=>array('conditions'=>array('Attachment.model'=>'Place'))
				)
			),'ShortUrl'
		);

		$event = $this->Event->read(null, $id);

		//Generate a short URL for the view
		if(empty($event['ShortUrl']) || empty($event['ShortUrl']['id'])){
			$baseUrl = Router::url(array('plugin'=>'full_calendar','controller'=>'events','action'=>'view',$id),true);
			$shortUrl = $this->Event->ShortUrl->generateShortUrl($baseUrl,'evt'.$id);
			if(!empty($shortUrl)){
				$this->Event->saveField('short_url_id',$shortUrl['ShortUrl']['id'],false);
				$event = $this->Event->read(null, $id);
			}
		}

		$isActive = $this->Event->isActive($id);
		$usersAttending = $this->Event->EventAttendee->getUsersForStatus(1,$id);
		$usersPossiblyAttending = $this->Event->EventAttendee->getUsersForStatus(2,$id);
		$this->set(compact('isActive','event','usersAttending','usersPossiblyAttending'));
		$this->render('view'); //Render view instead
	}

	/**
	 * The main add method to add an event
	 * @param string place_id The place to add the event to
	 */
	public function add($place_id=null) {
		if(!empty($place_id)){
			$this->Event->Place->id = $place_id;
			if (!$this->Event->Place->exists()) {
				throw new NotFoundException(__('Invalid place'));
			}
		}

		if ($this->request->is('post')) {

			// abort if cancel button was pressed
			if (isset($this->params['data']['cancel'])) {
				$this->Session->setFlash(__('Changes were NOT saved.', true));
				if(!empty($place_id)){
					$this->redirect(array('plugin'=>false,'controller'=>'places','action'=>'view',$place_id));
				}else{
					$this->redirect($this->referer());
				}
			}

			//Add http:// if it doesn't exist.
			if(!empty($this->request->data['Event']['website'])){
				if (preg_match("#https?://#", $this->request->data['Event']['website']) === 0) {
					$this->request->data['Event']['website'] = 'http://'.$this->request->data['Event']['website'];
				}
			}

			if(!$this->request->data['Event']['all_day'] && empty($this->request->data['Event']['end'])){
				$this->Session->setFlash(__('You must add an end time. Otherwise, if it\'s an all day event &mdash; select all day.', true));
			}else{
				//New Event - Don't allow anyone to create an event that happened in the past (check the end date) unless they mark it as completed
				if($this->request->data['Event']['status'] == "Completed" || $this->request->data['Event']['all_day'] || $this->request->data['Event']['end'] > date('Y-m-d')){
					//Parse the time and get meridiem from it
					$this->request->data['Event']['start_meridiem'] = $this->getMeridiem($this->request->data['Event']['start']);
					$this->request->data['Event']['start'] = $this->convertTimeTo24($this->request->data['Event']['start']); //Convert to 24hrs

					if(!$this->request->data['Event']['all_day']){
						if(!empty($this->request->data['Event']['end'])){
							$this->request->data['Event']['end_meridiem'] = $this->getMeridiem($this->request->data['Event']['end']);
							$this->request->data['Event']['end'] = $this->convertTimeTo24($this->request->data['Event']['end']); //Convert to 24hrs
							$this->request->data['Event']['all_day'] = 0; //The user set the end date, so I'm going to use this.
						}
					}
					
					//Disable event until approved
					$this->request->data['Event']['active'] = 0;
					$this->Event->create();
					if ($this->Event->save($this->request->data)) {
						$this->Session->setFlash(__('The event has been submitted for approval. Thanks.', true));
						if(!empty($place_id)){
							$this->redirect(array('plugin'=>false,'controller'=>'places','action' => 'view',$place_id));
						}else{
							$this->redirect(array('action' => 'index'));
						}
					} else {
						$this->Session->setFlash(__('The event could not be submitted. Please, try again.', true));
						$this->resetStartEndDates();
					}
				}else{
					$this->Session->setFlash(__('The event could not be submitted because it occured in the past. If you think this is a mistake, please email us.', true));
					$this->resetStartEndDates();
				}	
			}
		}
		if(!empty($place_id)){
			$place = $this->Event->Place->findById($place_id);

			//Fill in the event location data with place data
			if(!empty($place['Place']['address'])){
				$this->request->data['Event']['address'] = $place['Place']['address'];
			}
			if(!empty($place['Place']['address2'])){
				$this->request->data['Event']['address2'] = $place['Place']['address2'];
			}
			if(!empty($place['Place']['city'])){
				$this->request->data['Event']['city'] = $place['Place']['city'];
			}
			if(!empty($place['Place']['zip'])){
				$this->request->data['Event']['zip'] = $place['Place']['zip'];
			}
			if(!empty($place['Place']['country_id'])){
				$this->request->data['Event']['country_id'] = $place['Place']['country_id'];
			}
			if(!empty($place['Place']['state_region_id'])){
				$this->request->data['Event']['state_region_id'] = $place['Place']['state_region_id'];
			}

			$this->set(compact('place'));
		}
		$countries = $this->Event->Country->find('list');
		$stateRegions = $this->Event->StateRegion->find('list');
		$places = $this->Event->Place->find('list',array(
				'conditions'=>array(
					//'Place.country_id' => 228
				),
				'contain' => array('Country','StateRegion')
			)
		);
		$eventTypes = $this->Event->EventType->find('list');
		$this->set(compact('eventTypes','places','countries','stateRegions'));
	}

	/**
	 * Handles resetting the start/end dates after the form is refreshed
	 * @return void
	 */
	public function resetStartEndDates(){
		$this->request->data['Event']['start'] = $this->convertTimeTo12($this->request->data['Event']['start']);
		$this->request->data['Event']['start'] .= $this->request->data['Event']['start_meridiem']; //Add the meridiem
		if(!$this->request->data['Event']['all_day']){
			$this->request->data['Event']['end'] = $this->convertTimeTo12($this->request->data['Event']['end']);
			$this->request->data['Event']['end'] .= $this->request->data['Event']['end_meridiem']; //Add the meridiem
		}
	}

	/**
	 * The main edit method. Allow the contact/submitter to edit the event
	 * @param int $id The Event Id
	 * @param int $place_id The Place Id
	 */
	public function edit($id = null,$place_id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		//
		$event = $this->Event->read(null,$id);
		//Only allow the user that submitted the event to edit it.
		if($event['Event']['user_id'] != $this->current_user['id'] && $this->isAdmin() != true || $this->isSuperAdmin() != true){
			$this->Session->setFlash(__('You are not allowed to edit this event.'));
			$this->redirect($this->referer());
		}
		if(!empty($event['Place']['id'])) $place_id = $event['Place']['id'];
		//
		if ($this->request->is('post') || $this->request->is('put')) {
			// abort if cancel button was pressed
			if (isset($this->params['data']['cancel'])) {
				$this->Session->setFlash(__('Changes were NOT saved.', true));
				if(!empty($place_id)){
					$this->redirect(array('plugin'=>false,'controller'=>'places','action'=>'view',$place_id));
				}else{
					$this->redirect($this->referer());
				}
			}

			//Add http:// if it doesn't exist.
			if(!empty($this->request->data['Event']['website'])){
				if (preg_match("#https?://#", $this->request->data['Event']['website']) === 0) {
					$this->request->data['Event']['website'] = 'http://'.$this->request->data['Event']['website'];
				}
			}

			if(!$this->request->data['Event']['all_day'] && empty($this->request->data['Event']['end'])){
				$this->Session->setFlash(__('You must add an end time. Otherwise, if it\'s an all day event &mdash; select all day.', true));
			}else{
				//New Event - Don't allow anyone to create an event that happened in the past (check the end date) unless they mark it as completed
				if($this->request->data['Event']['status'] == "Completed" || $this->request->data['Event']['all_day'] || $this->request->data['Event']['end'] > date('Y-m-d')){
					//Parse the time and get meridiem from it
					$this->request->data['Event']['start_meridiem'] = $this->getMeridiem($this->request->data['Event']['start']);
					$this->request->data['Event']['start'] = $this->convertTimeTo24($this->request->data['Event']['start']); //Convert to 24hrs

					if(!$this->request->data['Event']['all_day']){
						if(!empty($this->request->data['Event']['end'])){
							$this->request->data['Event']['end_meridiem'] = $this->getMeridiem($this->request->data['Event']['end']);
							$this->request->data['Event']['end'] = $this->convertTimeTo24($this->request->data['Event']['end']); //Convert to 24hrs
							$this->request->data['Event']['all_day'] = 0; //The user set the end date, so I'm going to use this.
						}
					}

					if ($this->Event->save($this->request->data)) {
						$this->Session->setFlash(__('The event has been updated.', true));
						if(!empty($place_id)){
							$this->redirect(array('plugin'=>false,'controller'=>'places','action' => 'view',$place_id));
						}else{
							$this->redirect(array('admin'=>false,'action' => 'index'));
						}
					} else {
						$this->Session->setFlash(__('The event could not be updated. Please, try again.', true));
						$this->resetStartEndDates();
					}
				}else{
					$this->Session->setFlash(__('The event could not be updated because it occured in the past. If you think this is a mistake, please email us.', true));
				}
			}
		}else{
			$this->request->data = $this->Event->read(null, $id);
			$this->resetStartEndDates();
		}
		if(!empty($place_id)){
			$place = $this->Event->Place->findById($place_id);
			$this->set(compact('place'));
		}
		$stateRegions = $this->Event->StateRegion->find('list');
		$countries = $this->Event->Country->find('list');
		$places = $this->Event->Place->find('list');
		$eventTypes = $this->Event->EventType->find('list');
		$this->set(compact('eventTypes','places','countries','stateRegions'));
	}


	/**
	 * The feed action is called from "webroot/js/ready.js" to get the list of events (JSON)
	 * @param string id This isn't doing anything?
	 */
	public function feed($id=null) {
=======
	var $name = 'Events';

        var $paginate = array(
            'limit' => 15
        );

        function index() {
		$this->Event->recursive = 1;
		$this->set('events', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid event', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('event', $this->Event->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Event->create();
			if ($this->Event->save($this->data)) {
				$this->Session->setFlash(__('The event has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.', true));
			}
		}
		$this->set('eventTypes', $this->Event->EventType->find('list'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid event', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Event->save($this->data)) {
				$this->Session->setFlash(__('The event has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Event->read(null, $id);
		}
		$this->set('eventTypes', $this->Event->EventType->find('list'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for event', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Event->delete($id)) {
			$this->Session->setFlash(__('Event deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Event was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

        // The feed action is called from "webroot/js/ready.js" to get the list of events (JSON)
	function feed($id=null) {
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99
		$this->layout = "ajax";
		$vars = $this->params['url'];
		$conditions = array('conditions' => array('UNIX_TIMESTAMP(start) >=' => $vars['start'], 'UNIX_TIMESTAMP(start) <=' => $vars['end']));
		$events = $this->Event->find('all', $conditions);
		foreach($events as $event) {
			if($event['Event']['all_day'] == 1) {
				$allday = true;
				$end = $event['Event']['start'];
			} else {
				$allday = false;
				$end = $event['Event']['end'];
			}
<<<<<<< HEAD
			if(!empty($event['Place']['name'])){
				$event['Event']['title'] = $event['Event']['title'].' @'.$event['Place']['name'].' '.$event['Place']['city'].', '.$event['StateRegion']['name'];
			}
=======
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99
			$data[] = array(
					'id' => $event['Event']['id'],
					'title'=>$event['Event']['title'],
					'start'=>$event['Event']['start'],
					'end' => $end,
					'allDay' => $allday,
					'url' => '/full_calendar/events/view/'.$event['Event']['id'],
					'details' => $event['Event']['details'],
					'className' => $event['EventType']['color']
			);
		}
		$this->set("json", json_encode($data));
	}

<<<<<<< HEAD
	/**
	 * This method handles rsvping a user
	 * @param int $event_id The event id
	 * @param int (1 or 2) 1 = I'm Attending / 2 = Possibly
	 * @return 
	 */
	public function rsvp($event_id,$status = 1){
		if($status > 2){
			throw new NotFoundException(__('Invalid request'));
		}
		$currentStatus = $this->Event->EventAttendee->getStatus($this->current_user['id'],$event_id);
		//The user doesn't have a current status
		if($this->Event->EventAttendee->rsvp($this->current_user['id'],$event_id,$status)){
			$this->redirect(array('action' => 'view',$event_id));
		}else{
			$this->Session->setFlash(__('There was an error RSVPing you for the event. Please try again later.', true));
			$this->redirect(array('action' => 'view',$event_id));
		}
	}

	/**
	 * The update action is called from "webroot/js/ready.js" to update date/time when an event is dragged or resized
	 */
	public function update() {
=======
        // The update action is called from "webroot/js/ready.js" to update date/time when an event is dragged or resized
	function update() {
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99
		$vars = $this->params['url'];
		$this->Event->id = $vars['id'];
		$this->Event->saveField('start', $vars['start']);
		$this->Event->saveField('end', $vars['end']);
		$this->Event->saveField('all_day', $vars['allday']);
	}

<<<<<<< HEAD
	/**
	 * This action controls what's show on the approval index
	 * @author Rob Sawyer
	 * @date 8/5/12
	 * @since 1.0
	 * @param
	 * @return void
	*/
	public function admin_approve_index(){
		//Upon approval don't forget to add the approve_user_id
		$this->paginate = array(
			'conditions' => array(
				'Event.active' => 0
			),
			'contains' => array('User','EventType','EventAttendee'),
			'group' => 'Event.id',
			'recursive' => 1,
			'order' => 'Event.created DESC'
		);

		$this->set('unapproved',$this->paginate());
	}

	/**
	 * This method handles banning a event. Or, rather unapproving it.
	 * @author Rob Sawyer
	 * @date 9/14/12
	 * @since 1.0
	 * @param void
	 * @return void
	*/
	public function admin_ban($id = null){
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}

		//Make the approvals
		$event = $this->Event->read(null,$id);
		if($event['Event']['active'] == 1){
			$this->Event->approve(false,$id);
			$this->Session->setFlash(__('The Event '.$event['Event']['title'].' has been banned.'));
		}else{
			$this->Session->setFlash(__('The Event '.$event['Event']['title'].' has already been banned.'));
		}

		//Take the user back to the previous page.
		$this->redirect($this->referer());
	}

	/**
	 * This method controls the view for the terms approval page. This page allows the admin to quickly review all unapproved terms.
	 * @author Rob Sawyer
	 * @date 8/5/12
	 * @since 1.0
	 * @param void
	 * @return void
	*/
	public function admin_approve($id = null){
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}

		//Make the approvals
		$event = $this->Event->read(null,$id);
		if($event['Event']['active'] == 0){
			$this->Event->approve(true, $id);

			$this->Session->setFlash(__('The Event '.$event['Event']['title'].' has been approved.'));
		}else{
			$this->Session->setFlash(__('The Event '.$event['Event']['title'].' has already been approved.'));
		}

		$this->redirect(array('admin'=>true,'action' => 'approve_index'));
	}

	/**
	 * The main delete event method
	 * @param int id The event id
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('Invalid event'));
		}
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for event', true));
			$this->redirect(array('admin'=>true,'action' => 'approve_index'));
		}
		if ($this->Event->delete()) {
			$this->Session->setFlash(__('Event deleted', true));
			$this->redirect(array('admin'=>true,'action' => 'approve_index'));
		}
		$this->Session->setFlash(__('Event was not deleted', true));
		$this->redirect(array('admin'=>true,'action' => 'approve_index'));
	}

	/**
	 * Convert 12 hour time to 24 hour time
	 * @param string $timestamp
	 */
	public function convertTimeTo24($time){
		return date('Y-m-d H:i', strtotime($time)); //Convert to 24hrs
	}

	/**
	 * Convert 24 hour time to 12 hour time
	 * @param string $timestamp
	 */
	public function convertTimeTo12($time){
		return date('Y-m-d h:i', strtotime($time)); //Convert to 24hrs
	}

	/**
	 * Parses the AM/PM from a string
	 * @param string $str
	 */
	public function getMeridiem($str=''){
		$ext = strtoupper(substr($str,-2));
		if($ext == "AM" || $ext == "PM"){
			return $ext;
		}else{
			return null;
		}
	}
=======
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99
}
?>
