<?php

Yii::import('system.collections.CMap');

$config = CMap::mergeArray(
	require('_main.php'),
	[
		'components'    => [
			'db'                => [
				'connectionString' => 'mysql:host=127.0.0.1;dbname=',
				'emulatePrepare'   => true,
				'username'         => '',
				'password'         => '',
				'charset'          => 'utf8',
			],
		],
	]
);

return $config;
