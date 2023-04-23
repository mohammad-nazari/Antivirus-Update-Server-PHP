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
	use HmDb;
	use Transaction;
	use HmdbMySqlExtDAO;

	/**
	 * Class HmdbMethod
	 *
	 * @package Update
	 */
	class HmdbMethod
	{
		/**
		 * @var \Transaction
		 */
		private $transction;
		/**
		 * @var \HmDb
		 */
		private $hMDBObj;
		/**
		 * @var
		 */
		private $hMDBFile;
		/**
		 * @var
		 */
		private $hMDBData;
		/**
		 * @var
		 */
		private $hMDBFileAddress;

		/**
		 *
		 */
		public function __construct()
		{
			$this->transction = new Transaction();
			$this->hMDBObj     = new Hmdb();
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
				return DAOFactory::getHmdbDAO()->GetCount();
			}
			return NULL;
		}

		/**
		 * @param $StartID
		 * @param $EndID
		 *
		 * @return null|string
		 */
		public function GetUpdateFile($StartID,$EndID)
		{
			$this->hMDBData = "";
			if ($this->transction->getConnection())
			{
				$this->hMDBObj = DAOFactory::getHmdbDAO()->queryBySIDBetween($StartID,$EndID);
				for($i = 0; $i < count($this->hMDBObj); $i++)
				{
					$this->hMDBData .= $this->hMDBObj[$i]->sigMD5;
					$this->hMDBData .= ":";
					$this->hMDBData .= $this->hMDBObj[$i]->sigName;
//					$this->hMDBData .= ";";
					$this->hMDBData .= "\n";
				}
				return $this->hMDBData;
			}
			return NULL;
		}

		/**
		 *
		 */
		public function PrepareFile()
		{
			$file = fopen($this->hMDBFileAddress,"w+");
			fclose($file);
		}

		/**
		 *
		 */
		public function UpdateFile()
		{
			$file = fopen($this->hMDBFileAddress,"a+");
			fwrite($file,$this->hMDBData);
			fclose($file);
		}

		/**
		 * @param $value
		 */
		public function SetFileAddress($value)
		{
			$this->hMDBFileAddress = $value;
		}

		/**
		 * @return mixed
		 */
		public function GetFileAddress()
		{
			return $this->hMDBFileAddress;
		}
	}