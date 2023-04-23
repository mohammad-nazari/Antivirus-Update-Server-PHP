<?php

/**
 * DAOFactory
 * @author: http://phpdao.com
 * @date: ${date}
 */
class DAOFactory{
	
	/**
	 * @return LicenseDAO
	 */
	public static function getLicenseDAO(){
		return new LicenseMySqlExtDAO();
	}

	/**
	 * @return SessionDAO
	 */
	public static function getSessionDAO(){
		return new SessionMySqlExtDAO();
	}

	/**
	 * @return UsersDAO
	 */
	public static function getUsersDAO(){
		return new UsersMySqlExtDAO();
	}

	/**
	 * @return VersionDAO
	 */
	public static function getVersionDAO(){
		return new VersionMySqlExtDAO();
	}

	/**
	 * @return DbDAO
	 */
	public static function getDbDAO(){
		return new DbMySqlExtDAO();
	}

	/**
	 * @return HmdbDAO
	 */
	public static function getHmdbDAO(){
		return new HmdbMySqlExtDAO();
	}


}
?>