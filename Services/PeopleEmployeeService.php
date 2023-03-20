<?php
	namespace PeopleService\Services;

	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleEmployeeModel.php");

	class PeopleEmployeeService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
	
		function getPeopleEmployeeByPeopleId($peopleId)
		{
			return new \Shared\Models\People\PeopleEmployeeModel($this->_repository->getPeopleEmployeeByPeopleId($peopleId));
		}
		
		// peopleEmployee comes from RequestBody
		function updatePeopleEmployeeByPeopleId($peopleEmployee)
		{
			return $this->_repository->updatePeopleEmployeeByPeopleId($peopleEmployee);
		}
	}
	