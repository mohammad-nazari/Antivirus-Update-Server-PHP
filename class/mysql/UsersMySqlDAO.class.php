<?php
/**
 * Class that operate on table 'Users'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
class UsersMySqlDAO implements UsersDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return UsersMySql 
	 */
	public function load($usersSerial, $usersActivation){
		$sql = 'SELECT * FROM Users WHERE UsersSerial = ?  AND UsersActivation = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($usersSerial);
		$sqlQuery->setNumber($usersActivation);

		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM Users';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM Users ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param user primary key
 	 */
	public function delete($usersSerial, $usersActivation){
		$sql = 'DELETE FROM Users WHERE UsersSerial = ?  AND UsersActivation = ? ';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($usersSerial);
		$sqlQuery->setNumber($usersActivation);

		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param UsersMySql user
 	 */
	public function insert($user){
		$sql = 'INSERT INTO Users (ID, UsersKey, MACAddress, UsersDate, UsersSerial, UsersActivation) VALUES (?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($user->iD);
		$sqlQuery->set($user->usersKey);
		$sqlQuery->set($user->mACAddress);
		$sqlQuery->set($user->usersDate);

		
		$sqlQuery->setNumber($user->usersSerial);

		$sqlQuery->setNumber($user->usersActivation);

		$this->executeInsert($sqlQuery);	
		//$user->id = $id;
		//return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param UsersMySql user
 	 */
	public function update($user){
		$sql = 'UPDATE Users SET ID = ?, UsersKey = ?, MACAddress = ?, UsersDate = ? WHERE UsersSerial = ?  AND UsersActivation = ? ';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->setNumber($user->iD);
		$sqlQuery->set($user->usersKey);
		$sqlQuery->set($user->mACAddress);
		$sqlQuery->set($user->usersDate);

		
		$sqlQuery->setNumber($user->usersSerial);

		$sqlQuery->setNumber($user->usersActivation);

		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM Users';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByID($value){
		$sql = 'SELECT * FROM Users WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUsersKey($value){
		$sql = 'SELECT * FROM Users WHERE UsersKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByMACAddress($value){
		$sql = 'SELECT * FROM Users WHERE MACAddress = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByUsersDate($value){
		$sql = 'SELECT * FROM Users WHERE UsersDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByID($value){
		$sql = 'DELETE FROM Users WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUsersKey($value){
		$sql = 'DELETE FROM Users WHERE UsersKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByMACAddress($value){
		$sql = 'DELETE FROM Users WHERE MACAddress = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByUsersDate($value){
		$sql = 'DELETE FROM Users WHERE UsersDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return UsersMySql 
	 */
	protected function readRow($row){
		$user = new User();
		
		$user->iD = $row['ID'];
		$user->usersSerial = $row['UsersSerial'];
		$user->usersActivation = $row['UsersActivation'];
		$user->usersKey = $row['UsersKey'];
		$user->mACAddress = $row['MACAddress'];
		$user->usersDate = $row['UsersDate'];

		return $user;
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
	 * @return UsersMySql 
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