<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: mohammad
	 * Date: 9/3/13
	 * Time: 2:44 PM
	 * To change this template use File | Settings | File Templates.
	 */

	namespace Update;

	use DAOFactory;
	use Db;
	use Transaction;
	use DbMySqlExtDAO;

	require_once("include_dao.php");
	/**
	 * Class DBMethod
	 *
	 * @package Update
	 */
	class DBMethod
	{
		/**
		 * @var \Transaction
		 */
		private $transction;
		/**
		 * @var \Db
		 */
		private $dBObj;
		/**
		 * @var
		 */
		private $dBFile;
		/**
		 * @var string
		 */
		private $dBData;
		/**
		 * @var
		 */
		private $dBFileAddress;
		/**
		 *
		 */
		public function __construct()
		{
			$this->transction = new Transaction();
			$this->dBObj      = new Db();
			$this->dBData     = "";
		}

		/**
		 *
		 */
		public function __destruct()
		{

		}

		/**
		 * @return null
		 */
		public function GetUpdates()
		{
			if ($this->transction->getConnection())
			{
				return DAOFactory::getDbDAO()->GetCount();
			}
			return NULL;
		}

		/**
		 * @param $StartID
		 * @param $EndID
		 *
		 * @return null|string
		 */
		public function GetUpdateFile($StartID, $EndID)
		{
			$this->dBData = "";
			if ($this->transction->getConnection())
			{
				$this->dBObj = DAOFactory::getDbDAO()->queryBySIDBetween($StartID, $EndID);
				for ($i = 0; $i < count($this->dBObj); $i++)
				{
					$this->dBData .= $this->dBObj[$i]->sigMalwareName;
					$this->dBData .= "=";
					$this->dBData .= $this->dBObj[$i]->sigHexName;
					$this->dBData .= "\n";
				}
				return $this->dBData;
			}
			return NULL;
		}

		/**
		 *
		 */
		public function PrepareFile()
		{
			$file = fopen($this->dBFileAddress,"w+");
			fclose($file);
		}

		/**
		 *
		 */
		public function UpdateFile()
		{
			$file = fopen($this->dBFileAddress,"a+");
			fwrite($file,$this->dBData);
			fclose($file);
		}

		/**
		 * @param $AddressArg
		 */
		public function SetFileAddress($AddressArg)
		{
			$this->dBFileAddress = $AddressArg;
		}

		/**
		 * @return mixed
		 */
		public function GetFileAddress()
		{
			return $this->dBFileAddress;
		}
	}