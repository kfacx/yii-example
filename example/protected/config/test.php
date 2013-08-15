<?php
return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(
		'components'=>array(
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			/* uncomment the following to provide test database connection
			'db'=>array(
				'connectionString'=>'DSN for test database',
			),
			*/
			'db'=>array(
				'connectionString' => 'mysql:host=localhost;dbname=yii-example-test',
				'emulatePrepare' => true,
				'enableParamLogging'=>true,
				'username' => 'yii-example-test',
				'password' => 'yii-example-test',
				'charset' => 'utf8',
			),
			'log' => array (
				'class' => 'CLogRouter',
				'routes' => array (
					array (
						'class' => 'CFileLogRoute',
						'levels' => 'debug, trace, error, warning',
//						'categories'=>'system.db.*',
//						'logFile'=>'sql.log'
					),
				),
			),
		),
	)
);
