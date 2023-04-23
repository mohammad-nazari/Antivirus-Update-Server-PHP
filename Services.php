<?php
	define("DIRECTORY", "/home/mohammad/NetBeansProjects/MakeFile/build/Release/GNU-Linux-x86/files");
	//Copyright (C) 2010  Jonathan Preece
	//
	//This program is free software: you can redistribute it and/or modify
	//it under the terms of the GNU General Public License as published by
	//the Free Software Foundation, either version 3 of the License, or
	//(at your option) any later version.
	//
	//This program is distributed in the hope that it will be useful,
	//but WITHOUT ANY WARRANTY; without even the implied warranty of
	//MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	//GNU General Public License for more details.
	//
	//You should have received a copy of the GNU General Public License
	//along with this program.  If not, see <http://www.gnu.org/licenses/>.
	use Update\UpdateClass;

	require_once("nuSOAP/lib/nusoap.php");
	require_once("UpdateClass.php");
	$namespace = "http://localhost/webservice/Server/Services.php";
	// create a new soap server
	$server = new soap_server();
	// configure our WSDL
	$server->configureWSDL("UpdateServices");
	// set our namespace
	$server->wsdl->schemaTargetNamespace = $namespace;
	$server->decode_utf8 = TRUE;
	//Create a complex type
	/**
	 *
	 */
	$server->wsdl->addComplexType('SessionInfo', 'complexType', 'struct', 'all', '',
								  array('PublicKey'   => array('name' => 'PK', 'type' => 'xsd:string'),
										'SessionCode' => array('name' => 'SC', 'type' => 'xsd:string'),
										'ErrorCode'   => array('name' => 'EC', 'type' => 'xsd:string')));
	$server->wsdl->addComplexType('UpdateInfo', 'complexType', 'struct', 'all', '',
								  array('DBUpdate'   => array('name' => 'DB', 'type' => 'xsd:string'),
										'HMDBUpdate' => array('name' => 'HMDB', 'type' => 'xsd:string'),
										'VUpdate'    => array('name' => 'VR', 'type' => 'xsd:string'),
										'ErrorCode'  => array('name' => 'EC', 'type' => 'xsd:string')));
	$server->wsdl->addComplexType('UpdateArgs', 'complexType', 'struct', 'all', '',
								  array('SessionCode' => array('name' => 'SK', 'type' => 'xsd:string'),
										'UserKey'     => array('name' => 'UK', 'type' => 'xsd:string'),
										'MACAddress'  => array('name' => 'MAC', 'type' => 'xsd:string'),
										'EncryptKey'  => array('name' => 'AES', 'type' => 'xsd:string'),
										'LastUpdate'  => array('name' => 'LU', 'type' => 'xsd:string'),
										'ErrorCode'   => array('name' => 'EC', 'type' => 'xsd:string')));
	$server->wsdl->addComplexType('UpdateDBArgs', 'complexType', 'struct', 'all', '',
								  array('SessionCode' => array('name' => 'SK', 'type' => 'xsd:string'),
										'UserKey'     => array('name' => 'UK', 'type' => 'xsd:string'),
										'MACAddress'  => array('name' => 'MAC', 'type' => 'xsd:string'),
										'StartID'     => array('name' => 'SID', 'type' => 'xsd:string'),
										'EndID'       => array('name' => 'EID', 'type' => 'xsd:string'),
										'ErrorCode'   => array('name' => 'EC', 'type' => 'xsd:string')));
	$server->wsdl->addComplexType('UpdateEndArgs', 'complexType', 'struct', 'all', '',
								  array('SessionCode' => array('name' => 'SK', 'type' => 'xsd:string'),
										'UserKey'     => array('name' => 'UK', 'type' => 'xsd:string'),
										'MACAddress'  => array('name' => 'MAC', 'type' => 'xsd:string'),
										'ErrorCode'   => array('name' => 'EC', 'type' => 'xsd:string')));
	$server->wsdl->addComplexType('FileInfo', 'complexType', 'struct', 'all', '',
								  array('FileName'   => array('name' => 'FN', 'type' => 'xsd:string'),
										'FileSize'   => array('name' => 'FS', 'type' => 'xsd:int'),
										'FolderName' => array('name' => 'FON', 'type' => 'xsd:string')));
	$server->wsdl->addComplexType('FileInfo_Array', 'complexType', 'array', '',
								  'SOAP-ENC:Array',
								  array(),
								  array(
									  array('ref' => 'SOAP-ENC:arrayType', 'wsdl:arrayType' => 'tns:FileInfo[]')
								  ),
								  'tns:FileInfo'
	);
	$server->wsdl->addComplexType('UpdateFileInfo', 'complexType', 'struct', 'all', '',
								  array('FileInformation'  => array('name' => 'PK', 'type' => 'tns:FileInfo_Array'),
										'FileInformation2' => array('name'      => 'PK', 'type' => 'tns:FileInfo',
																	'minOccurs' => '0', 'maxOccurs' => 'unbounded'),
										'FilesCount'       => array('name' => 'SC', 'type' => 'xsd:int'),
										'ErrorCode'        => array('name' => 'EC', 'type' => 'xsd:string')));
	/**
	 *
	 */
	$server->register('RequestRSAKey', // method
					  array('premasterkey' => 'xsd:string'), // input parameters
					  array('return' => 'tns:SessionInfo'), $namespace,
		//'urn:uploadwsdl',                                            // namespace
					  FALSE, //'urn:uploadwsdl#upload_file',                                // soapaction
					  'rpc', // style
					  'encoded', // use
					  'Send Publickey for User' // documentation
	);
	$server->register('CheckUpdates', // method
					  array('UpdateArgs' => 'tns:UpdateArgs'), array('return' => 'tns:UpdateInfo'), $namespace,
		//'urn:uploadwsdl',                                            // namespace
					  FALSE, //'urn:uploadwsdl#upload_file',                                // soapaction
					  'rpc', // style
					  'encoded', // use
					  'Check User Validation and Send Update list' // documentation
	);
	$server->register('CheckUpdatesFile', // method
					  array('UpdateArgs' => 'tns:UpdateArgs'), array('return' => 'xsd:string'), $namespace,
		//'urn:uploadwsdl',                                            // namespace
					  FALSE, //'urn:uploadwsdl#upload_file',                                // soapaction
					  'rpc', // style
					  'encoded', // use
					  'Check User Validation and Send Update list' // documentation
	);
	$server->register('GetDBUpdate', // method
					  array('UpdateArgs' => 'tns:UpdateDBArgs'), array('return' => 'xsd:string'), $namespace,
		//'urn:uploadwsdl',                                            // namespace
					  FALSE, //'urn:uploadwsdl#upload_file',                                // soapaction
					  'rpc', // style
					  'encoded', // use
					  'Get Update of DB Signatures' // documentation
	);
	$server->register('GetHMDBUpdate', // method
					  array('UpdateArgs' => 'tns:UpdateDBArgs'), array('return' => 'xsd:string'), $namespace,
		//'urn:uploadwsdl',                                            // namespace
					  FALSE, //'urn:uploadwsdl#upload_file',                                // soapaction
					  'rpc', // style
					  'encoded', // use
					  'Get Update of HMDB Signatures' // documentation
	);
	$server->register('GetVersionUpdate', // method
					  array('UpdateArgs' => 'tns:UpdateDBArgs'), array('return' => 'xsd:string'), $namespace,
		//'urn:uploadwsdl',                                            // namespace
					  FALSE, //'urn:uploadwsdl#upload_file',                                // soapaction
					  'rpc', // style
					  'encoded', // use
					  'Get Update of Version Files' // documentation
	);
	$server->register('EndUpdate', // method
					  array('UpdateArgs' => 'tns:UpdateEndArgs'), array('return' => 'xsd:boolean'), $namespace,
		//'urn:uploadwsdl',                                            // namespace
					  FALSE, //'urn:uploadwsdl#upload_file',                                // soapaction
					  'rpc', // style
					  'encoded', // use
					  'End Update and Close Session by Zero in actice Attribute' // documentation
	);
	$server->error_str = "Error Occured";
	/**
	 * @param $PreMasterKey
	 *
	 * @return array
	 */
	function RequestRSAKey($PreMasterKey)
	{
		$methodsObj = new UpdateClass();
		$methodsObj->CreateSession();
		$publicKey = $methodsObj->GetPublicKey();
		$sessionCode = $methodsObj->GetSessionCode();
		$result = array('PublicKey'   => $methodsObj->SerializeData($publicKey),
						'SessionCode' => $methodsObj->SerializeData($sessionCode),
						'ErrorCode'   => $methodsObj->SerializeData(""));

		return $result;
	}

	/**
	 * @param $UpdateInfo
	 *
	 * @return array|null
	 */
	function CheckUpdates($UpdateInfo)
	{
		$methodsObj = new UpdateClass();
		$methodsObj->SetSessionCode($methodsObj->UnSerializeData($UpdateInfo['SessionCode']));
		if ($methodsObj->CheckSession())
		{
			//This line should change in the future
			$methodsObj->SetEncryptKey($methodsObj->UnSerializeData($UpdateInfo['EncryptKey']));
			// Generate main key
			$methodsObj->CreateEncryptKey();
			$methodsObj->SetUserKey($methodsObj->SecureDecrypt($UpdateInfo['UserKey']));
			$methodsObj->SetMACAddress($methodsObj->SecureDecrypt($UpdateInfo['MACAddress']));
			if ($methodsObj->CheckUser())
			{
				if ($methodsObj->UpdateSession())
				{
					if ($methodsObj->GetUpdatesInfo())
					{
						$result = array('DBUpdate'   => $methodsObj->SecureEncrypt($methodsObj->GetDBCount()),
										'HMDBUpdate' => $methodsObj->SecureEncrypt($methodsObj->GetHMDBCount()),
										'VUpdate'    => $methodsObj->SecureEncrypt($methodsObj->GetFileVersion()));
					}
					else
					{
						$result = $methodsObj->SetUpdateInfoError("0"); //"Update Session Not OK");
					}
				}
				else
				{
					$result = $methodsObj->SetUpdateInfoError("-1"); //"Update Session Not OK");
				}
			}
			else
			{
				$result = $methodsObj->SetUpdateInfoError("-2"); //"User Informations Not OK");
			}
		}
		else
		{
			$result = $methodsObj->SetUpdateInfoError("-3"); //"Session Terminated or Not Exist");
		}

		return $result;
	}

	/**
	 * @param $UpdateInfo
	 *
	 * @return array
	 */
	function CheckUpdatesFile($UpdateArgs)
	{
		$methodsObj = new UpdateClass();
		$methodsObj->SetSessionCode($methodsObj->UnSerializeData($UpdateArgs['SessionCode']));
		if ($methodsObj->CheckSession())
		{
			//This line should change in the future
			// pre master key
			$methodsObj->SetEncryptKey($methodsObj->UnSerializeData($UpdateArgs['EncryptKey']));
			// Generate main key
			$methodsObj->CreateEncryptKey();
			$methodsObj->SetUserKey($methodsObj->SecureDecrypt($UpdateArgs['UserKey']));
			$methodsObj->SetMACAddress($methodsObj->SecureDecrypt($UpdateArgs['MACAddress']));
			$methodsObj->SetLastUpdate($methodsObj->SecureDecrypt($UpdateArgs['LastUpdate']));
			if ($methodsObj->CheckUser())
			{
				if ($methodsObj->UpdateSession())
				{
					if ($methodsObj->GetUpdatesInfoFile())
					{
						$result = $methodsObj->SecureEncrypt($methodsObj->GetFileVersion());
					}
					else
					{
						$result = "0"; //"Update Session Not OK");
					}
				}
				else
				{
					$result = "-1"; //"Update Session Not OK");
				}
			}
			else
			{
				$result = "-2" . $methodsObj->GetUserKey(); //"User Informations Not OK");
			}
		}
		else
		{
			$result = "-3"; //"Session Terminated or Not Exist");
		}

		return $result;
	}

	/**
	 *
	 * @param $UpdateDBInfo
	 *
	 * @return null|string
	 */
	function GetDBUpdate($UpdateDBInfo)
	{
		$methodsObj = new UpdateClass();
		$methodsObj->SetSessionCode($methodsObj->UnSerializeData($UpdateDBInfo['SessionCode']));
		if ($methodsObj->CheckSession())
		{
			$userKey = $methodsObj->SecureDecrypt($UpdateDBInfo['UserKey']);
			$methodsObj->SetMACAddress($methodsObj->SecureDecrypt($UpdateDBInfo['MACAddress']));
			$StartID = $methodsObj->SecureDecrypt($UpdateDBInfo['StartID']);
			$EndID = $methodsObj->SecureDecrypt($UpdateDBInfo['EndID']);
			if ($userKey == $methodsObj->GetUserKey())
			{
				if ($methodsObj->CheckUser())
				{
					$result = $methodsObj->GetDBUpdateFile($StartID, $EndID);
				}
				else
				{
					$result = "-1"; //"Update Session Not OK");
				}
			}
			else
			{
				$result = "-2"; //"User Informations Not OK");
			}
		}
		else
		{
			$result = "-3"; //"Session Terminated or Not Exist");
		}
		$result = $methodsObj->SecureEncrypt($result);

		return $result;
	}

	/**
	 * @param $UpdateDBInfo
	 *
	 * @return null|string
	 */
	function GetHMDBUpdate($UpdateDBInfo)
	{
		$methodsObj = new UpdateClass();
		$methodsObj->SetSessionCode($methodsObj->UnSerializeData($UpdateDBInfo['SessionCode']));
		if ($methodsObj->CheckSession())
		{
			$userKey = $methodsObj->SecureDecrypt($UpdateDBInfo['UserKey']);
			$methodsObj->SetMACAddress($methodsObj->SecureDecrypt($UpdateDBInfo['MACAddress']));
			$StartID = $methodsObj->SecureDecrypt($UpdateDBInfo['StartID']);
			$EndID = $methodsObj->SecureDecrypt($UpdateDBInfo['EndID']);
			if ($userKey == $methodsObj->GetUserKey())
			{
				if ($methodsObj->CheckUser())
				{
					$result = $methodsObj->GetHMDBUpdateFile($StartID, $EndID);
				}
				else
				{
					$result = "-1"; //"Update Session Not OK");
				}
			}
			else
			{
				$result = "-2"; //"User Informations Not OK");
			}
		}
		else
		{
			$result = "-3"; //"Session Terminated or Not Exist");
		}
		$result = $methodsObj->SecureEncrypt($result);

		return $result;
	}

	/**
	 * @param $UpdateDBInfo
	 *
	 * @return null|string
	 */
//	function GetVersionUpdate($UpdateDBInfo)
//	{
//		$methodsObj = new UpdateClass();
//		$methodsObj->SetSessionCode($methodsObj->UnSerializeData($UpdateDBInfo['SessionCode']));
//		if ($methodsObj->CheckSession())
//		{
//			$userKey = $methodsObj->SecureDecrypt($UpdateDBInfo['UserKey']);
//			$methodsObj->SetMACAddress($methodsObj->SecureDecrypt($UpdateDBInfo['MACAddress']));
//			$FileName = $methodsObj->SecureDecrypt($UpdateDBInfo['StartID']);
//			$FileVersion = $methodsObj->SecureDecrypt($UpdateDBInfo['EndID']);
//			if ($userKey == $methodsObj->GetUserKey())
//			{
//				if ($methodsObj->CheckUser())
//				{
//					$result = $methodsObj->GetVersionUpdateFile($FileName, $FileVersion);
//				}
//				else
//				{
//					$result = "-1"; //"Update Session Not OK");
//				}
//			}
//			else
//			{
//				$result = "-2"; //"User Informations Not OK");
//			}
//		}
//		else
//		{
//			$result = "-3"; //"Session Terminated or Not Exist");
//		}
//		$result = $methodsObj->SecureEncrypt($result);
//
//		return $result;
//	}
	/**
	 * @param $UpdateDBInfo
	 *
	 * @return null|string
	 */
	function GetVersionUpdate($UpdateDBInfo)
	{
		$methodsObj = new UpdateClass();
		$methodsObj->SetSessionCode($methodsObj->UnSerializeData($UpdateDBInfo['SessionCode']));
		if ($methodsObj->CheckSession())
		{
			$userKey = $methodsObj->SecureDecrypt($UpdateDBInfo['UserKey']);
			$methodsObj->SetMACAddress($methodsObj->SecureDecrypt($UpdateDBInfo['MACAddress']));
			$FileName = $methodsObj->SecureDecrypt($UpdateDBInfo['StartID']);
			if ($userKey == $methodsObj->GetUserKey())
			{
				if ($methodsObj->CheckUser())
				{
					$result = $methodsObj->GetUpdateFile($FileName);
				}
				else
				{
					$result = "-1"; //"Update Session Not OK");
				}
			}
			else
			{
				$result = "-2"; //"User Informations Not OK");
			}
		}
		else
		{
			$result = "-3"; //"Session Terminated or Not Exist");
		}
		$result = $methodsObj->SecureEncrypt($result);

		return $result;
	}

	/**
	 * @param $UpdateEndArgs
	 *
	 * @return null|string
	 */
	function EndUpdate($UpdateEndArgs)
	{
		$methodsObj = new UpdateClass();
		$methodsObj->SetSessionCode($methodsObj->UnSerializeData($UpdateEndArgs['SessionCode']));
		if ($methodsObj->CheckSession())
		{
			$userKey = $methodsObj->SecureDecrypt($UpdateEndArgs['UserKey']);
			$methodsObj->SetMACAddress($methodsObj->SecureDecrypt($UpdateEndArgs['MACAddress']));
			if ($userKey == $methodsObj->GetUserKey())
			{
				if ($methodsObj->CheckUser())
				{
					$result = $methodsObj->EndUpdate();
				}
				else
				{
					$result = ""; //"Update Session Not OK");
				}
			}
			else
			{
				$result = ""; //"User Informations Not OK");
			}
		}
		else
		{
			$result = ""; //"Session Terminated or Not Exist");
		}
		if ($result != "")
		{
			$result = $methodsObj->SecureEncrypt($result);
		}

		return $result;
	}

	$POST_DATA = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : '';
	// pass our posted data (or nothing) to the soap service
	$server->service($POST_DATA);
	exit();

?>