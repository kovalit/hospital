<?php

class Staff extends ActiveRecord {
	
	public $doctorId;
	public $hospitalId;
	public $active;

	/**
	 * @return string
	 */
	public function tableName() {
		return 'staff';
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
			['doctorId, hospitalId', 'required'],
			['doctorId, hospitalId, active', 'safe'],
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
                        'hospitalId' => 'Поликлиника',
		);
	}
        
	
}
