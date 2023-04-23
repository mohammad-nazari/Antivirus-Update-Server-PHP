<?php
	/**
	 * Created by JetBrains PhpStorm.
	 * User: mohammad
	 * Date: 9/22/13
	 * Time: 11:08 AM
	 * To change this template use File | Settings | File Templates.
	 */

	namespace Update;

	use DAOFactory;
	use Version;


	require_once('include_dao.php');
	/**
	 * Class VersionMethod
	 *
	 * @package Update
	 */
	class VersionMethod
	{
		/**
		 * @var
		 */
		private $versionObj;
		/**
		 * @var
		 */
		private $fileList;

		/**
		 *
		 */
		public function __construct()
		{
			//		$this->versionObj = new Version();
		}

		/**
		 * @return mixed
		 */
		public function GetUpdates()
		{
			$this->versionObj = DAOFactory::getVersionDAO()->queryAll();
			$this->GenerateList();
			return $this->fileList;
		}

		/**
		 *
		 */
		private function GenerateList()
		{
			for ($i = 0; $i < count($this->versionObj); $i++)
			{
				$this->fileList .= $this->versionObj[$i]->fileName . ':' . $this->versionObj[$i]->fileType . ':' . $this->versionObj[$i]->fileVersion . ';';
			}
		}

		/**
		 * @param $FileName
		 * @param $Version
		 *
		 * @return mixed
		 */
		public function GetFile($FileName, $Version)
		{
			$filev = new Version();
			$filev->fileName;
			$file = DAOFactory::getVersionDAO()->queryByFileNameType($FileName, $Version);
			$result = $file[0]->file;
			return $result;
		}

		/**
		 * @param $FileName
		 * @param $Version
		 *
		 * @return mixed
		 */
		public function GetUFile($FileName)
		{
			$result = file_get_contents($FileName);
			return $result;
		}
	}