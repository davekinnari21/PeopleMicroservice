<?php
	namespace PeopleService\Services;

	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleOldModel.php");

	class PeopleOldService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
	
		function getPeopleOldByPeopleId($peopleId)
		{
			return new \Shared\Models\People\PeopleOldModel($this->_repository->getPeopleOldByPeopleId($peopleId));
		}
		
		// peopleOld comes from RequestBody
		function updatePeopleOldByPeopleId($peopleOld)
		{
			return $this->_repository->updatePeopleOldByPeopleId($peopleOld);
		}
	}
	