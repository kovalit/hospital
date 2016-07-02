<?php

class Doctors extends ActiveRecord {
	
	public $firstName;
	public $middleName;
        public $lastName;
        public $active;
        
        public $name;

	/**
	 * @return string
	 */
	public function tableName() {
		return 'doctors';
	}

	/**
	 * @param string $className
	 * @return $this
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return mixed|string
	 */
	public function primaryKey() {
		return 'id';
	}

	public function rules() {
		return [
			['firstName, middleName', 'required'],
			['firstName, middleName, lastName', 'safe'],
		];
	}
	
	public function relations() {
		return [
	
		];
	}
        

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels() {
		return array(
			'id' => 'ID',
                        'name' => 'Выберите доктора...',
			'firstName' => 'Имя',
			'middleName' => 'Отчество',
			'lastName' => 'Фамилия',
		);
	}
        
	
}
