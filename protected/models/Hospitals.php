<?php

class Hospitals extends ActiveRecord {
	
	public $name;
	public $active;

	/**
	 * @return string
	 */
	public function tableName() {
		return 'hospitals';
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
			['name', 'required'],
			['name', 'safe'],
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
			'name' => 'Имя',
		);
	}
        
	
}
