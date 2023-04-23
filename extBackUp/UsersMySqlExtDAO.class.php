<?php
	/**
	 * Class that operate on table 'Users'. Database Mysql.
	 *
	 * @author: http://phpdao.com
	 * @date  : 2013-09-15 16:56
	 */
	class UsersMySqlExtDAO extends UsersMySqlDAO
	{

		function GetCount()
		{
			$sql      = 'SELECT iD FROM users ORDER BY iD DESC LIMIT 1';
			$sqlQuery = new SqlQuery($sql);
			return $this->querySingleResult($sqlQuery);
		}

		/**
		 * @param $UserKeyArg
		 * @param $MACAddressArg
		 *
		 * @return UsersMySql
		 */
		public function loadByUserKeyMAC($UserKeyArg, $MACAddressArg)
		{
			$sql      = 'SELECT * FROM Users WHERE UsersKey = ? and MACAddress = ?';
			$sqlQuery = new SqlQuery($sql);
			$sqlQuery->set($UserKeyArg);
			$sqlQuery->set($MACAddressArg);
			return $this->getRow($sqlQuery);
		}
	}

?>