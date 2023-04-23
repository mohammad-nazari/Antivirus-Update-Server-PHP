<?php
	/**
	 * Class that operate on table 'Version'. Database Mysql.
	 *
	 * @author: http://phpdao.com
	 * @date  : 2013-09-15 16:56
	 */
	class VersionMySqlExtDAO extends VersionMySqlDAO
	{

		function GetCount()
		{
			$sql      = 'SELECT iD FROM version ORDER BY iD DESC LIMIT 1';
			$sqlQuery = new SqlQuery($sql);
			return $this->querySingleResult($sqlQuery);
		}

		public function queryByFileNameType($value1,$value2){
			$sql = 'SELECT * FROM Version WHERE FileName = ? and FileType = ?';
			$sqlQuery = new SqlQuery($sql);
			$sqlQuery->set($value1);
			$sqlQuery->set($value2);
			return $this->getList($sqlQuery);
		}
	}

?>