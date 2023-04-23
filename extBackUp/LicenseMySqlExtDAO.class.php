<?php
	/**
	 * Class that operate on table 'License'. Database Mysql.
	 *
	 * @author: http://phpdao.com
	 * @date  : 2013-09-15 16:56
	 */
	class LicenseMySqlExtDAO extends LicenseMySqlDAO
	{

		function GetCount()
		{
			$sql      = 'SELECT iD FROM license ORDER BY iD DESC LIMIT 1';
			$sqlQuery = new SqlQuery($sql);
			return $this->querySingleResult($sqlQuery);
		}
	}

?>