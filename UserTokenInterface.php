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
interface UserTokenInterface
{

	/**
	 * @param  $user_id
	 *
	 * @return bool
	 */
	public function create($user_id);

	/**
	 * @return bool
	 */
	public function validateToken();

	/**
	 * @return bool
	 */
	public function updateExpired();

	public function deleteToken();

    public function closeSession();

}