<?php
	namespace PeopleService\Services;

	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleSettingModel.php");

	class PeopleSettingService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
	
		function getPeopleSettingByPeopleId($peopleId)
		{
			return new \Shared\Models\People\PeopleSettingModel($this->_repository->getPeopleSettingByPeopleId($peopleId));
		}
		
		// peopleSetting comes from RequestBody
		function updatePeopleSettingByPeopleId($peopleSetting)
		{
			return $this->_repository->updatePeopleSettingByPeopleId($peopleSetting);
		}
	}
	