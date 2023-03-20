<?php
	namespace PeopleService\Services;

	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleContactModel.php");

	class PeopleContactService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
	
		function getPeopleContactByPeopleId($peopleId)
		{
			return new \Shared\Models\People\PeopleContactModel($this->_repository->getPeopleContactByPeopleId($peopleId));
		}
		
		// peopleContact comes from RequestBody
		function updatePeopleContactByPeopleId($peopleContact)
		{
			return $this->_repository->updatePeopleContactByPeopleId($peopleContact);
		}
	}
	