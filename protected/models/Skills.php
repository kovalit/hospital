<?php

class Skills extends ActiveRecord {
	
	public $doctorId;
	public $specializeId;

	/**
	 * @return string
	 */
	public function tableName() {
		return 'skills';
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
			['doctorId, specializeId', 'required'],
			['doctorId, specializeId', 'safe'],
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
			'specializeId' => 'Специализация',
		);
	}
        
	
}
