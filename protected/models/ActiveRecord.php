<?php

/**
 * @method $this with(mixed $relations)
 */
class ActiveRecord extends CActiveRecord {
	protected $alias;

	public function all() {
		$this->resetScope();
		return $this;
	}

	public function setAttributes($values, $safeOnly = true) {
		if (!is_array($values)) {
			return;
		}
		$attributes = array_flip($safeOnly? $this->getSafeAttributeNames(): $this->attributeNames());
		foreach ($values as $name => $value) {
			$nameRest = substr($name, 1);
			$func     = 'set' . strtoupper($name[0]) . $nameRest;
			if (method_exists($this, $func)) {
				$this->$func($value);
			} else {
				if (isset($attributes[$name])) {
					$this->$name = $value;
				} else {
					if ($safeOnly) {
						$this->onUnsafeAttribute($name, $value);
					}
				}
			}
		}
	}

	/** @return bool */
	public function isExists() {
		$pk = array();
		$table = $this->getMetaData()->tableSchema;
		if (is_string($table->primaryKey)) {
			$pk[$table->primaryKey] = $this->{$table->primaryKey};
		} elseif (is_array($table->primaryKey)) {
			foreach ($table->primaryKey as $name) {
				$pk[$name] = $this->$name;
			}
		} else {
			return false;
		}
		return $this->countByAttributes($pk);
	}
        
        public function last($limit = 10) {
		$this->dbCriteria->mergeWith([
			'limit' => (int) $limit? : 10,
		]);
		return $this;
	}
        
        
        public function offset($offset) {
		$this->dbCriteria->mergeWith([
			'offset' => (int) $offset,
		]);
		return $this;
	}        
}
