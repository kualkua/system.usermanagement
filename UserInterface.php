<?php
/**
 * Created by IntelliJ IDEA.
 * Author: Andru Cherny
 * E-mail: wiroatom[dogg]gmail[dot]com
 * Date: 29.10.15
 * Time: 10:51
 */

namespace Redefinitions\UserManagement;



/**
 * Interface iUserToken

 *
*@package app\System\UserManagement
 */
interface UserInterface
{
	/**
	 * Finds an identity by the given ID.
	 *
	 * @param string|integer $id the ID to be looked for
	 *
	 * @return UserInterface the identity object that matches the given ID.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentity($id);

	/**
	 * Returns an ID that can uniquely identify a user identity.
	 *
	 * @return string|integer an ID that uniquely identifies a user identity.
	 */
	public function getId();

	/**
	 * Finds an identity by the given token.
	 *
	 * @param mixed $token the token to be looked for
	 * @param mixed $type  the type of the token. The value of this parameter depends on the implementation.
	 *                     For example, [[\yii\filters\auth\HttpBearerAuth]] will set this parameter to be `yii\filters\auth\HttpBearerAuth`.
	 *
	 * @return UserInterface the identity object that matches the given token.
	 * Null should be returned if such an identity cannot be found
	 * or the identity is not in an active state (disabled, deleted, etc.)
	 */
	public static function findIdentityByAccessToken($token, $type = null);

	/**
	 * @param $email
	 * @param $password
	 *
	 * @return UserInterface
	 */
	public static function findIdentityByEmail($email,$password);

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
	public function getAuthKey();
	/**
	 * Validates the given auth key.
	 * This is required if [[User::enableAutoLogin]] is enabled.
	 *
	 * @param string $authKey the given auth key
	 *
	 * @return boolean whether the given auth key is valid.
	 * @see getAuthKey()
	 */
	public function validateAuthKey($authKey);

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getToken();

}