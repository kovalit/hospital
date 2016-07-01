<?php

class Booking extends ActiveRecord {
	
	public $doctorId;
	public $hospitalId;
	public $userId;
        public $date;
        public $start;
        public $end;
        public $active;
        public $created;

	/**
	 * @return string
	 */
	public function tableName() {
		return 'booking';
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
			['doctorId, hospitalId, userId, date, start, end', 'required'],
			['doctorId, hospitalId, userId, date, start, end, active, created', 'safe'],
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
			'hospitalId' => 'Госпиталь',
			'userId' => 'Пользователь',
                        'date' => 'Дата',
                        'start' => 'Начало',
                        'end' => 'Конец'
		);
	}
        
	
}
