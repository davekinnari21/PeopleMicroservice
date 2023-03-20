<?php
	namespace PeopleService\Services;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleBasicModel.php");

	class PeopleBasicService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
	
		function getPeopleBasicByPeopleId($peopleId)
		{
			return new \Shared\Models\People\PeopleBasicModel($this->_repository->getPeopleBasicByPeopleId($peopleId));
		}
		
		// peopleBasic comes from RequestBody
		function updatePeopleBasicleId($peopleBasic)
		{
			return $this->_repository->updatePeopleBasicByPeopleId($peopleBasic);
		}
	}
	