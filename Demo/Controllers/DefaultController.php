<?php
/**
 * Created by IntelliJ IDEA.
 * Author: Andru Cherny
 * E-mail: wiroatom[dogg]gmail[dot]com
 * Date: 29.10.15
 * Time: 13:26
 */

namespace app\System\UserManagement\Demo\Controllers;

use yii\web\Controller;

/**
 * Class DefaultController
 *
 *@package app\System\UserManagement\Demo\Controllers
 */
class DefaultController extends Controller
{

	public function actionIndex(){
		//\Yii::$app->user->token()->set(['token'=>'123'])->validate();
		//$res = \Yii::$app->user->login();
		//$identyty =\Yii::$app->user->loginByAccessToken(['token' =>'123'],'system');
		//$identyty =\Yii::$app->user->loginByEmail('admin@adstat3.uct.ua','123');
		var_dump(\Yii::$app->user);
	}
}