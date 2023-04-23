<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
interface VersionDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Version 
	 */
	public function load($id);

	/**
	 * Get all records from table
	 */
	public function queryAll();
	
	/**
	 * Get all records from table ordered by field
	 * @Param $orderColumn column name
	 */
	public function queryAllOrderBy($orderColumn);
	
	/**
 	 * Delete record from table
 	 * @param version primary key
 	 */
	public function delete($ID);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Version version
 	 */
	public function insert($version);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Version version
 	 */
	public function update($version);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByFile($value);

	public function queryByFileName($value);

	public function queryByFileVersion($value);

	public function queryByFileMD5($value);

	public function queryByFileType($value);

	public function queryByFileSize($value);

	public function queryByFilePlaceLocation($value);

	public function queryByFileAction($value);

	public function queryByFileDate($value);


	public function deleteByFile($value);

	public function deleteByFileName($value);

	public function deleteByFileVersion($value);

	public function deleteByFileMD5($value);

	public function deleteByFileType($value);

	public function deleteByFileSize($value);

	public function deleteByFilePlaceLocation($value);

	public function deleteByFileAction($value);

	public function deleteByFileDate($value);


}
?>