<?php
/**
 * Class that operate on table 'Version'. Database Mysql.
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
class VersionMySqlDAO implements VersionDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @return VersionMySql 
	 */
	public function load($id){
		$sql = 'SELECT * FROM Version WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($id);
		return $this->getRow($sqlQuery);
	}

	/**
	 * Get all records from table
	 */
	public function queryAll(){
		$sql = 'SELECT * FROM Version';
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
	 * Get all records from table ordered by field
	 *
	 * @param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn){
		$sql = 'SELECT * FROM Version ORDER BY '.$orderColumn;
		$sqlQuery = new SqlQuery($sql);
		return $this->getList($sqlQuery);
	}
	
	/**
 	 * Delete record from table
 	 * @param version primary key
 	 */
	public function delete($ID){
		$sql = 'DELETE FROM Version WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($ID);
		return $this->executeUpdate($sqlQuery);
	}
	
	/**
 	 * Insert record to table
 	 *
 	 * @param VersionMySql version
 	 */
	public function insert($version){
		$sql = 'INSERT INTO Version (File, FileName, FileVersion, FileMD5, FileType, FileSize, FilePlaceLocation, FileAction, FileDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($version->file);
		$sqlQuery->set($version->fileName);
		$sqlQuery->set($version->fileVersion);
		$sqlQuery->set($version->fileMD5);
		$sqlQuery->set($version->fileType);
		$sqlQuery->setNumber($version->fileSize);
		$sqlQuery->set($version->filePlaceLocation);
		$sqlQuery->set($version->fileAction);
		$sqlQuery->set($version->fileDate);

		$id = $this->executeInsert($sqlQuery);	
		$version->iD = $id;
		return $id;
	}
	
	/**
 	 * Update record in table
 	 *
 	 * @param VersionMySql version
 	 */
	public function update($version){
		$sql = 'UPDATE Version SET File = ?, FileName = ?, FileVersion = ?, FileMD5 = ?, FileType = ?, FileSize = ?, FilePlaceLocation = ?, FileAction = ?, FileDate = ? WHERE ID = ?';
		$sqlQuery = new SqlQuery($sql);
		
		$sqlQuery->set($version->file);
		$sqlQuery->set($version->fileName);
		$sqlQuery->set($version->fileVersion);
		$sqlQuery->set($version->fileMD5);
		$sqlQuery->set($version->fileType);
		$sqlQuery->setNumber($version->fileSize);
		$sqlQuery->set($version->filePlaceLocation);
		$sqlQuery->set($version->fileAction);
		$sqlQuery->set($version->fileDate);

		$sqlQuery->setNumber($version->iD);
		return $this->executeUpdate($sqlQuery);
	}

	/**
 	 * Delete all rows
 	 */
	public function clean(){
		$sql = 'DELETE FROM Version';
		$sqlQuery = new SqlQuery($sql);
		return $this->executeUpdate($sqlQuery);
	}

	public function queryByFile($value){
		$sql = 'SELECT * FROM Version WHERE File = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFileName($value){
		$sql = 'SELECT * FROM Version WHERE FileName = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFileVersion($value){
		$sql = 'SELECT * FROM Version WHERE FileVersion = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFileMD5($value){
		$sql = 'SELECT * FROM Version WHERE FileMD5 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFileType($value){
		$sql = 'SELECT * FROM Version WHERE FileType = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFileSize($value){
		$sql = 'SELECT * FROM Version WHERE FileSize = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFilePlaceLocation($value){
		$sql = 'SELECT * FROM Version WHERE FilePlaceLocation = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFileAction($value){
		$sql = 'SELECT * FROM Version WHERE FileAction = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}

	public function queryByFileDate($value){
		$sql = 'SELECT * FROM Version WHERE FileDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->getList($sqlQuery);
	}


	public function deleteByFile($value){
		$sql = 'DELETE FROM Version WHERE File = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFileName($value){
		$sql = 'DELETE FROM Version WHERE FileName = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFileVersion($value){
		$sql = 'DELETE FROM Version WHERE FileVersion = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFileMD5($value){
		$sql = 'DELETE FROM Version WHERE FileMD5 = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFileType($value){
		$sql = 'DELETE FROM Version WHERE FileType = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFileSize($value){
		$sql = 'DELETE FROM Version WHERE FileSize = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->setNumber($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFilePlaceLocation($value){
		$sql = 'DELETE FROM Version WHERE FilePlaceLocation = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFileAction($value){
		$sql = 'DELETE FROM Version WHERE FileAction = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}

	public function deleteByFileDate($value){
		$sql = 'DELETE FROM Version WHERE FileDate = ?';
		$sqlQuery = new SqlQuery($sql);
		$sqlQuery->set($value);
		return $this->executeUpdate($sqlQuery);
	}


	
	/**
	 * Read row
	 *
	 * @return VersionMySql 
	 */
	protected function readRow($row){
		$version = new Version();
		
		$version->iD = $row['ID'];
		$version->file = $row['File'];
		$version->fileName = $row['FileName'];
		$version->fileVersion = $row['FileVersion'];
		$version->fileMD5 = $row['FileMD5'];
		$version->fileType = $row['FileType'];
		$version->fileSize = $row['FileSize'];
		$version->filePlaceLocation = $row['FilePlaceLocation'];
		$version->fileAction = $row['FileAction'];
		$version->fileDate = $row['FileDate'];

		return $version;
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
	 * @return VersionMySql 
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