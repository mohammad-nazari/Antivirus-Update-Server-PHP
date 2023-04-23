<?php
/**
 * Class that operate on table 'db'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
class DbMySqlDAO implements DbDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return DbMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM db WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM db';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM db ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param db primary key
 	 */
	public function delete($ID){
		$sql = 'DELETE FROM db WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($ID);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param DbMySql db
 	 */
	public function insert($db){
		$sql = 'INSERT INTO db (SigMalwareName, SigHexName, SigSize, SigDate, SigFlag, SigFlagDate) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($db->sigMalwareName);
		$sqlQuery->set($db->sigHexName);
		$sqlQuery->setNumber($db->sigSize);
		$sqlQuery->set($db->sigDate);
		$sqlQuery->setNumber($db->sigFlag);
		$sqlQuery->set($db->sigFlagDate);

		$id = $this->executeInsert($sqlQuery);	
		$db->iD = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param DbMySql db
 	 */
	public function update($db){
		$sql = 'UPDATE db SET SigMalwareName = ?, SigHexName = ?, SigSize = ?, SigDate = ?, SigFlag = ?, SigFlagDate = ? WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($db->sigMalwareName);
		$sqlQuery->set($db->sigHexName);
		$sqlQuery->setNumber($db->sigSize);
		$sqlQuery->set($db->sigDate);
		$sqlQuery->setNumber($db->sigFlag);
		$sqlQuery->set($db->sigFlagDate);

		$sqlQuery->setNumber($db->iD);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM db';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryBySigMalwareName($value){
		$sql = 'SELECT * FROM db WHERE SigMalwareName = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigHexName($value){
		$sql = 'SELECT * FROM db WHERE SigHexName = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigSize($value){
		$sql = 'SELECT * FROM db WHERE SigSize = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigDate($value){
		$sql = 'SELECT * FROM db WHERE SigDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigFlag($value){
		$sql = 'SELECT * FROM db WHERE SigFlag = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigFlagDate($value){
		$sql = 'SELECT * FROM db WHERE SigFlagDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteBySigMalwareName($value){
		$sql = 'DELETE FROM db WHERE SigMalwareName = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigHexName($value){
		$sql = 'DELETE FROM db WHERE SigHexName = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigSize($value){
		$sql = 'DELETE FROM db WHERE SigSize = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigDate($value){
		$sql = 'DELETE FROM db WHERE SigDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigFlag($value){
		$sql = 'DELETE FROM db WHERE SigFlag = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigFlagDate($value){
		$sql = 'DELETE FROM db WHERE SigFlagDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return DbMySql 
	 */
	protected function readRow($row){
		$db = new Db();
		
		$db->iD = $row['ID'];
		$db->sigMalwareName = $row['SigMalwareName'];
		$db->sigHexName = $row['SigHexName'];
		$db->sigSize = $row['SigSize'];
		$db->sigDate = $row['SigDate'];
		$db->sigFlag = $row['SigFlag'];
		$db->sigFlagDate = $row['SigFlagDate'];

		return $db;
	}
	
	protected function getList($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		$ret = array();
		for($i=0;$i<count($tab);$i++){
			$ret[$i] = $this->readRow($tab[$i]);
		}
		return $ret;
	}
	
	/**
	 * Get row
	 *
	 * @return DbMySql 
	 */
	protected function getRow($sqlQuery){
		$tab = QueryExecutor::execute($sqlQuery);
		if(count($tab)==0){
			return null;
		}
		return $this->readRow($tab[0]);		
	}
	
	/**
	 * Execute sql query
	 */
	protected function execute($sqlQuery){
		return QueryExecutor::execute($sqlQuery);
	}
	
		
	/**
	 * Execute sql query
	 */
	protected function executeUpdate($sqlQuery){
		return QueryExecutor::executeUpdate($sqlQuery);
	}

	/**
	 * Query for one row and one column
	 */
	protected function querySingleResult($sqlQuery){
		return QueryExecutor::queryForString($sqlQuery);
	}

	/**
	 * Insert row to table
	 */
	protected function executeInsert($sqlQuery){
		return QueryExecutor::executeInsert($sqlQuery);
	}
}
?>