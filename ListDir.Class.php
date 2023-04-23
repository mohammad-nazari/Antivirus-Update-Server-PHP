<?php
	/*===============================
	  - Class: List file in Directory
	  - Version: 1.0
	  - Author: Huynh Hai Huynh
	  - Email: Huynhhaihuynh@gmail.com
	  - Website: http://www.php.net.vn
	  - listdir.class.php
	===============================*/
	class listdir
	{
		private $directory;
		private $filesave;
		private $fileList = array();
		private $io = 0;
		private $lastUpdate;

		/**
		 * @param mixed $directory
		 */
		public
		function setDirectory($directory)
		{
			$this->directory = $directory;
		}

		/**
		 * @return mixed
		 */
		public
		function getDirectory()
		{
			return $this->directory;
		}

		/**
		 * @param array $fileList
		 */
		public
		function setFileList($fileList)
		{
			$this->fileList = $fileList;
		}

		/**
		 * @return array
		 */
		public
		function getFileList()
		{
			return $this->fileList;
		}

		/**
		 * @param mixed $filesave
		 */
		public
		function setFilesave($filesave)
		{
			$this->filesave = $filesave;
		}

		/**
		 * @return mixed
		 */
		public
		function getFilesave()
		{
			return $this->filesave;
		}

		/**
		 * @param int $io
		 */
		public
		function setIo($io)
		{
			$this->io = $io;
		}

		/**
		 * @return int
		 */
		public
		function getIo()
		{
			return $this->io;
		}

		/**
		 * @param mixed $lastUpdate
		 */
		public
		function setLastUpdate($lastUpdate)
		{
			$this->lastUpdate = $lastUpdate;
		}

		/**
		 * @return mixed
		 */
		public
		function getLastUpdate()
		{
			return $this->lastUpdate;
		}

		public
		function DoList()
		{
			unset($this->io);
			unset($this->fileList);
			//$this->WriteContent2File($this->filesave, '', FALSE);
			$this->ListIndir($this->directory, "root");
		}

		private
		function WriteContent2File($FileName, $strContent, $append = TRUE)
		{
			if ($append)
			{
				$FileOpenedHandle = @fopen($FileName, "a");
			}
			else
			{
				$FileOpenedHandle = @fopen($FileName, "w");
			}
			if (@is_writable($FileName))
			{
				@fwrite($FileOpenedHandle, $strContent);
				@fclose($FileOpenedHandle);
			}
			else
			{
				die("Error: The file $FileName does not allow to write.");
			}
		}

		private
		function ListIndir($dir, $folder)
		{
			if ($handle = @opendir($dir))
			{
				while (FALSE !== ($file = readdir($handle)))
				{
					if ($file != "." && $file != "..")
					{
						$newdir = $dir . "/" . $file . "/";
						if (is_dir($dir . "/" . $file))
						{
							$folder2 = $file;
							$this->ListIndir($newdir, $folder2);
						}
						else if (is_file($dir . "/" . $file))
						{
							$this->fileList[$this->io++] = $folder . ":" . $file . ":" . filesize($dir . $file);
						}
					}
				}
				closedir($handle);
			}
		}
	}


