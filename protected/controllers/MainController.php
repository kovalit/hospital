<?php

class MainController extends BaseController {

    
	public function actionIndex() {
		$this->render("/index");
	}

	
	public function actionError() {
		$this->layout = 'error';
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				try {
					$this->render("/error{$error['code']}", ['error' => $error]);
				} catch (CExceptison $e) {
					if ($error['code'] === 403) {
						$this->redirect(Yii::app()->user->loginUrl);
					}
					$this->render("/error", ['error' => $error]);
				}
			}
		}
	}
        
        public function actionGetSpecialize() {
            
            $specialize = Specialize::model()->findAll();
            
            $this->renderList($specialize);
            
        }
        
        /**
	 * @param int $specializeId
	 */
        public function actionGetHospitals($specializeId = null) {
            
                $criteria           = new CDbCriteria;

                $criteria->alias    = 'hospitals';
                $criteria->select   = ['hospitals.id as id', 'hospitals.name as name'];
                $criteria->join     = 'Left JOIN staff on staff.hospitalId = hospitals.id' . ' ';
                $criteria->join    .= 'Left JOIN skills on skills.doctorId = staff.doctorId';
                $criteria->distinct = 'true';
                $criteria->order    = 'name asc';

                $criteria->condition = 'skills.specializeId=:specializeId';
                $criteria->params    = [':specializeId'=>$specializeId];

                $hospitals = Hospitals::model()
                        ->findAll($criteria);
                
                $this->renderList($hospitals);
                
        }
        
          /**
	 * @param int $hospitalId
         * @param int $specializeId
	 */
        public function actionGetDoctors($hospitalId = null, $specializeId = null) {
             
                $criteria           = new CDbCriteria;

                $criteria->alias    = 'doctors';
                $criteria->select   = ['doctors.id as id', 'concat(doctors.firstName," ",lastName) as name'];
                $criteria->join     = 'Left JOIN staff on staff.doctorId = doctors.id' . ' ';
                $criteria->join    .= 'Left JOIN skills on skills.doctorId = staff.doctorId';
                $criteria->distinct = 'true';
                $criteria->order    = 'name asc';

                $criteria->condition = 'skills.specializeId=:specializeId AND staff.hospitalId=:hospitalId';
                $criteria->params    = [':specializeId'=>$specializeId, ':hospitalId'=>$hospitalId];

                $doctors = Doctors::model()
                        ->findAll($criteria);
                
                $this->renderList($doctors);
                
        }
        
        
        

	
}
