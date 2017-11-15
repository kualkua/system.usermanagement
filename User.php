<?php
/**
 * Created by PhpStorm.
 * User: Artem Grebenik
 * Date: 19.08.15
 * Time: 14:00
 */

namespace Redefinitions\UserManagement;

use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * Class User
 *
 * @package app\System\UserManagement
 */
class User extends \yii\web\User
{
    /**
	 * @param $email
	 * @param $password
	 *
	 * @return \app\System\UserManagement\Demo\Models\User|array|null|\yii\db\ActiveRecord
	 * @throws \yii\base\Exception
	 * @throws \yii\web\ForbiddenHttpException
	 */
	public function loginByEmail($email,$password)
	{
		/* @var $class \app\System\UserManagement\Demo\Models\User */
		$class = $this->identityClass;
		$identity = $class::findIdentityByEmail($email,$password);
		$this->terminateTokens($identity);
		$this->createToken($identity);
		$this->login($identity);
		return $identity;
	}

	/**
	 * @param \app\System\UserManagement\Demo\Models\User $identity
	 *
	 * @return int
	 */
	private function terminateTokens($identity)
	{
		/** @var \app\System\UserManagement\Demo\Models\UserToken $modelClass */
		$modelClass = $identity->getRelation('token')->modelClass;
		return $modelClass::deleteAll([
			'ip' => Yii::$app->request->getUserIP()
		]);
	}

	/**
	 * @param \app\System\UserManagement\Demo\Models\User $identity
	 *
	 * @throws \yii\base\Exception
	 */
	private function createToken(&$identity)
	{
		/** @var \app\System\UserManagement\Demo\Models\UserToken $modelClass */
		$modelClass = $identity->getRelation('token')->modelClass;
		$token = new $modelClass();
		/** @var \app\System\UserManagement\Demo\Models\UserToken $token */

		if(!$token->create($identity->id))
		{
			throw new Exception('Error to create token');
		}
		$identity->populateRelation('token',$token);
	}

}