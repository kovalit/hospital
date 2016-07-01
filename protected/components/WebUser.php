<?php
/**
 * Class WebUser
 * @property string $role
 */
class WebUser extends CWebUser {

	const ROLE_GUEST = 'guest';
	const ROLE_MODERATOR = 'moderator';
	const ROLE_ADMIN = 'admin';
	const ROLE_COOKIE = 'admin_role';
	const ROLE_SALT = 'i_am_cutie_salt_for_role_admin';

	private function _getRoleHash($role) {
		return md5($role . $this->id . self::ROLE_SALT);
	}

	/** @var string */
	public $adminLoginUrl = 'adminUsers/signIn';

	public function getRole() {
		$role = null;

		if (isset(Yii::app()->request->cookies[self::ROLE_COOKIE]) && Yii::app()->request->cookies[self::ROLE_COOKIE]) {
			$role = Yii::app()->cache->get(Yii::app()->request->cookies[self::ROLE_COOKIE]->value)?: $role;

			// check if this role cookie is in accordance for the user id
			if (Yii::app()->request->cookies[self::ROLE_COOKIE]->value !== $this->_getRoleHash($role)) {
				$role = null;
			}
		}
		return $role?: self::ROLE_GUEST;
	}

	public function setRole($role) {
		$roleHash = $this->_getRoleHash($role);
		$cookie = new CHttpCookie(self::ROLE_COOKIE, $roleHash, array_merge($this->identityCookie, ['expire' => time() + $this->authTimeout, 'httpOnly' =>true]));
		Yii::app()->request->cookies[self::ROLE_COOKIE] = $cookie;
		Yii::app()->cache->set($roleHash, $role, $this->authTimeout);
	}

	protected function afterLogout() {
		parent::afterLogout();

		Yii::app()->request->cookies->remove(self::ROLE_COOKIE, ['domain' => $this->identityCookie['domain']]);
	}

	/**
	 * @param BasePlayerIdentity|AdminIdentity $identity
	 * @param int $duration seconds for cookie life
	 * @return bool
	 */
	public function login($identity, $duration = 0) {
		if (!$duration && $this->authTimeout) {
			$duration = $this->authTimeout;
		}

		if (parent::login($identity, $duration)) {
			if (property_exists($identity, 'role')) {
				$this->role = $identity->role;
			}
			return true;
		}
		return false;
	}
}
