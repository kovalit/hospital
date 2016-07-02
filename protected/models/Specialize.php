<?php

class Specialize extends ActiveRecord {
	
	public $name;
	public $active;

	/**
	 * @return string
	 */
	public function tableName() {
		return 'specialize';
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
			'name' => 'Выберите специализацию...',
		);
	}
        
        public function getList() {
                $model = get_class($this);
		$items = [];
                $items[''] = $model::model()->getAttributeLabel('name');
		foreach ($model::model()
					->findAll() as $item) {
			$items[$item['id']] = $item['name'];
		}
		return $items;
	}
        
	
}
