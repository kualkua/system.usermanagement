<?php
/**
 * Created by IntelliJ IDEA.
 * Author: Andru Cherny
 * E-mail: wiroatom[dogg]gmail[dot]com
 * Date: 29.10.15
 * Time: 13:23
 */

namespace app\System\UserManagement\Demo\Models;

use app\models\AuthUsersTokens;
use app\System\UserManagement\UserTokenInterface;
use Yii;

/**
 * Class UserToken
 *
 * @package app\System\UserManagement\Demo\Models
 */
class UserToken extends AuthUsersTokens implements UserTokenInterface
{

	/**
    * @param  $user_id
	 *
	 * @return bool
	 */
	public function create($user_id)
	{
		$this->isNewRecord = true;
		$this->setAttributes([
			'user_id'    => $user_id,
			'token'      => Yii::$app->getSecurity()->generateRandomString(),
            'session_id' => 'session_id',
            'ip'         => Yii::$app->request->getUserIP(),
            'expired'    => time() + 60 * 7200
		]);
		return $this->save();
	}

	/**
	 * @return bool
	 */
	public function validateToken()
	{

	}

	/**
	 * @return bool
	 */
	public function updateExpired()
	{

	}


	public function deleteToken()
	{
		$this->delete();
	}


	public function isValid()
	{
		return true;
	}
}