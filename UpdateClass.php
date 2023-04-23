<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: mohammad
	 * Date: 9/5/13
	 * Time: 10:19 AM
	 * To change this template use File | Settings | File Templates.
	 */
	namespace Update;

	require_once("include_dao.php");
	require_once("AES.Class.php");
	require_once("Session.Class.php");
	require_once("Hmdb.Class.php");
	require_once("DB.Class.php");
	require_once('User.Class.php');
	require_once('Version.Class.php');
	require_once('ListDir.Class.php');
	define("DIRECTORY", "/home/mohammad/NetBeansProjects/MakeFile/build/Release/GNU-Linux-x86/files");
	define("RSA_KEYLEN", 2048);
	define("AES_KEYLEN", 128);

	/**
	 * Class UpdateClass
	 *
	 * @package Update
	 */
	class UpdateClass
	{
		/**
		 * @var
		 */
		private $privateKey;
		/**
		 * @var
		 */
		private $publicKey;
		/**
		 * @var
		 */
		private $sessionCode;
		/**
		 * @var
		 */
		private $encryptKey;
		/**
		 * @var AESClass
		 */
		private $aesObject;
		/**
		 * @var
		 */
		private $userKey;
		/**
		 * @var
		 */
		private $mACAddress;
		/**
		 * @var SessionMethod
		 */
		private $sessionObj;
		/**
		 * @var DBMethod
		 */
		private $dBObj;
		/**
		 * @var HmdbMethod
		 */
		private $hMDBObj;
		/**
		 * @var UserMethod
		 */
		private $userObj;
		/**
		 * @var
		 */
		private $Data;
		/**
		 * @var
		 */
		private $dBCount;
		/**
		 * @var
		 */
		private $hMDBCount;
		/**
		 * @var
		 */
		private $fileVersion;
		/**
		 * @var VersionMethod
		 */
		private $versionObj;
		/**
		 * @var
		 */
		private $lastUpdate;

		/**
		 *
		 */
		function __construct()
		{
			$this->dBObj = new DBMethod();
			$this->hMDBObj = new HmdbMethod();
			$this->aesObject = new AESClass();
			$this->userObj = new UserMethod();
			$this->sessionObj = new SessionMethod();
			$this->versionObj = new VersionMethod();
		}

		/**
		 *
		 */
		public
		function SetPublicKey($value)
		{
			$this->publicKey = $value;
		}

		/**
		 *
		 */
		public
		function GetPublicKey()
		{
			return $this->publicKey;
		}

		/**
		 *
		 */
		public
		function SetPrivateKey($value)
		{
			$this->privateKey = $value;
		}

		/**
		 *
		 */
		public
		function GetPrivateKey()
		{
			return $this->privateKey;
		}

		/**
		 *
		 */
		public
		function GetPrivateKey2()
		{
			$this->aesObject->SetPrivateKey($this->privateKey);

			return $this->aesObject->GetPrivateKey();
		}

		/**
		 *
		 */
		public
		function CreateEncryptKey()
		{
			$this->encryptKey = $this->Make16BitKey($this->encryptKey);
		}

		/**
		 * @param mixed $lastUpdate
		 */
		public
		function SetLastUpdate($lastUpdate)
		{
			$this->lastUpdate = $lastUpdate;
		}

		/**
		 * @return mixed
		 */
		public
		function GetLastUpdate()
		{
			return $this->lastUpdate;
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
				if ((AES_KEYLEN / 8) == 32)
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
		 *
		 */
		public
		function CreateSession()
		{
			$this->sessionObj->CreateSession();
			$this->publicKey = $this->sessionObj->GetPublicKey();
			$this->privateKey = $this->sessionObj->GetPrivateKey();
			$this->sessionCode = $this->sessionObj->GetSessionCode();
		}

		/**
		 * @return mixed
		 */
		public
		function UpdateSession()
		{
			$this->sessionObj->SetSessionCode($this->sessionCode);
			$this->sessionObj->SetUserKey($this->userKey);
			$this->sessionObj->SetEncryptionKey($this->encryptKey);
			$result = $this->sessionObj->UpdateSession($this->sessionCode, $this->userKey, $this->encryptKey);

			return $result;
		}

		/**
		 *
		 */
		public
		function CloseSession()
		{
			$this->sessionObj->CloseSession($this->sessionCode);
		}

		/**
		 * @param $AESArg
		 */
		public
		function SetEncryptKey($AESArg)
		{
			$this->encryptKey = $AESArg;
		}

		/**
		 * @param $AESArg
		 */
		public
		function GetEncryptKey()
		{
			return $this->encryptKey;
		}

		/**
		 * @param $StartIDArg
		 * @param $EndIDArg
		 *
		 * @return null|string
		 */
		public
		function GetDBUpdateFile($StartIDArg, $EndIDArg)
		{
			$result = $this->dBObj->GetUpdateFile($StartIDArg, $EndIDArg);

			return $result;
		}

		/**
		 * @param $StartIDArg
		 * @param $EndIDArg
		 *
		 * @return null|string
		 */
		public
		function GetHMDBUpdateFile($StartIDArg, $EndIDArg)
		{
			$result = $this->hMDBObj->GetUpdateFile($StartIDArg, $EndIDArg);

			return $result;
		}

		/**
		 * @param $FileName
		 * @param $EFileType
		 *
		 * @return mixed
		 */
		public
		function GetVersionUpdateFile($FileName, $EFileType)
		{
			$result = $this->versionObj->GetFile($FileName, $EFileType);

			return $result;
		}

		/**
		 * @param $FileName
		 * @param $EFileType
		 *
		 * @return mixed
		 */
		public
		function GetUpdateFile($FileName)
		{
			list($FolderName, $FileNumber) = explode("_", $FileName);
			$DirectoryNameStr = DIRECTORY . "/" . $FolderName . "/" . $FileName;
			$result = $this->versionObj->GetUFile($DirectoryNameStr);

			return $result;
		}

		/**
		 * @return mixed
		 */
		public
		function GetUserKey()
		{
			return $this->userKey;
		}

		/**
		 * @param $UserKeyArg
		 */
		public
		function SetUserKey($UserKeyArg)
		{
			$this->userKey = $UserKeyArg;
		}

		/**
		 * @return mixed
		 */
		public
		function GetMACAddress()
		{
			return $this->mACAddress;
		}

		/**
		 * @param $MACAddressArg
		 */
		public
		function SetMACAddress($MACAddressArg)
		{
			$this->mACAddress = $MACAddressArg;
		}

		/**
		 *
		 */
		public
		function GetUpdatesInfo()
		{
			$this->dBCount = $this->GetDBUpdate();
			$this->hMDBCount = $this->GetHMDBUpdate();
			$this->fileVersion = $this->GetFileVersionUpdate();
			if ($this->dBCount == "")
			{
				return FALSE;
			}

			return TRUE;
		}

		/**
		 *
		 */
		public
		function GetUpdatesInfoFile()
		{
			$lstDirObj = new \listdir();
			$lstDirObj->setDirectory(DIRECTORY);
			$lstDirObj->setLastUpdate($this->lastUpdate);
			list($folderName, $trash) = explode("_", $this->lastUpdate);
			$lstDirObj->DoList();
			$newFiles = $lstDirObj->getFileList();
			natsort($newFiles);
			$OK = FALSE;

			foreach ($newFiles as $elem)
			{
				if (strnatcmp(($folderName . ":" . $this->lastUpdate), $elem) < 0)
				{
					if (!strstr($elem, $this->lastUpdate))
					{
						if ($OK)
						{
							$this->fileVersion .= "\n";
						}
						$OK = TRUE;
						$this->fileVersion .= $elem;
					}
				}
			}

			if($this->fileVersion == "")
			{
				// No update
				$this->fileVersion = "100";
			}

			return TRUE;
		}

		/**
		 * @return int
		 */
		public
		function CheckUser()
		{
			return $this->userObj->CheckUser($this->userKey, $this->mACAddress);
		}

		/**
		 * @param $DataArg
		 *
		 * @return string
		 */
		public
		function SerializeData($DataArg)
		{
			if ($DataArg != "")
			{
				$DataArg = trim($DataArg);
				//			$DataArg = serialize($this->Data );
				$DataArg = base64_encode($DataArg);
			}

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
			if ($DataArg != "")
			{
				//Let's decode the base64 data
				$DataArg = base64_decode($DataArg);
			}
			//Now let's put it into array format
			//			$DataArg = unserialize($DataArg);
			return $DataArg;
		}

		/**
		 * @return mixed
		 */
		public
		function GetData()
		{
			return $this->Data;
		}

		/**
		 * @param $Value
		 *
		 */
		public
		function SetData($Value)
		{
			$this->Data = $Value;
		}

		/**
		 * @return mixed
		 */
		public
		function GetSessionCode()
		{
			return $this->sessionCode;
		}

		/**
		 * @param $Value
		 *
		 */
		public
		function SetSessionCode($Value)
		{
			$this->sessionCode = $Value;
		}

		/**
		 * @return bool
		 */
		public
		function CheckSession()
		{
			$result = $this->sessionObj->SearchSession($this->sessionCode);
			if ($result)
			{
				$this->userKey = $result['UserKey'];
				$this->privateKey = $result['PrivateKey'];
				$this->publicKey = $result['PublicKey'];
				$this->encryptKey = $result['EncryptKey'];

				//				list($this->privateKey,$this->userKey) = $result;
				return TRUE;
			}

			return FALSE;
		}

		/**
		 * @return null
		 */
		private
		function GetDBUpdate()
		{
			return $this->dBObj->GetUpdates();
		}

		/**
		 * @return null
		 */
		private
		function GetHMDBUpdate()
		{
			return $this->hMDBObj->GetUpdates();
		}

		/**
		 * @return mixed
		 */
		private
		function GetFileVersionUpdate()
		{
			return $this->versionObj->GetUpdates();
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
		 * @param $Valu
		 */
		public
		function SetDBCount($Valu)
		{
			$this->dBCount = $Valu;
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
		 * @param $Valu
		 */
		public
		function SetHMDBCount($Valu)
		{
			$this->hMDBCount = $Valu;
		}

		/**
		 * @return mixed
		 */
		public
		function GetFileVersion()
		{
			return $this->fileVersion;
		}

		/**
		 * @param $Valu
		 */
		public
		function SetFileVersion($Valu)
		{
			$this->fileVersion = $Valu;
		}

		/**
		 * @return mixed
		 */
		public
		function EndUpdate()
		{
			$result = $this->sessionObj->CloseSession($this->sessionCode);

			return $result;
		}

		/**
		 *
		 */
		public
		function PrepareDBFile()
		{
			$this->dBObj->PrepareFile();
		}

		/**
		 *
		 */
		public
		function UpdateDBFile()
		{
			$this->dBObj->UpdateFile();
		}

		/**
		 * @param $Value
		 */
		public
		function SetDBTemporaryFileAddresses($Value)
		{
			$this->dBObj->SetFileAddress($Value);
		}

		/**
		 * @param $Value
		 */
		public
		function SetHMDBTemporaryFileAddresses($Value)
		{
			$this->hMDBObj->SetFileAddress($Value);
		}

		/**
		 * @param $DataArg
		 *
		 * @return String
		 */
		public
		function SecureEncrypt($DataArg)
		{
			$result = $DataArg;
			if ($DataArg != "")
			{
				$this->aesObject->SetPassword($this->encryptKey);
				$this->aesObject->SetPrivateKey($this->privateKey);
				$result = $this->aesObject->SecureSendDataToClient($DataArg);
			}

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
			$result = $DataArg;
			if ($DataArg != "")
			{
				$this->aesObject->SetPassword($this->encryptKey);
				$this->aesObject->SetPrivateKey($this->privateKey);
				$result = $this->aesObject->SecureReceiveDataFromClient($DataArg);
			}

			return $result;
		}

		/**
		 * @param $DataArg
		 *
		 * @return String
		 */
		public
		function SecureDecrypt2($DataArg)
		{
			$result = $DataArg;
			if ($DataArg != "")
			{
				$this->aesObject->SetPassword($this->encryptKey);
				$this->aesObject->SetPrivateKey($this->privateKey);
				$DataArg = base64_decode($DataArg);
				$result = $this->aesObject->PrivateDecryptData($DataArg);
			}

			return $result;
		}

		/**
		 * @param string $value
		 *
		 * @return array
		 */
		public
		function SetUpdateInfoError($value = "Error Occured")
		{
			$filelist = $this->sessionCode;
			if ($this->sessionCode == '')
			{
				$filelist = "Nothing";
			}
			$result = array('DBUpdate'   => $this->SecureEncrypt($value),
							'HMDBUpdate' => $this->SecureEncrypt($value),
							'VUpdate'    => $this->SecureEncrypt($value),
							'ErrorCode'  => $this->SecureEncrypt($value));

			return $result;
		}
	}