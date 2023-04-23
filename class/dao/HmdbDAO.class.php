<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
interface HmdbDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Hmdb 
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
 	 * @param hmdb primary key
 	 */
	public function delete($SigMD5);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Hmdb hmdb
 	 */
	public function insert($hmdb);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Hmdb hmdb
 	 */
	public function update($hmdb);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByID($value);

	public function queryBySigName($value);

	public function queryBySigSize($value);

	public function queryBySigDate($value);

	public function queryBySigFlag($value);

	public function queryBySigFlagDate($value);


	public function deleteByID($value);

	public function deleteBySigName($value);

	public function deleteBySigSize($value);

	public function deleteBySigDate($value);

	public function deleteBySigFlag($value);

	public function deleteBySigFlagDate($value);


}
?>