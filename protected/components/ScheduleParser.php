<?php


class ScheduleParser extends CComponent {

        
        public function getInnerFormat($scheme, $version){
            
            switch ($version) {
                case '1.0.0':
                    
                    return $this->OneZeroZero($scheme);
                
                case '1.0.0':
                    
                    return null;
                
                default:
                    
                    return null;
                
            }
            
        }
        
        
        private function OneZeroZero($scheme) {
                return json_decode($scheme, true);
        }
        

	
}