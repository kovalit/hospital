<?php


class ScheduleParser extends CComponent {
    
        public $startDate;
        public $endDate;
    
    
        public function __construct($endDate) {
            
                $this->startDate   = date('Y-m-d');
                $this->endDate     = $endDate;
           
       }

        
        public function getInnerFormat($scheme, $version){
            
            switch ($version) {
                
                case '1.0.0':
                    
                    return $this->Simple($scheme);
                
                case '1.0.1':
                    
                    return $this->WeekSequence($scheme);
                
                default:
                    
                    return null;
                
            }
            
        }
        
        
        private function Simple($scheme) {
            
                return json_decode($scheme, true);
                
        }
        
        
        private function WeekSequence($scheme) {
            
                $schedule = json_decode($scheme, true);
                
                if (empty($schedule)) {
                        return null;
                }
                
                $dates = [];
                
                $start  =  strtotime($this->startDate);
                $end    =  strtotime($this->endDate);

                while ($start <= $end) {
                    
                        $weekday =  date('w', $start);
                        
                        if (array_key_exists($weekday, $schedule)) {
                                $date =  date('Y-m-d', $start);
                                $dates[$date] = $schedule[$weekday];
                        }

                        $start += 86400;
                }
                   
                return $dates;
                
        }
        

	
}