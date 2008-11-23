<?php

/*use Nette\Security\AuthenticationException;*/


/**
 * Users
 *
 * @sql
 *  CREATE TABLE [users] (
 *  [id] INTEGER  NULL PRIMARY KEY,
 *  [username] VARCHAR(50)  UNIQUE NOT NULL,
 *  [password] VARCHAR(50)  NOT NULL,
 *  [real_name] VARCHAR(100)  NOT NULL
 *  );
 */
class Users extends DibiTableX implements /*Nette\Security\*/IAuthenticator
{

	/**
	 * Performs an authentication
	 * @param  array
	 * @return void
	 * @throws AuthenticationException
	 */
	public function authenticate(array $credentials)
	{
		$row = $this->fetch(array('username' => $credentials[self::USERNAME]));
		if (!$row) {
			throw new AuthenticationException('', self::IDENTITY_NOT_FOUND);
		}

		if ($row->password !== $credentials[self::PASSWORD]) {
			throw new AuthenticationException('', self::INVALID_CREDENTIAL);
		}

		unset($row->password);
		return new /*Nette\Security\*/Identity($row->username, array(), $row);
	}

}