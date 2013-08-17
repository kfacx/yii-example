<?php
/**
 * BasicRelationsPivotTest class file.
 *
 * @author Alexander Scott <magister@kfa.cx>
 * @link https://github.com/kfacx/yii-example
 * @copyright Copyright &copy; 2013 Alexander Scott
 * @license https://github.com/kfacx/yii-example/blob/master/LICENSE
 */

class BasicRelationsPivotTest extends CDbTestCase {
	public $fixtures=array (
		'basicRelationsPivots' => 'BasicRelationsPivot',
		'basicRelationsMains' => 'BasicRelationsMain',
		'basicRelationsManyManies' => 'BasicRelationsManyMany',
	);

	public function testCreate() {

	}
}