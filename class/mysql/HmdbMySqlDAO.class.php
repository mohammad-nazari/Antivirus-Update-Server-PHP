<?php
/**
 * Class that operate on table 'hmdb'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
class HmdbMySqlDAO implements HmdbDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return HmdbMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM hmdb WHERE SigMD5 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM hmdb';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM hmdb ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param hmdb primary key
 	 */
	public function delete($SigMD5){
		$sql = 'DELETE FROM hmdb WHERE SigMD5 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($SigMD5);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param HmdbMySql hmdb
 	 */
	public function insert($hmdb){
		$sql = 'INSERT INTO hmdb (ID, SigName, SigSize, SigDate, SigFlag, SigFlagDate) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($hmdb->iD);
		$sqlQuery->set($hmdb->sigName);
		$sqlQuery->setNumber($hmdb->sigSize);
		$sqlQuery->set($hmdb->sigDate);
		$sqlQuery->setNumber($hmdb->sigFlag);
		$sqlQuery->set($hmdb->sigFlagDate);

		$id = $this->executeInsert($sqlQuery);	
		$hmdb->sigMD5 = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param HmdbMySql hmdb
 	 */
	public function update($hmdb){
		$sql = 'UPDATE hmdb SET ID = ?, SigName = ?, SigSize = ?, SigDate = ?, SigFlag = ?, SigFlagDate = ? WHERE SigMD5 = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($hmdb->iD);
		$sqlQuery->set($hmdb->sigName);
		$sqlQuery->setNumber($hmdb->sigSize);
		$sqlQuery->set($hmdb->sigDate);
		$sqlQuery->setNumber($hmdb->sigFlag);
		$sqlQuery->set($hmdb->sigFlagDate);

		$sqlQuery->set($hmdb->sigMD5);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM hmdb';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByID($value){
		$sql = 'SELECT * FROM hmdb WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigName($value){
		$sql = 'SELECT * FROM hmdb WHERE SigName = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigSize($value){
		$sql = 'SELECT * FROM hmdb WHERE SigSize = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigDate($value){
		$sql = 'SELECT * FROM hmdb WHERE SigDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigFlag($value){
		$sql = 'SELECT * FROM hmdb WHERE SigFlag = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySigFlagDate($value){
		$sql = 'SELECT * FROM hmdb WHERE SigFlagDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByID($value){
		$sql = 'DELETE FROM hmdb WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigName($value){
		$sql = 'DELETE FROM hmdb WHERE SigName = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigSize($value){
		$sql = 'DELETE FROM hmdb WHERE SigSize = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigDate($value){
		$sql = 'DELETE FROM hmdb WHERE SigDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigFlag($value){
		$sql = 'DELETE FROM hmdb WHERE SigFlag = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySigFlagDate($value){
		$sql = 'DELETE FROM hmdb WHERE SigFlagDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return HmdbMySql 
	 */
	protected function readRow($row){
		$hmdb = new Hmdb();
		
		$hmdb->iD = $row['ID'];
		$hmdb->sigMD5 = $row['SigMD5'];
		$hmdb->sigName = $row['SigName'];
		$hmdb->sigSize = $row['SigSize'];
		$hmdb->sigDate = $row['SigDate'];
		$hmdb->sigFlag = $row['SigFlag'];
		$hmdb->sigFlagDate = $row['SigFlagDate'];

		return $hmdb;
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
	 * @return HmdbMySql 
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