<?php

return array(
	'/'                                                                     => 'main/index',
        '/getSpecialize/'                                                       => 'main/getSpecialize',
        '/getHospitals/<specializeId:\d+>'                                      => 'main/getHospitals',
        '/getDoctors/<hospitalId:\d+>/<specializeId:\d+>'                       => 'main/getDoctors',
    
    
        '/booking'                                                              => 'booking/index',

);
