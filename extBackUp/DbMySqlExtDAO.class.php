<?php
	/**
	 * Class that operate on table 'db'. Database Mysql.
	 *
	 * @author: http://phpdao.com
	 * @date  : 2013-09-15 16:56
	 */
	class DbMySqlExtDAO extends DbMySqlDAO
	{

		function queryBySigDateGreaterThan($value)
		{
			$sql      = "SELECT * FROM db WHERE SigDate > ?";
			$sqlQuery = new SqlQuery($sql);
			$sqlQuery->set($value);
			return $this->getList($sqlQuery);
		}

		function GetCount()
		{
			$sql      = 'SELECT iD FROM db ORDER BY iD DESC LIMIT 1';
			$sqlQuery = new SqlQuery($sql);
			return $this->querySingleResult($sqlQuery);
		}

		function queryBySIDBetween($StartID, $EndID)
		{
			$sql      = "SELECT * FROM db WHERE ID between ? and ?";
			$sqlQuery = new SqlQuery($sql);
			$sqlQuery->setNumber($StartID);
			$sqlQuery->setNumber($EndID);
			return $this->getList($sqlQuery);
		}
	}

?>