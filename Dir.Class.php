<?
/////////////////////////////////////////////////////////////////////////////////////////
// Directory list Class                                                                //
// Written by Robert Boone                                                             //
/////////////////////////////////////////////////////////////////////////////////////////
//                                                                                     //
// This is a basic class to list the content of directories.                           //
// This class is written for UNIX file systems but could work in                       //
// DOS with a few changes.                                                             //
//                                                                                     //
//                                                                                     //
//                                                                                     //
// Method SetDir($path) - Path of directory: Returns nothing                           //
// Method GetAll() - Gets list of folders and files in set directory: Returns Array    //
// Method GetFolders() - Gets list of all folders in set directory: Returns Array      //
// Method GetFiles() - Gets list of all files in set directory: Returns Array          //
// Method GetFiles($ext) - Gets list of files with .$ext: Returns Array                //
//                                                                                     //
/////////////////////////////////////////////////////////////////////////////////////////
	class Dir
	{
		// private
		var $FOLDERS = array();
		var $FILES = array();
		var $ALL = array();
		var $DIR;

		// public
		function SetDir($dir)
		{
			$this->DIR = escapeshellcmd($dir);
		}

		function GetAll()
		{
			unset($this->ALL);
			exec("ls " . $this->DIR, $filename);
			for ($count = 0; $count <= (sizeof($filename) - 1); $count++)
			{
				$this->ALL[] = $filename[$count];
			}

			return $this->ALL;
		}

		function GetFolders()
		{
			unset($this->FOLDERS);
			exec("ls " . $this->DIR, $filename);
			for ($count = 0; $count <= (sizeof($filename) - 1); $count++)
			{
				if (is_dir($this->DIR . "/" . $filename[$count]))
				{
					$this->FOLDERS[] = $filename[$count];
				}
			}

			return $this->FOLDERS;
		}

		function GetFiles()
		{
			unset($this->FILES);
			exec("ls " . $this->DIR, $filename);
			for ($count = 0; $count <= (sizeof($filename) - 1); $count++)
			{
				if (is_file($this->DIR . "/" . $filename[$count]))
				{
					$this->FILES[] = $filename[$count];
				}
			}

			return $this->FILES;
		}

		function GetFilesi($include)
		{
			unset($this->FILES);
			exec("ls " . $this->DIR, $filename);
			for ($count = 0; $count <= (sizeof($filename) - 1); $count++)
			{
				if (is_file($this->DIR . "/" . $filename[$count]) AND eregi($include, $filename[$count]))
				{
					$this->FILES[] = $filename[$count];
				}
			}

			return $this->FILES;
		}
	}

?>