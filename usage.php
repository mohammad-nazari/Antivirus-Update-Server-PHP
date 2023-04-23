<?php
	/*===============================
	  - Class: List file in Directory
	  - Version: 1.0
	  - Author: Huynh Hai Huynh
	  - Email: Huynhhaihuynh@gmail.com
	  - Website: http://www.php.net.vn
	  - Usage.php
	  - Best performance: Run from Console
	===============================*/
	define("DIRECTORY","/home/mohammad/NetBeansProjects/MakeFile/build/Release/GNU-Linux-x86/files");
	set_time_limit('3600');
	include('ListDir.Class.php');
	$k = new listdir;
	$k->setFilesave("list"); // Output to file(Text Plain)
	$k->setDirectory("/home/mohammad/NetBeansProjects/MakeFile/build/Release/GNU-Linux-x86/files"); // List the given diretory
	$k->DoList();
	$listOfFile = $k->getFileList();
	natsort($listOfFile);
	$i = 0;
	foreach ($listOfFile as $elem)
	{
		if (strnatcmp("20140418:20140418_8", $elem) < 0)
		{
			echo ++$i ." = " . $elem;
			echo "<br/>";
		}
	}
	echo "<b>" . $i . "</b>";

	list($FolderName, $FileNumber) = explode("_",$listOfFile[$i-13]);
	$FileName = DIRECTORY . "/" . $FolderName . "/" . $listOfFile[$i-13];
	echo "<br>Directory : </br><br>" . $FileName . "</br>";
	$result = file_get_contents($FileName);
	echo "<br>File Content : </br><br>" . $result . "</br>";
?>


