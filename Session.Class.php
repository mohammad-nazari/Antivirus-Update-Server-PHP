<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: mohammad
	 * Date: 9/3/13
	 * Time: 2:47 PM
	 * To change this template use File | Settings | File Templates.
	 */

	namespace Update;

	use DAOFactory;
	use Session;
	use Transaction;
	use Update\AESClass;

	require_once("include_dao.php");
	require_once('AES.Class.php');
	/**
	 * Class SessionMethod
	 *
	 * @package Update
	 */
	class SessionMethod
	{
		/**
		 * @var \Session
		 */
		private $sessionObj;
		/**
		 * @var AESClass
		 */
		private $aesObj;
		/**
		 * @var array
		 */
		private $sessionColumn = array('ID'                => "", 'SessionCode' => "", 'SessionUserKey' => "",
									   'SessionPrivateKey' => "", 'SessionPublicKey' => "", 'SessionAESKey' => "",
									   'SessionActive'     => 1, 'SessionStartDate' => "", 'SessionEndDate' => "");

		/**
		 *
		 */
		public function __construct()
		{
			$this->sessionObj  = new Session();
			$this->mysqlObject = new Transaction();
			$this->aesObj      = new AESClass();
		}

		/**
		 *
		 */
		public function __destruct()
		{
		}

		/**
		 * @return bool
		 */
		public function CreateSession()
		{
			$this->CreateSessionCode();

			$this->CreateRSAKeys();

			if ($this->mysqlObject->getConnection()) //Connect to database
			{

				$this->SetInsertArguments();

				if (DAOFactory::getSessionDAO()->insert($this->sessionObj)) //Insert Session in table
				{
					$this->mysqlObject->commit();
					return TRUE;
				}
				else
				{
					return FALSE;
				}
			}
			else
			{
				return FALSE;
			}
		}

		/**
		 *
		 * For create new Session we just need have :
		 * Session Code, Session private Key, Session Public Key and Session Start Date
		 *
		 * Set Session Column Values
		 */
		private function SetInsertArguments()
		{
			$this->sessionObj->sessionActive    = 1;
			$this->sessionObj->sessionStartDate = date('Y-m-d H:m:s');
		}

		/**
		 * Create a Random Session Code
		 */
		private function CreateSessionCode()
		{
			$this->sessionObj->sessionCode = $this->generateRandomString(); //Generate Random Key
		}

		/**
		 *
		 */
		private function CreateRSAKeys()
		{
			$this->aesObj->makeKeyPair();
			$this->SetPublicKey($this->aesObj->GetPublicKey());
			$this->SetPrivateKey($this->aesObj->GetPrivateKey());
		}

		/**
		 * @param $PkArg
		 */
		public function SetPublicKey($PkArg)
		{
			$this->sessionObj->sessionPublicKey = $PkArg;
		}

		/**
		 * @return mixed
		 */
		public function GetPublicKey()
		{
			return $this->sessionObj->sessionPublicKey;
		}

		/**
		 * @return mixed
		 */
		public function GetPrivateKey()
		{
			return $this->sessionObj->sessionPrivateKey;
		}

		/**
		 * @param $PrArg
		 */
		public function SetPrivateKey($PrArg)
		{
			$this->sessionObj->sessionPrivateKey = $PrArg;
		}

		/**
		 * @param $SessionCodeArg
		 *
		 * @return array
		 */
		public function SelectSession()
		{
			return $this->sessionColumn;
		}

		/**
		 *
		 */
		public function CloseSession($sessionCode)
		{
			$result = DAOFactory::getSessionDAO()->updateBySessionCod2($sessionCode);
			if ($result)
			{
				$this->mysqlObject->commit();
			}
			return $result;
		}

		/**
		 *
		 */
		public function UpdateSession($sessionCode, $sessionUserKey, $sessionAESKey)
		{
			$result = DAOFactory::getSessionDAO()->updateBySessionCod($sessionCode, $sessionUserKey, $sessionAESKey);
			if ($result)
			{
				$this->mysqlObject->commit();
			}
			return $result;
		}

		/**
		 * @return mixed
		 */
		public function GetSessionCode()
		{
			return $this->sessionObj->sessionCode;
		}

		/**
		 * @param $value
		 *
		 */
		public function SetSessionCode($value)
		{
			$this->sessionObj->sessionCode = $value;
		}

		/**
		 * @return mixed
		 */
		public function GetEncryptionKey()
		{
			return $this->sessionObj->sessionAESKey;
		}

		/**
		 * @param $value
		 *
		 */
		public function SetEncryptionKey($value)
		{
			$this->sessionObj->sessionAESKey = $value;
		}

		/**
		 * @return mixed
		 */
		public function GetUserKey()
		{
			return $this->sessionObj->sessionUserKey;
		}

		/**
		 * @param $value
		 *
		 */
		public function SetUserKey($value)
		{
			$this->sessionObj->sessionUserKey = $value;
		}

		/**
		 * @param int $length
		 *
		 * @return string
		 */
		function generateRandomString($length = 20)
		{
			$characters   = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$randomString = '';
			for ($i = 0; $i < $length; $i++)
			{
				$randomString .= $characters[rand(0, strlen($characters) - 1)];
			}
			return $randomString;
		}

		/**
		 * @param $SessionCodeArg
		 *
		 * @return array|null
		 */
		public function SearchSession($SessionCodeArg)
		{
			$this->sessionObj = DAOFactory::getSessionDAO()->queryBySessionCode($SessionCodeArg);
			if ($this->sessionObj && $this->sessionObj[0]->iD)
			{
				if ($this->sessionObj[0]->sessionActive)
				{
					return array('PrivateKey' => $this->sessionObj[0]->sessionPrivateKey, 'PublicKey' =>  $this->sessionObj[0]->sessionPublicKey, 'UserKey' => $this->sessionObj[0]->sessionUserKey, 'EncryptKey' => $this->sessionObj[0]->sessionAESKey);
				}
				else
				{
					return NULL;
				}
			}
			else
			{
				return NULL;
			}
		}
	}