<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: Mohammad
	 * Date: 8/15/13
	 * Time: 5:02 PM
	 * To change this template use File | Settings | File Templates.
	 */
	require_once("nuSOAP/lib/nusoap.php");
	require_once('Update.ClassC.php');
	define('UPDATEROWCOUNT', 100);

	$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
	$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
	$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
	$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';

//	$proxyhost = isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '172.16.7.1';
//	$proxyport = isset($_POST['proxyport']) ? $_POST['proxyport'] : '3128';
//	$proxyusername = isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '2298324093';
//	$proxypassword = isset($_POST['proxypassword']) ? $_POST['proxypassword'] : 'mbnmbn2020';

	$useCURL = isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
	$client = new nusoap_client("http://192.168.116.130/webservice/Services.php", FALSE,
//	$client = new nusoap_client("http://172.16.7.99/webservice/Server/Services.php", FALSE,
//	$client = new nusoap_client("http://192.168.1.8/webservice/Server/Services.php", FALSE,
								$proxyhost, $proxyport, $proxyusername, $proxypassword,0,1600);
	$err = $client->getError();
	if ($err)
	{
		echo '<h2>Constructor error</h2><pre>erroorrrrr: ' . $err . '</pre>';
		echo '<h2>Debug</h2><pre>' . htmlspecialchars($client->getDebug(), ENT_QUOTES) . '</pre>';
		exit();
	}
	$client->setDefaultRpcParams(TRUE); // This fixed the problem
	$client->decode_utf8 = FALSE;
	$updateObj = new Update();
	$preMasterKey = "text for generate AES key";
	$keyCode = $client->call('RequestRSAKey',$preMasterKey);

	if ($client->fault)
	{
		echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
		echo '</pre>';
	}
	else
	{
		$err = $client->getError();
		if ($err)
		{
			echo '<h2>Error</h2><pre>' . $err . '</pre>';
		}
		else
		{
			//In the future changed this 3 lines
			$updateObj->SetPublicKey($updateObj->UnSerializeData($keyCode['PublicKey']));
			$updateObj->SetSessionCode($updateObj->UnSerializeData($keyCode['SessionCode']));
			$updateObj->CreateEncryptKey();

			echo "public key: <br/> " . $updateObj->GetPublicKey() . "<br/> <br/> Session Code: <br/> " .
				 $updateObj->GetSessionCode() . "<br/> <br/> Encrypt Key: <br/> " . $updateObj->GetAESKey();

			// Generate next input service request
			$userInfo = array("SessionCode" => $updateObj->SerializeData($updateObj->GetSessionCode()),
				//this line should changed in the future
							  "EncryptKey"  => $updateObj->SerializeData($updateObj->GetPreMasterKey()), //Not Encrypted
							  "UserKey"     => $updateObj->SecureEncrypt("wwwweeeewwwweeee"),
							  "MACAddress"  => $updateObj->SecureEncrypt("WD-WMC1T3402074"),
							  "LastUpdate"  => $updateObj->SecureEncrypt("20140425_72"));

//			$updateInfo = $client->call('CheckUpdates', array($userInfo));
//
//			if ($client->fault)
//			{
//				echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
//				echo '</pre>';
//			}
//			else
//			{
//				$err = $client->getError();
//				if ($err)
//				{
//					echo '<h2>Error</h2><pre>' . $err . '</pre>';
//				}
//				else
//				{
//					$updateObj->SetDBCount($updateObj->SecureDecrypt($updateInfo['DBUpdate']));
//					$updateObj->SetHMDBCount($updateObj->SecureDecrypt($updateInfo['HMDBUpdate']));
//					$updateObj->SetVersionList($updateObj->SecureDecrypt($updateInfo['VUpdate']));
//
//					echo "<br/>DB Count : <br/> " . $updateObj->GetDBCount();
//					echo "<br/>HMDB Count : <br/> " . $updateObj->GetHMDBCount();
//					echo "<br/>Files Versions : <br/> " . $updateObj->GetVersionList() . "<br/>";

					$updateInfo = $client->call('CheckUpdatesFile', array($userInfo));
					if ($client->fault)
					{
						echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
						echo '</pre>';
					}
					else
					{
						$err = $client->getError();
						if ($err)
						{
							echo '<h2>Error</h2><pre>' . $err . '</pre>';
						}
						else
						{
							$updateObj->SetVersionList($updateObj->SecureDecrypt($updateInfo));

							echo "<br/>Files Versions : <br/>";

							$strStr = $updateObj->GetVersionList();
							echo $strStr;
						}
					}
					// Static sample number
//					$updateObj->SetDBVersion(12124);
//					/**
//					 * Empty and Prepare for write Updates
//					 */
//					$file = fopen("db.txt", "w");
//					fclose($file);
//					$file = fopen("hmdb.txt", "w");
//					fclose($file);
//					$counter = $updateObj->GetDBCount() / $updateObj->GetDBVersion(); // Get Update of DB
//					if ($updateObj->GetDBCount() > $updateObj->GetDBVersion())
//					{
//						$i = 0;
//						for ($i = $updateObj->GetDBVersion() + 1; $i < $updateObj->GetDBCount(); $i += UPDATEROWCOUNT)
//						{
//							$EndID = $i + UPDATEROWCOUNT - 1;
//							if ($EndID > $updateObj->GetDBCount())
//							{
//								$EndID = $updateObj->GetDBCount();
//							}
//
//							$userInfo =
//								array("SessionCode" => $updateObj->SerializeData($updateObj->GetSessionCode()),
//									  "UserKey"     => $updateObj->SecureEncrypt("wwwweeeewwwweeee"),
//									  "MACAddress"  => $updateObj->SecureEncrypt("WD-WMC1T3402074"),
//									  "StartID"     => $updateObj->SecureEncrypt($i),
//									  "EndID"       => $updateObj->SecureEncrypt($EndID));
//
//							$updateDB = $client->call('GetDBUpdate', array($userInfo));
//
//							$updateDB = $updateObj->SecureDecrypt($updateDB);
//							if ($client->fault)
//							{
//								echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
//								echo '</pre>';
//							}
//							else
//							{
//								$err = $client->getError();
//								if ($err)
//								{
//									echo '<h2>Error</h2><pre>' . $err . '</pre>';
//								}
//								else
//								{
//									if ($updateDB)
//									{
//										$file = fopen("db.txt", "a+");
//										if ($file)
//										{
////											$updateDB = str_replace(";", "\n", $updateDB);
////											$length = strlen($updateDB);
////											fwrite($file, $updateDB, $length);
////											fclose($file);
//											echo "<br/>DB File from " . $i . " to " . $EndID .
//												 " Be Downloaded Successfully and Written in file ";
//										}
//										else
//										{
//											echo "<br/>DB File from " . $i . " to " . $EndID .
//												 " Be Downloaded Successfully but Can not Write in temporary file ";
//										}
//									}
//									else
//									{
//										echo "<br/>DB Update Variable is empty <br/> ";
//									}
//								}
//							}
//						}
//					}
//
//					// Sample
//					$updateObj->SetHMDBVersion(7383262);
//
//					$counter = $updateObj->GetHMDBCount() / $updateObj->GetHMDBVersion(); // Get Update of DB
//					if ($updateObj->GetHMDBCount() > $updateObj->GetHMDBVersion())
//					{
//						$i = 0;
//						for ($i = $updateObj->GetHMDBVersion() + 1; $i < $updateObj->GetHMDBCount();
//							 $i += UPDATEROWCOUNT)
//						{
//							$EndID = $i + UPDATEROWCOUNT - 1;
//							if ($EndID > $updateObj->GetHMDBCount())
//							{
//								$EndID = $updateObj->GetHMDBCount();
//							}
//
//							$userInfo =
//								array("SessionCode" => $updateObj->SerializeData($updateObj->GetSessionCode()),
//									  "UserKey"     => $updateObj->SecureEncrypt("wwwweeeewwwweeee"),
//									  "MACAddress"  => $updateObj->SecureEncrypt("WD-WMC1T3402074"),
//									  "StartID"     => $updateObj->SecureEncrypt($i),
//									  "EndID"       => $updateObj->SecureEncrypt($EndID));
//
//							$updateHMDB = $client->call('GetHMDBUpdate', array($userInfo));
//
//							echo "<br/>HMDB File Size Before Decrypt: " . strlen($updateHMDB);
//							$updateHMDB = $updateObj->SecureDecrypt($updateHMDB);
//							echo "<br/>HMDB File Size After Decrypt: " . strlen($updateHMDB);
//							if ($client->fault)
//							{
//								echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
//								echo '</pre>';
//							}
//							else
//							{
//								$err = $client->getError();
//								if ($err)
//								{
//									echo '<h2>Error</h2><pre>' . $err . '</pre>';
//								}
//								else
//								{
//									if ($updateHMDB)
//									{
//										$file = fopen("hmdb.txt", "a+");
//										if ($file)
//										{
////											$updateHMDB = str_replace(";", "\n", $updateHMDB);
////											$length = strlen($updateHMDB);
////											fwrite($file, $updateHMDB, $length);
////											fclose($file);
//											echo "<br/>HMDB File from " . $i . " to " . $EndID .
//												 " Be Downloaded Successfully and Written in file ";
//										}
//										else
//										{
//											echo "<br/>HMDB File from " . $i . " to " . $EndID .
//												 " Be Downloaded Successfully but Can not Write in temporary file ";
//										}
//									}
//									else
//									{
//										echo "<br/>HMDB Update Variable is empty <br/>";
//									}
//								}
//							}
//						}
//					}
//
//					$userInfo =
//						array("SessionCode" => $updateObj->SerializeData($updateObj->GetSessionCode()),
//							  "UserKey"     => $updateObj->SecureEncrypt("wwwweeeewwwweeee"),
//							  "MACAddress"  => $updateObj->SecureEncrypt("WD-WMC1T3402074"),
//							  "StartID"     => $updateObj->SecureEncrypt("myfile"),
//							  "EndID"       => $updateObj->SecureEncrypt("mp3"));
//
//					$updateFile = $client->call('GetVersionUpdate', array($userInfo));
//
//					$updateFile = $updateObj->SecureDecrypt($updateFile);
//
//					if ($client->fault)
//					{
//						echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
//						echo '</pre>';
//					}
//					else
//					{
//						$err = $client->getError();
//						if ($err)
//						{
//							echo '<h2>Error</h2><pre>' . $err . '</pre>';
//						}
//						else
//						{
//							if ($updateFile)
//							{
//								$file = fopen("myfile.mp3", "w");
//								if ($file)
//								{
//									$length = strlen($updateFile);
//									fwrite($file, $updateFile, $length);
//									fclose($file);
//									echo "<br/><br/>myfile.mp3 Be Downloaded Successfully and Written in file ";
//								}
//								else
//								{
//									echo "<br/>myfile.mp3 Be Downloaded Successfully but Can not Write in temporary file ";
//								}
//							}
//							else
//							{
//								echo "<br/>myfile.mp3  is empty <br/>";
//							}
//						}
//					}
//					$userInfo =
//						array("SessionCode" => $updateObj->SerializeData($updateObj->GetSessionCode()),
//							  "UserKey"     => $updateObj->SecureEncrypt("wwwweeeewwwweeee"),
//							  "MACAddress"  => $updateObj->SecureEncrypt("WD-WMC1T3402074"));
//					$updateFinished = $client->call('EndUpdate', array($userInfo));
//					if ($client->fault)
//					{
//						echo '<h2>Fault (Expect - The request contains an invalid SOAP body)</h2><pre>';
//						echo '</pre>';
//					}
//					else
//					{
//						$err = $client->getError();
//						if ($err)
//						{
//							echo '<h2>Error</h2><pre>' . $err . '</pre>';
//						}
//						else
//						{
//							if ($updateFinished)
//							{
//								echo "<br/>Update Finished Successfully";
//							}
//							else
//							{
//								echo "<br/>An Error ocured ...";
//							}
//						}
//					}
				}
//			}
//
//		}
	}
?>