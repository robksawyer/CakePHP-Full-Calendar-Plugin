<?php
/*
 * Controllers/EventTypesController.php
 * CakePHP Full Calendar Plugin
 *
 * Copyright (c) 2010 Silas Montgomery
 * http://silasmontgomery.com
 *
 * Licensed under MIT
 * http://www.opensource.org/licenses/mit-license.php
 */
 
class EventTypesController extends FullCalendarAppController {

<<<<<<< HEAD
	public $name = 'EventTypes';

	public $helpers = array('Tools.Datetime');

    public $paginate = array(
        'limit' => 15
    );

    /**
	 * admin_view Allow the admin to view a single event type
	 * @param string id The event type id
	 */
    public function admin_view($id = null) {
		$this->EventType->id = $id;
		if (!$this->EventType->exists()) {
			throw new NotFoundException(__('Invalid event type'));
		}
		$this->EventType->recursive = 2;
		$this->set('eventType', $this->EventType->read(null, $id));
	}

	/**
	 * admin_index Allow the admin to view a list of event types
	 */
	public function admin_index() {
=======
	var $name = 'EventTypes';

        var $paginate = array(
            'limit' => 15
        );

	function index() {
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99
		$this->EventType->recursive = 0;
		$this->set('eventTypes', $this->paginate());
	}

<<<<<<< HEAD
	/**
	 * admin_add Allow the admin to add an event type
	 */
	public function admin_add() {

		if ($this->request->is('post')) {
			// abort if cancel button was pressed
			if (isset($this->params['data']['cancel'])) {
				$this->Session->setFlash(__('Changes were NOT saved.', true));
				$this->redirect($this->referer());
			}

			$this->EventType->create();
			if ($this->EventType->save($this->request->data)) {
				$this->Session->setFlash(__('The event type has been saved', true));
				$this->redirect(array('admin'=>true,'action' => 'index'));
=======
	function view($id = null) {
		if(!$id) {
			$this->Session->setFlash(__('Invalid event type', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('eventType', $this->EventType->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->EventType->create();
			if ($this->EventType->save($this->data)) {
				$this->Session->setFlash(__('The event type has been saved', true));
				$this->redirect(array('action' => 'index'));
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99
			} else {
				$this->Session->setFlash(__('The event type could not be saved. Please, try again.', true));
			}
		}
	}

<<<<<<< HEAD
	/**
	 * admin_edit Allow the admin to edit an event type
	 * @param string id The event type id
	 */
	public function admin_edit($id = null) {
		$this->EventType->id = $id;
		if (!$this->EventType->exists()) {
			throw new NotFoundException(__('Invalid event type'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			// abort if cancel button was pressed
			if (isset($this->params['data']['cancel'])) {
				$this->Session->setFlash(__('Changes were NOT saved.', true));
				$this->redirect($this->referer());
			}

			if ($this->EventType->save($this->request->data)) {
				$this->Session->setFlash(__('The event type has been saved', true));
				$this->redirect(array('admin'=>true,'action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event type could not be saved. Please, try again.', true));
			}
		}else{
			$this->request->data = $this->EventType->read(null, $id);
		}
	}

	/**
	 * admin_delete Allow the admin to delete an event type
	 * @param string id The event type id
	 */
	public function admin_delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->EventType->id = $id;
		if (!$this->EventType->exists()) {
			throw new NotFoundException(__('Invalid event type'));
		}
		if ($this->EventType->delete()) {
			$this->Session->setFlash(__('Event type deleted', true));
			$this->redirect(array('admin'=>true,'action'=>'index'));
		}
		$this->Session->setFlash(__('Event type was not deleted', true));
		$this->redirect(array('admin'=>true,'action' => 'index'));
=======
	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid event type', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->EventType->save($this->data)) {
				$this->Session->setFlash(__('The event type has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The event type could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->EventType->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for event type', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->EventType->delete($id)) {
			$this->Session->setFlash(__('Event type deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Event type was not deleted', true));
		$this->redirect(array('action' => 'index'));
>>>>>>> 0a81214ecc580a23e40582955199df3ca7dadb99
	}
}
?>
