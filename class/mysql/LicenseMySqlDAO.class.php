<?php
/**
 * Class that operate on table 'License'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
class LicenseMySqlDAO implements LicenseDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return LicenseMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM License WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM License';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM License ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param license primary key
 	 */
	public function delete($ID){
		$sql = 'DELETE FROM License WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($ID);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param LicenseMySql license
 	 */
	public function insert($license){
		$sql = 'INSERT INTO License (LicenseSerial, LicenseCode, LicenseDate) VALUES (?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($license->licenseSerial);
		$sqlQuery->set($license->licenseCode);
		$sqlQuery->set($license->licenseDate);

		$id = $this->executeInsert($sqlQuery);	
		$license->iD = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param LicenseMySql license
 	 */
	public function update($license){
		$sql = 'UPDATE License SET LicenseSerial = ?, LicenseCode = ?, LicenseDate = ? WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($license->licenseSerial);
		$sqlQuery->set($license->licenseCode);
		$sqlQuery->set($license->licenseDate);

		$sqlQuery->setNumber($license->iD);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM License';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByLicenseSerial($value){
		$sql = 'SELECT * FROM License WHERE LicenseSerial = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLicenseCode($value){
		$sql = 'SELECT * FROM License WHERE LicenseCode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByLicenseDate($value){
		$sql = 'SELECT * FROM License WHERE LicenseDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByLicenseSerial($value){
		$sql = 'DELETE FROM License WHERE LicenseSerial = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLicenseCode($value){
		$sql = 'DELETE FROM License WHERE LicenseCode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByLicenseDate($value){
		$sql = 'DELETE FROM License WHERE LicenseDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return LicenseMySql 
	 */
	protected function readRow($row){
		$license = new License();
		
		$license->iD = $row['ID'];
		$license->licenseSerial = $row['LicenseSerial'];
		$license->licenseCode = $row['LicenseCode'];
		$license->licenseDate = $row['LicenseDate'];

		return $license;
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
	 * @return LicenseMySql 
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