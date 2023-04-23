<?php
/**
 * Intreface DAO
 *
 * @author: http://phpdao.com
 * @date: 2013-12-16 09:48
 */
interface SessionDAO{

	/**
	 * Get Domain object by primry key
	 *
	 * @param String $id primary key
	 * @Return Session 
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
 	 * @param session primary key
 	 */
	public function delete($ID);
	
	/**
 	 * Insert record to table
 	 *
 	 * @param Session session
 	 */
	public function insert($session);
	
	/**
 	 * Update record in table
 	 *
 	 * @param Session session
 	 */
	public function update($session);	

	/**
	 * Delete all rows
	 */
	public function clean();

	public function queryBySessionCode($value);

	public function queryBySessionUserKey($value);

	public function queryBySessionPrivateKey($value);

	public function queryBySessionPublicKey($value);

	public function queryBySessionAESKey($value);

	public function queryBySessionActive($value);

	public function queryBySessionStartDate($value);

	public function queryBySessionEndDate($value);


	public function deleteBySessionCode($value);

	public function deleteBySessionUserKey($value);

	public function deleteBySessionPrivateKey($value);

	public function deleteBySessionPublicKey($value);

	public function deleteBySessionAESKey($value);

	public function deleteBySessionActive($value);

	public function deleteBySessionStartDate($value);

	public function deleteBySessionEndDate($value);


}
?>