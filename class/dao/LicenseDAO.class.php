<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
interface LicenseDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return License 
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
 	 * @param license primary key
 	 */
	public function delete($ID);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param License license
 	 */
	public function insert($license);
	
	/**
 	 * Update record in table
 	 *
 	 * @param License license
 	 */
	public function update($license);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryByLicenseSerial($value);

	public function queryByLicenseCode($value);

	public function queryByLicenseDate($value);


	public function deleteByLicenseSerial($value);

	public function deleteByLicenseCode($value);

	public function deleteByLicenseDate($value);


}
?>