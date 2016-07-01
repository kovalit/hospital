<?php

//class AdminIdentity extends CBaseUserIdentity {
class AdminIdentity extends CUserIdentity {
	private $_id;
	public $role = WebUser::ROLE_GUEST;

	/**
	 * Authenticates the user.
	 * The information needed to authenticate the user
	 * are usually provided in the constructor.
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate() {
		/** @var $user User */
		$user = User::model()
				->find('LOWER(username) = ?', array(strtolower($this->username)));
		if ($user === null) {
			$this->errorCode = self::ERROR_USERNAME_INVALID;
		} else {
			if (!$user->validatePassword($this->password)) {
				$this->errorCode = self::ERROR_PASSWORD_INVALID;
			} else {
				$this->_id = $user->id;
				$this->username = $user->username;
				$this->role = $user->role;
				$this->errorCode = self::ERROR_NONE;
			}
		}
		return $this->errorCode == self::ERROR_NONE;
	}

	/**
	 * @return integer the ID of the user record
	 */
	public function getId() {
		return $this->_id;
	}
}