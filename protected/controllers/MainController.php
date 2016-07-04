<?php

class MainController extends BaseController {

    
	public function actionIndex() {
            
                $specialize     = Specialize::model()->getList();
                $bookingForm    = new BookingForm;
         
                if (Yii::app()->request->isPostRequest && isset($_POST['BookingForm'])) {
                       
                        $bookingForm->attributes =  $_POST['BookingForm'];

                        $booking = new Booking(); 
                        $booking->attributes = $bookingForm->attributes ;

                        if (!empty($bookingForm->time)) {
                                $time = explode('-', $bookingForm->time);

                                if(count($time) === 2) {
                                        $booking->start = $time[0];
                                        $booking->end   = $time[1];  
                                }
                        }
                        
                        $user = Users::model()->findByAttributes(['email'=>$bookingForm->email]);
                        
                        $userId = null;
                        
                        if (empty($user)) {
                            
                                $usersModel = new Users();
                                $usersModel->attributes = $bookingForm->attributes ;
                                $usersModel->isReg = 0;
                                $usersModel->source = 'booking';
                                if ($usersModel->save()) {
                                        $userId = $usersModel->id;
                                }
                                
                        }
                        else {
                            
                                $userId = $user->id;
                             
                        }
                        
                        
                        $booking->userId = $userId;
                        
                      //  print_r($booking->attributes);
                        
                        if ($booking->save()) {
                                $this->redirect($this->createUrl('booking/index')); 
                        }

                    
                     
			//$this->redirect($this->createUrl('booking/index'));

				}
                
		$this->render("/index", [
                    'model'        => $bookingForm,
                    'specialize'    => $specialize
                ]);
                
                
	}

	
	public function actionError() {
		$this->layout = 'error';
		if ($error = Yii::app()->errorHandler->error) {
			if (Yii::app()->request->isAjaxRequest) {
				echo $error['message'];
			} else {
				try {
					$this->render("/error", ['error' => $error]);
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
                $criteria->join    .= 'Left JOIN skills on skills.doctorId = staff.doctorId' . ' ';
                $criteria->join    .= 'Left JOIN schedules on schedules.hospitalId = hospitals.id '
                        . 'AND schedules.doctorId = staff.doctorId'; 
                
                $criteria->distinct = 'true';
                $criteria->order    = 'name asc';

                $criteria->condition = 'skills.specializeId=:specializeId '
                        . 'AND schedules.doctorId is not null';
                
                $criteria->params    = [':specializeId'=>$specializeId];

                $hospitals = Hospitals::model()
                        ->findAll($criteria);
                
                $items = [];
                $items[''] = Hospitals::model()->getAttributeLabel('name');
		foreach ($hospitals as $item) {
                        $key = $item['id'];
			$items[$key] = $item['name'];
		}
                
                $this->renderJson($items);
                
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
                $criteria->join    .= 'Left JOIN skills on skills.doctorId = staff.doctorId' . ' ';
                $criteria->join    .= 'Left JOIN schedules on schedules.doctorId = doctors.id'; 
                $criteria->distinct = 'true';
                $criteria->order    = 'name asc';

                $criteria->condition = 'skills.specializeId=:specializeId '
                        . 'AND staff.hospitalId=:hospitalId '
                        . 'AND schedules.hospitalId=:hospitalId';
                $criteria->params    = [':specializeId'=>$specializeId, ':hospitalId'=>$hospitalId];

                $doctors = Doctors::model()
                        ->findAll($criteria);
                
                $items = [];
                $items[''] = Doctors::model()->getAttributeLabel('name');
		foreach ($doctors as $item) {
                        $key = $item['id'];
			$items[$key] = $item['name'];
		}
                
                $this->renderJson($items);
                
        }
        
        public function actionGetSchedule($hospitalId = null, $doctorId = null) {
            $Schedules = Schedules::model()->findByAttributes(['hospitalId'=>$hospitalId, 'doctorId'=>$doctorId]);
            echo $Schedules->scheme;
        }

}
