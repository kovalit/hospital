<?php

class Schedules extends ActiveRecord {
	
	public $doctorId;
	public $scheme;
	public $active;
        public $version;
        public $isException;

	/**
	 * @return string
	 */
	public function tableName() {
		return 'schedules';
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
			['doctorId, scheme, version', 'required'],
			['doctorId, scheme, version, isException, active', 'safe'],
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
			'doctorId' => 'Доктор',
			'scheme' => 'Схема',
			'version' => 'Версия',
                        'isException' => 'Исключение',
                        'date' => 'Дата'
		);
	}
        
	
}
