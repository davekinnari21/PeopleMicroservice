<?php
	namespace PeopleService\Services;

	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleUserModel.php");

	class PeopleUserService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
	
		function getPeopleUserByPeopleId($peopleId)
		{
			return new \Shared\Models\People\PeopleUserModel($this->_repository->getPeopleUserByPeopleId($peopleId));
		}
		
		// peopleUser comes from RequestBody
		function updatePeopleUserByPeopleId($peopleUser)
		{
			return $this->_repository->updatePeopleUserByPeopleId($peopleUser);
		}
	}
	