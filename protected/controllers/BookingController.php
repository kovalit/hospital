<?php

class BookingController extends BaseController {

    
	public function actionIndex() {
		$this->render("/booking");
	}

	
	public function actionError() {
		$this->layout = 'error';
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				try {
					$this->render("/error{$error['code']}", ['error' => $error]);
				} catch (CException $e) {
					if ($error['code'] === 403) {
						$this->redirect(Yii::app()->user->loginUrl);
					}
					$this->render("/error", ['error' => $error]);
				}
			}
		}
	}

	
}
