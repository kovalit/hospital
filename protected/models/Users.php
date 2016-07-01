<?php

/**
 * @property string $password
 */
class Users extends ActiveRecord {


	public $login;
        public $name;
        public $email;
        public $phone;
        public $pass;
        public $salt;
        public $active;
        public $source;
        public $isReg;

	/**
	 * PHP getter magic method.
	 * This method is overridden so that AR attributes can be accessed like properties.
	 * @param string $name property name
	 * @return mixed property value
	 * @see getAttribute
	 */
	public function __get($name) {
		$func = 'get' . strtoupper($name[0]) . substr($name, 1);
		if (method_exists($this, $func)) {
			return $this->$func();
		}
		return parent::__get($name);
	}

	/**
	 * @var string
	 * @transient
	 */
	protected $confirmPassword;
	/**
	 * @var boolean
	 * @transient
	 */
	protected $needEncodePassword = false;

	/**
	 * @param string $className
	 * @return User
	 */
	public static function model($className = __CLASS__) {
		return parent::model($className);
	}

	/** @return string */
	public function tableName() {
		return 'users';
	}

	/** @return array */
	public function rules() {
		return array(
			array('login, email, pass', 'required'),
			array('login, email', 'length', 'max' => 100),
			array('email', 'email'),
			array('login, email', 'unique'),
			array('confirmPassword', 'compare', 'compareAttribute' => 'password'),
			array('pass, confirmPassword', 'unsafe'),
			array('name, email', 'safe'),
			array('id, name, email', 'safe', 'on' => 'search'),
		);
	}

	/** @return array */
	public function attributeLabels() {
		return array(
			'id'              => 'ID',
			'username'        => 'Login',
			'password'        => 'Password',
			'confirmPassword' => 'Confirm password',
			'salt'            => 'Security salt',
			'email'           => 'Email',
			'description'     => 'Description',
			'role'            => 'Role',
		);
	}

	/**
	 * @param string $password
	 * @param bool $encode
	 * @return void
	 */
	public function setPassword($password, $encode = true) {
		$this->password = $password;
		$this->needEncodePassword = $encode;
	}

	/**
	 * @return string
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * @param string $password
	 * @return void
	 */
	public function setConfirmPassword($password) {
		$this->confirmPassword = $password;
	}

	/**
	 * @return string
	 */
	public function getConfirmPassword() {
		return $this->confirmPassword;
	}

	/**
	 * @param string $salt
	 */
	public function setSalt($salt) {
		$this->salt = $salt;
	}

	/**
	 * @return string
	 */
	public function getSalt() {
		if (!$this->salt) {
			$this->salt = $this->generateSalt();
		}
		return $this->salt;
	}

	/**
	 * Checks if the given password is correct.
	 * @param string $password the password to be validated
	 * @return boolean whether the password is valid
	 */
	public function validatePassword($password) {
		return $this->hashPassword($password, $this->getSalt()) === $this->password;
	}

	/**
	 * Generates the password hash.
	 * @param string $password
	 * @param string $salt
	 * @return string hash
	 */
	public function hashPassword($password, $salt) {
		return md5($salt . $password);
	}

        
	protected function beforeSave() {
		if ($this->needEncodePassword || !$this->salt) {
			$this->password = $this->hashPassword($this->password, $this->getSalt());
		}
		return parent::beforeSave();
	}

        
	protected function afterFind() {
		$this->confirmPassword = $this->password;
		parent::afterFind();
	}

	/**
	 * Generates a salt that can be used to generate a password hash.
	 * @return string the salt
	 */
	public function generateSalt() {
		return uniqid('', true);
	}

	/**
	 * @return CActiveDataProvider
	 */
	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('username', $this->username, true);
		$criteria->compare('email', $this->email, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	public function relations() {
		return [
		];
	}
}
