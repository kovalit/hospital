<?php

return [
	'guest'     => [
		'type'        => CAuthItem::TYPE_ROLE,
		'description' => 'Guest',
		'bizRule'     => null,
		'data'        => null
	],
	'admin'     => [
		'type'        => CAuthItem::TYPE_ROLE,
		'description' => 'Administrator',
		'bizRule'     => null,
		'data'        => null
	],
	'moderator' => [
		'type'        => CAuthItem::TYPE_ROLE,
		'description' => 'Moderator',
		'bizRule'     => null,
		'data'        => null
	],
];
