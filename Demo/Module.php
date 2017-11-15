<?php
namespace app\System\UserManagement\Demo;
/**
 * Created by IntelliJ IDEA.
 * Author: Andru Cherny
 * E-mail: wiroatom[dogg]gmail[dot]com
 * Date: 29.10.15
 * Time: 13:05
 */
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

/**
 * Class Module
 *
 * @package app\System\UserManagement\Demo
 */
class Module extends \yii\base\Module
{
	/**
	 * @var string
	 */
	public $controllerNamespace = 'app\System\UserManagement\Demo\Controllers';

	/**
	 *
	 */
	public function init()
	{
		parent::init();

		\Yii::$app->urlManager->addRules([
			'user/<controller>/<action>'             => 'userDemo/<controller>/<action>',
			'user/<controller>/<action>/<param:\w+>' => 'userDemo/<controller>/<action>'
		]);

		/*$this->request_config = [
			'role'  =>  [
				'list'  =>  [
					'methods'   =>  [
						'GET'   =>  []
					],
					'headers'   =>  ['validate' =>  false]
				]
			]
		];*/
	}
	public function behaviors()
	{
		if(YII_ENV_DEV) return parent::behaviors();

		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => CompositeAuth::className(),
			'authMethods' => [
				HttpBasicAuth::className(),
				HttpBearerAuth::className(),
				QueryParamAuth::className(),
			],
		];
		return $behaviors;
	}

}
