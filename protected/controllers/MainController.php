<?php

class MainController extends BaseController {

    
	public function actionIndex() {
            
                $specialize     = Specialize::model()->getList();
                $booking        = new Booking;
                
                $class = get_class($booking);
         
                if (Yii::app()->request->isPostRequest && isset($_POST[$class])) {
                       
                        $booking->attributes = $_POST[$class];
                        
                        $time = $_POST[$class]['time'];
                        
                        if (!empty($time)) {
                            
                                $interval = explode('-', $time);

                                if(count($interval) === 2) {
                                        $booking->start = $interval[0];
                                        $booking->end   = $interval[1];  
                                }
                        }
                        
                        # save users
                        
                        $user = Users::model()->findByAttributes([ 'email'=> $booking->email]);
                        
                        $userId = null;
                        
                        if (empty($user)) {
                            
                                $usersModel = new Users();
                                $usersModel->attributes = $booking->attributes ;
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
                        
                        if ($booking->save()) {
                                $this->redirect($this->createUrl('booking/index')); 
                        }

                }
                
		$this->render("/index", [
                    'model'         => $booking,
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
        
          /**
	 * @param int $hospitalId
         * @param int $doctorId
	 */
        public function actionGetSchedule($hospitalId = null, $doctorId = null) {
            
            $scheme             = [];
            $exceptions         = [];
            $busy               = [];    
            
            $interval = date('Y-m-d') . '+' . Yii::app()->params->itemAt('scheduleInterval') . ' days';
            
            $parser = new ScheduleParser($interval);
 
            # GET Schedules
            $schedules = Schedules::model()->findAllByAttributes([
                'hospitalId'=> $hospitalId, 
                'doctorId'  => $doctorId,
                'active'    => 1
            ]);

            # Parse Schedules
            foreach  ($schedules as $schedule) {
                    if ((bool)$schedule->isException === false) {
                            $scheme = $parser->getInnerFormat($schedule->scheme, $schedule->version); 
                    }
                    else {
                            $exceptions = $parser->getInnerFormat($schedule->scheme, $schedule->version); 
                    }
            }
            

            # GET busy
            $criteria           = new CDbCriteria;
            
            $criteria->condition = 'hospitalId = :hospitalId '
                        . 'AND doctorId = :doctorId '
                        . 'AND active = 1 '
                        . 'AND date >= CURDATE()';
            
            $criteria->params    = [
                        ':hospitalId'=>$hospitalId, 
                        ':doctorId'=>$doctorId
                    ];

            $booking = Booking::model()
                        ->findAll($criteria);

                   
            foreach ($booking as $item) {
                    $key = $item['date'];

                    if (!array_key_exists($key, $busy)) {
                        $busy[$key] = [];  
                    }

                    $value  = date("H:i", strtotime($item['date'] . ' ' . $item['start']));
                    $value .= '-';
                    $value .= date("H:i", strtotime($item['date'] . ' ' . $item['end']));

                    array_push($busy[$key], $value);
            }
     
            if ($scheme === null) {
                    $this->renderJson(['error' => 1]);
            }
            
            
            # Calc different    
            foreach ($scheme as $date => $timeList) {

                    $merge = [];
                    $isCrossing = false;
                    
                    if (array_key_exists($date, $busy)  ) {
                            $merge = $busy[$date];    
                            $isCrossing = true;
                    }
                    
                    if (array_key_exists($date, $exceptions)  ) {
                       
                            $merge = array_merge_recursive($merge, $exceptions[$date]);
                            $merge = array_unique($merge);
                            $isCrossing = true;
                    }
                    
                    if($isCrossing) {
                           
                            $scheme[$date] = array_diff($timeList, $merge);

                            if (count($scheme[$date]) === 0) {
                                    unset($scheme[$date]);
                            }
                   
                    }
                    
            }
            

            unset($parser);
            unset($merge);

            $this->renderJson($scheme);

        }
}
