<?php

class BookingForm extends CFormModel {

	public $specializeId;
	public $hospitalId;
	public $doctorId;
        public $date;
        public $time;
        public $name;
        public $phone;
        public $email;


	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules() {
		return array(

		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'username'   => 'Login',
			'password'   => 'Password',
			'rememberMe' => 'Remember Me',
		);
	}

}
