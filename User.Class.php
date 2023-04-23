<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: mohammad
	 * Date: 9/3/13
	 * Time: 2:48 PM
	 * To change this template use File | Settings | File Templates.
	 */

	namespace Update;

	use DAOFactory;
	use Transaction;
	use User;

	require_once('include_dao.php');
	/**
	 * Class UserMethod
	 *
	 * @package Update
	 */
	class UserMethod
	{
		/**
		 * @var
		 */
		private $userKey;
		/**
		 * @var
		 */
		private $mACAddress;
		/**
		 * @var \Transaction
		 */
		private $mysqlObj;
		/**
		 * @var \User
		 */
		private $userObj;

		/**
		 *
		 */
		public function __construct()
		{
			$this->mysqlObj = new Transaction();
			$this->userObj  = new User();
		}

		/**
		 * @return mixed
		 */
		public function GetUserKey()
		{
			return $this->userKey;
		}

		/**
		 * @param $UserKeyArg
		 */
		public function SetUserKey($UserKeyArg)
		{
			$this->userKey = $UserKeyArg;
		}

		/**
		 * @return mixed
		 */
		public function GetMACAddress()
		{
			return $this->mACAddress;
		}

		/**
		 * @param $MACAddressArg
		 */
		public function SetMACAddress($MACAddressArg)
		{
			$this->mACAddress = $MACAddressArg;
		}

		/**
		 * @param $UserKeyArg
		 * @param $MACAdrressArg
		 *
		 * @return int
		 */
		public function CheckUser($UserKeyArg, $MACAdrressArg)
		{
			$this->userKey    = $UserKeyArg;
			$this->mACAddress = $MACAdrressArg;
			$this->userObj    = DAOFactory::getUsersDAO()->loadByUserKeyMAC($this->userKey, $this->mACAddress);
			if ($this->userObj->iD)
			{
				return $this->userObj->iD;
			}
			else
			{
				return 0;
			}
		}
	}