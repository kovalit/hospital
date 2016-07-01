<?php

Yii::setPathOfAlias('root', realpath(__DIR__ . '/../..'));
Yii::setPathOfAlias('publicPath', realpath(__DIR__ . '/../../public'));

return [
	'basePath'       => __DIR__ . DIRECTORY_SEPARATOR . '..',
	'name'           => 'Hospital',

	// preloading 'log' component
	'preload'        => ['log'],

	// autoloading model and component classes
	'import'         => [
		'application.controllers.BaseController',
		'application.models.*',
		'application.components.*',
	],

	'language'       => 'ru',
	'sourceLanguage' => 'ru',

	// application components
	'components'     => [
		'urlManager'    => [
			'urlFormat'        => 'path',
			'caseSensitive'    => true,
			'matchValue'       => true,
			'showScriptName'   => false,
			'urlSuffix'        => '',
			'useStrictParsing' => true,
			'rules'            => require('_routes.php'),
		],
		'errorHandler'  => [
			'errorAction' => 'main/error',
		],
		'log'           => [
			'class'  => 'CLogRouter',
			'routes' => [
				[
					'class'  => 'CFileLogRoute',
					'levels' => 'error, warning',
				],
			],
		],
		'storageSrc'    => [
			'class' => 'application.components.FileStorageComponent',
			'path'  => 'root.storage',
		],
		'storageCached' => [
			'class' => 'application.components.FileStorageComponent',
			'path'  => 'root.public.images.s',
		],

		'user' => [
			'class'          => 'application.components.WebUser',
			'loginUrl'       => ['users/signIn'],
			'allowAutoLogin' => true,
			'identityCookie' => [
				'path'   => '/',
				'domain' => '.' . (array_key_exists('HTTP_HOST', $_SERVER)? $_SERVER['HTTP_HOST']: null),
			],
			'authTimeout'    => 7776000, // 3 month in seconds
		],
		'authManager' => [
			'class'        => 'application.components.AuthManager',
		],
		'cache' => [
			'class' => 'CFileCache',
		],
	],

	'params'         => [
		'supportEmail'              => 'kovalit@mail.ru',
		'languages'                 => require('_languages.php'),
	],
];
