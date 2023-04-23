<?php
/**
 * Class that operate on table 'Session'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
class SessionMySqlDAO implements SessionDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return SessionMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM Session WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM Session';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM Session ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param session primary key
 	 */
	public function delete($ID){
		$sql = 'DELETE FROM Session WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($ID);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param SessionMySql session
 	 */
	public function insert($session){
		$sql = 'INSERT INTO Session (SessionCode, SessionUserKey, SessionPrivateKey, SessionPublicKey, SessionAESKey, SessionActive, SessionStartDate, SessionEndDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($session->sessionCode);
		$sqlQuery->set($session->sessionUserKey);
		$sqlQuery->set($session->sessionPrivateKey);
		$sqlQuery->set($session->sessionPublicKey);
		$sqlQuery->set($session->sessionAESKey);
		$sqlQuery->setNumber($session->sessionActive);
		$sqlQuery->set($session->sessionStartDate);
		$sqlQuery->set($session->sessionEndDate);

		$id = $this->executeInsert($sqlQuery);	
		$session->iD = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param SessionMySql session
 	 */
	public function update($session){
		$sql = 'UPDATE Session SET SessionCode = ?, SessionUserKey = ?, SessionPrivateKey = ?, SessionPublicKey = ?, SessionAESKey = ?, SessionActive = ?, SessionStartDate = ?, SessionEndDate = ? WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($session->sessionCode);
		$sqlQuery->set($session->sessionUserKey);
		$sqlQuery->set($session->sessionPrivateKey);
		$sqlQuery->set($session->sessionPublicKey);
		$sqlQuery->set($session->sessionAESKey);
		$sqlQuery->setNumber($session->sessionActive);
		$sqlQuery->set($session->sessionStartDate);
		$sqlQuery->set($session->sessionEndDate);

		$sqlQuery->setNumber($session->iD);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM Session';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryBySessionCode($value){
		$sql = 'SELECT * FROM Session WHERE SessionCode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySessionUserKey($value){
		$sql = 'SELECT * FROM Session WHERE SessionUserKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySessionPrivateKey($value){
		$sql = 'SELECT * FROM Session WHERE SessionPrivateKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySessionPublicKey($value){
		$sql = 'SELECT * FROM Session WHERE SessionPublicKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySessionAESKey($value){
		$sql = 'SELECT * FROM Session WHERE SessionAESKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySessionActive($value){
		$sql = 'SELECT * FROM Session WHERE SessionActive = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySessionStartDate($value){
		$sql = 'SELECT * FROM Session WHERE SessionStartDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryBySessionEndDate($value){
		$sql = 'SELECT * FROM Session WHERE SessionEndDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteBySessionCode($value){
		$sql = 'DELETE FROM Session WHERE SessionCode = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySessionUserKey($value){
		$sql = 'DELETE FROM Session WHERE SessionUserKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySessionPrivateKey($value){
		$sql = 'DELETE FROM Session WHERE SessionPrivateKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySessionPublicKey($value){
		$sql = 'DELETE FROM Session WHERE SessionPublicKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySessionAESKey($value){
		$sql = 'DELETE FROM Session WHERE SessionAESKey = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySessionActive($value){
		$sql = 'DELETE FROM Session WHERE SessionActive = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySessionStartDate($value){
		$sql = 'DELETE FROM Session WHERE SessionStartDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteBySessionEndDate($value){
		$sql = 'DELETE FROM Session WHERE SessionEndDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return SessionMySql 
	 */
	protected function readRow($row){
		$session = new Session();
		
		$session->iD = $row['ID'];
		$session->sessionCode = $row['SessionCode'];
		$session->sessionUserKey = $row['SessionUserKey'];
		$session->sessionPrivateKey = $row['SessionPrivateKey'];
		$session->sessionPublicKey = $row['SessionPublicKey'];
		$session->sessionAESKey = $row['SessionAESKey'];
		$session->sessionActive = $row['SessionActive'];
		$session->sessionStartDate = $row['SessionStartDate'];
		$session->sessionEndDate = $row['SessionEndDate'];

		return $session;
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
	 * @return SessionMySql 
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