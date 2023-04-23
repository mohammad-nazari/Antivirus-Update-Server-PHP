<?php
	require_once('AES.Class.php');
	use Update\AESClass;

	define("RSA_KEYLEN", 2048);
	define("AES_KEYLEN", 128);
	/**
	 * Created by JetBrains PhpStorm.
	 * User: mohammad
	 * Date: 9/19/13
	 * Time: 12:19 PM
	 * To change this template use File | Settings | File Templates.
	 */
	class Update
	{
		/**
		 * @var
		 */
		private $publicKey;
		/**
		 * @var
		 */
		private $privateKey;
		/**
		 * @var
		 */
		private $encryptKey;
		/**
		 * @var
		 */
		private $pre_MasterKey;
		/**
		 * @var
		 */
		private $SessionCode;
		/**
		 * @var
		 */
		private $dBVersion;
		/**
		 * @var
		 */
		private $hMDBVersion;
		/**
		 * @var
		 */
		private $dBCount;
		/**
		 * @var
		 */
		private $dBFile;
		/**
		 * @var
		 */
		private $hMDBCount;
		/**
		 * @var
		 */
		private $hMDBFile;
		/**
		 * @var
		 */
		private $versionListFile;
		/**
		 * @var
		 */
		private $versionFile;
		/**
		 * @var
		 */
		private $userKey;
		/**
		 * @var
		 */
		private $mACAddress;
		/**
		 * @var
		 */
		private $active;
		/**
		 * @var
		 */
		private $erroCode;
		/**
		 * @var
		 */
		private $erroNumber;
		/**
		 * @var Update\AESClass
		 */
		private $aesObject;

		/**
		 *
		 */
		public
		function __Construct()
		{
			$this->aesObject = new AESClass();
		}

		/**
		 *
		 */
		public
		function CreateEncryptKey()
		{
			$this->aesObject->generatePassword();
			$this->pre_MasterKey = $this->aesObject->GetPassword();
			$this->encryptKey = $this->Make16BitKey($this->pre_MasterKey);
		}

		/**
		 * @param $Path
		 *
		 * @return string
		 */
		public
		function Make16BitKey($Path)
		{
			$pmKeyLen = strlen($Path);
			if ($pmKeyLen)
			{
				// First MD5 from pre_master key
				$md5Out = md5($Path);
				$md5Out = hex2bin($md5Out);

				$first = ord($md5Out[15]);
				$limit = ord($md5Out[13]) * ord($md5Out[14]);

				$first = ($first < $pmKeyLen ? $first : $first % $pmKeyLen);
				$limit = ($limit < ($pmKeyLen - $first) ? $limit : $limit % ($pmKeyLen - $first));

				// Second mD5 from first MD5 of pre_master Key in a limited string of pre_master Key
				$Path = substr($Path, $first, $limit);

				//Secend mD5 from first MD5 of pre_master Key
				$decryptionKey = hex2bin(md5($Path));


				// Length of AES key is 256 bit(32 byte) else is 128 bit(16 byte)
				if((AES_KEYLEN / 8) == 32)
				{
					$decryptionKey .= hex2bin(md5($Path));
				}

				//$decryptionKey = '0123456789abcdef0123456789abcdef';
				return $decryptionKey;
			}
			else
			{
				return "";
			}
		}

		/**
		 * @return mixed
		 */
		public
		function GetAESKey()
		{
			return $this->encryptKey;
		}

		/**
		 * @param $Value
		 */
		public
		function SetAESKey($Value)
		{
			$this->encryptKey = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetPreMasterKey()
		{
			return $this->pre_MasterKey;
		}

		/**
		 * @param $Value
		 */
		public
		function SetPreMasterKey($Value)
		{
			$this->pre_MasterKey = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetPublicKey()
		{
			return $this->publicKey;
		}

		/**
		 * @param $Value
		 *
		 */
		public
		function SetPublicKey($Value)
		{
			$this->publicKey = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetPrivateKey()
		{
			return $this->privateKey;
		}

		/**
		 * @param $Value
		 *
		 */
		public
		function SetPrivateKey($Value)
		{
			$this->privateKey = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetSessionCode()
		{
			return $this->SessionCode;
		}

		/**
		 * @param $Value
		 *
		 */
		public
		function SetSessionCode($Value)
		{
			$this->SessionCode = $Value;
		}

		/**
		 * @param $DataArg
		 *
		 * @return string
		 */
		public
		function SerializeData($DataArg)
		{
			$DataArg = trim($DataArg);
			//$DataArg = serialize($this->Data );
			$DataArg = base64_encode($DataArg);

			//send it on its way
			return $DataArg;
		}

		/**
		 * @param $DataArg
		 *
		 * @return string
		 */
		public
		function UnSerializeData($DataArg)
		{
			//Let's decode the base64 data
			$DataArg = base64_decode($DataArg);

			//Now let's put it into array format
			//		$DataArg = unserialize($DataArg);
			return $DataArg;
		}

		/**
		 *
		 */
		public
		function GenerateKeys()
		{
			$this->aesObject->makeKeyPair();
			$this->publicKey = $this->aesObject->GetPublicKey();
			$this->privateKey = $this->aesObject->GetPrivateKey();
		}

		/**
		 * @return mixed
		 */
		public
		function GetDBVersion()
		{
			return $this->dBVersion;
		}

		/**
		 * @param $Value
		 */
		public
		function SetDBVersion($Value)
		{
			$this->dBVersion = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetHMDBVersion()
		{
			return $this->hMDBVersion;
		}

		/**
		 * @param $Value
		 */
		public
		function SetHMDBVersion($Value)
		{
			$this->hMDBVersion = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetDBCount()
		{
			return $this->dBCount;
		}

		/**
		 * @param $Value
		 */
		public
		function SetDBCount($Value)
		{
			$this->dBCount = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetHMDBCount()
		{
			return $this->hMDBCount;
		}

		/**
		 * @param $Value
		 */
		public
		function SetHMDBCount($Value)
		{
			$this->hMDBCount = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetDBFile()
		{
			return $this->dBFile;
		}

		/**
		 * @param $Value
		 */
		public
		function SetDBFile($Value)
		{
			$this->dBFile = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetHMDBFile()
		{
			return $this->hMDBFile;
		}

		/**
		 * @param $Value
		 */
		public
		function SetHMDBFile($Value)
		{
			$this->hMDBFile = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetVersionFile()
		{
			return $this->versionFile;
		}

		/**
		 * @param $Value
		 */
		public
		function SetVersionFile($Value)
		{
			$this->versionFile = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetVersionList()
		{
			return $this->versionListFile;
		}

		/**
		 * @param $Value
		 */
		public
		function SetVersionList($Value)
		{
			$this->versionListFile = $Value;
		}

		/**
		 * @param $DataArg
		 *
		 * @return String
		 */
		public
		function SecureEncrypt($DataArg)
		{
			$this->aesObject->SetPassword($this->encryptKey);
			$this->aesObject->SetPublicKey($this->publicKey);
			$result = $this->aesObject->SecureSendDataToServer($DataArg);

			return $result;
		}

		/**
		 * @param $DataArg
		 *
		 * @return String
		 */
		public
		function SecureEncrypt2($DataArg)
		{
			$this->aesObject->SetPassword($this->encryptKey);
			$this->aesObject->SetPublicKey($this->publicKey);
			$result = $this->aesObject->PublicEncryptData($DataArg);
			$result = base64_encode($result);

			return $result;
		}

		/**
		 * @param $DataArg
		 *
		 * @return String
		 */
		public
		function SecureDecrypt($DataArg)
		{
			$this->aesObject->SetPassword($this->encryptKey);
			$this->aesObject->SetPublicKey($this->publicKey);
			$result = $this->aesObject->SecureReceiveDataFromServer($DataArg);

			return $result;
		}

		/**
		 * @param $h
		 *
		 * @return null|string
		 */
		public
		function hex2bin($h)
		{
			if(!is_string($h))
			{
				return NULL;
			}
			$r = '';
			for($a = 0; $a < strlen($h); $a += 2)
			{
				$r .= chr(hexdec($h{$a} . $h{($a + 1)}));
			}

			return $r;
		}
	}