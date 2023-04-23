<?php
	/**
	 * Class that operate on table 'Session'. Database Mysql.
	 *
	 * @author: http://phpdao.com
	 * @date  : 2013-09-15 16:56
	 */
	class SessionMySqlExtDAO extends SessionMySqlDAO
	{

		function GetCount()
		{
			$sql      = 'SELECT iD FROM session ORDER BY iD DESC LIMIT 1';
			$sqlQuery = new SqlQuery($sql);
			return $this->querySingleResult($sqlQuery);
		}

		/**
		 * Update record in table
		 *
		 * @param SessionMySql session
		 */
//		public function updateBySessionCod(Session $SessionObjArg)
		public function updateBySessionCod($SessionCode, $SessionUserKey, $SessionAESKey)
		{
			$sql      =
				'UPDATE Session SET SessionUserKey = ?, SessionAESKey = ? WHERE SessionCode = ?';
			$sqlQuery = new SqlQuery($sql);

			$sqlQuery->set($SessionUserKey);
			$sqlQuery->set($SessionAESKey);
			$sqlQuery->set($SessionCode);

			return $this->executeUpdate($sqlQuery);
		}

		/**
		 * Update record in table
		 *
		 * @param SessionMySql session
		 *
		 * @return int
		 */
		//		public function updateBySessionCod(Session $SessionObjArg)
		public function updateBySessionCod2($SessionCode)
		{
			$sql      =
				'UPDATE Session SET SessionActive = \'0\',SessionEndDate = now() WHERE SessionCode = ?';
			$sqlQuery = new SqlQuery($sql);

			$sqlQuery->set($SessionCode);

			return $this->executeUpdate($sqlQuery);
		}
	}

?>