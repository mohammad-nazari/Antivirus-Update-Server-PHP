<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
interface DbDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Db 
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
 	 * @param db primary key
 	 */
	public function delete($ID);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Db db
 	 */
	public function insert($db);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Db db
 	 */
	public function update($db);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryBySigMalwareName($value);

	public function queryBySigHexName($value);

	public function queryBySigSize($value);

	public function queryBySigDate($value);

	public function queryBySigFlag($value);

	public function queryBySigFlagDate($value);


	public function deleteBySigMalwareName($value);

	public function deleteBySigHexName($value);

	public function deleteBySigSize($value);

	public function deleteBySigDate($value);

	public function deleteBySigFlag($value);

	public function deleteBySigFlagDate($value);


}
?>