<?php
	/**
	 * Class that operate on table 'hmdb'. Database Mysql.
	 *
	 * @author: http://phpdao.com
	 * @date  : 2013-09-15 16:56
	 */
	class HmdbMySqlExtDAO extends HmdbMySqlDAO
	{

		function GetCount()
		{
			$sql      = 'SELECT iD FROM hmdb ORDER BY iD DESC LIMIT 1';
			$sqlQuery = new SqlQuery($sql);
			return $this->querySingleResult($sqlQuery);
		}

		function queryBySIDBetween($StartID, $EndID)
		{
			$sql      = "SELECT * FROM hmdb WHERE ID between ? and ?";
			$sqlQuery = new SqlQuery($sql);
			$sqlQuery->setNumber($StartID);
			$sqlQuery->setNumber($EndID);
			return $this->getList($sqlQuery);
		}
	}

?>