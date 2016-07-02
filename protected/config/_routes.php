<?php

return array(
	'/'                                                                     => 'main/index',
        '/getSpecialize/'                                                       => 'main/getSpecialize',
        '/getHospitals/<specializeId:\d+>'                                      => 'main/getHospitals',
        '/getDoctors/<hospitalId:\d+>/<specializeId:\d+>'                       => 'main/getDoctors',
        '/getSchedule/<hospitalId:\d+>/<doctorId:\d+>'                          => 'main/getSchedule',
    
    
        '/booking'                                                              => 'booking/index',

);
