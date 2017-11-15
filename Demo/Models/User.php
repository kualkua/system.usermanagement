<?php
namespace app\System\UserManagement\Demo\Models;

use app\System\UserManagement\UserInterface;
use Yii;
use yii\base\InvalidParamException;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use yii\web\IdentityInterface;
/**
 * Created by IntelliJ IDEA.
 * Author: Andru Cherny
 * E-mail: wiroatom[dogg]gmail[dot]com
 * Date: 29.10.15
 * Time: 13:18
 */

/**
 * Class User

*
 * @property UserToken token
 * @package app\System\UserManagement\Demo\Models
 */
class User extends \app\models\AuthUsers implements UserInterface, IdentityInterface
{

	/**
	 * Finds an identity by the given ID.
	 *
	 * @param string|integer $id the ID to be looked for
	 *
	 * @return IdentityInterface the identity object that matches the given ID.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentity($id)
	{

	}

	/**
	 * Returns an ID that can uniquely identify a user identity.
	 *
	 * @return string|integer an ID that uniquely identifies a user identity.
	 */
	public function getId()
	{

}

	/**
	 * Finds an identity by the given token.
	 *
	 * @param mixed $token the token to be looked for
	 * @param mixed $type  the type of the token. The value of this parameter depends on the implementation.
	 *                     For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
	 *
	 * @return IdentityInterface the identity object that matches the given token.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentityByAccessToken($token, $type = null)
	{
		switch($type)
		{

			case 'system':
				return self::findByAuthToken($token);
				break;
			case HttpBearerAuth::className():
				var_dump($token);
			break;
			case \yii\filters\auth\QueryParamAuth::className():
				var_dump($token);
				die();
			break;
			default:
				throw new InvalidParamException('Identity by type "'.$type.'"  not implemented');
		}

	}

	/**
	 * @param $params
	 *
	 * @return User
	 */
	private static function findByAuthToken($params){
		return self::find()->joinWith(['token'=>function ($query) use ($params) {
			/** @var \yii\db\ActiveQuery $query */
			$query->where($params);
		}])->one();
	}


	public static function findIdentityByEmail($email,$password)
	{
		$user = self::find()->where(['email' => $email])->one();
		/** @var User $user */
		if(!$user)
		{
			throw new ForbiddenHttpException('User not found');
		}
		elseif($user->fired_time !== 0)
		{
			throw new ForbiddenHttpException('This user has fired');
		}
		/*var_dump(Yii::$app->getSecurity()->generatePasswordHash($password));
		die();*/
		if(!Yii::$app->getSecurity()->validatePassword($password, $user->password))
		{
			throw new ForbiddenHttpException('Wrong password');
		}
		return $user;
	}

	/**
	 * Returns a key that can be used to check the validity of a given identity ID.
	 * The key should be unique for each individual user, and should be persistent
	 * so that it can be used to check the validity of the user identity.
	 * The space of such keys should be big enough to defeat potential identity attacks.
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 *
	 * @return string a key that is used to check the validity of a given identity ID.
	 * @see validateAuthKey()
	 */
	public function getAuthKey()
	{
		$this->token->token;
	}

	/**
	 * Validates the given auth key.
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 *
	 * @param string $authKey the given auth key
	 *
	 * @return boolean whether the given auth key is valid.
	 * @see getAuthKey()
	 */
	public function validateAuthKey($authKey)
	{
		return true;
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getToken()
	{
		return $this->hasOne(UserToken::className(), ['user_id' => 'id']);
	}
}