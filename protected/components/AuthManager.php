<?php

class AuthManager extends CPhpAuthManager {
	public function init() {
		parent::init();

		/** @var WebUser $user  */
		$user = Yii::app()->user;
		if (!$user->isGuest) {
			$this->assign($user->getRole(), $user->id);
		}
	}
}
