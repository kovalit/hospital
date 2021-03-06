<?php

Yii::import('system.collections.CMap');

$config = CMap::mergeArray(require('_main.php'), [
	'components' => [
		'db'                => [
				'connectionString' => 'mysql:host=127.0.0.1;dbname=hospital',
				'emulatePrepare'   => true,
				'username' => 'hospital',
				'password' => 'hyIGwYKUTH8x',
				'charset'  => 'utf8',
			],
		'log' => [
			'class' => 'CLogRouter',
			'routes' => [
				[
					'class' => 'CFileLogRoute',
					'levels' => 'error, warning, info, trace',
				],
//				[
//					'class' => 'CWebLogRoute',
//					'levels' => 'error, warning, info, trace',
//				],
			],
		],
	],
]
);

return $config;
