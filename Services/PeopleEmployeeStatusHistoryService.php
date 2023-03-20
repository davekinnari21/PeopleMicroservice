<?php
	namespace PeopleService\Services;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/EmployeeStatusHistoryModel.php");

	class PeopleEmployeeStatusHistoryService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}

		function getPeopleEmployeeStatusHistoryByEmployeeStatusHistoryId($employeeStatusHistoryId)
		{
			return new \Shared\Models\EmployeeStatusHistoryModel($this->_repository->getPeopleEmployeeStatusHistoryByEmployeeStatusHistoryId($employeeStatusHistoryId));				
		}

		function getPeopleEmployeeStatusHistorysByPeopleId($peopleId)
		{
			$returnArray = array();
			$peopleEmployeeStatusHistoryArray = $this->_repository->getPeopleEmployeeStatusHistorysByPeopleId($peopleId);

			foreach($peopleEmployeeStatusHistoryArray as $peopleEmployeeStatusHistory)
			{
				$returnArray[] = new \Shared\Models\EmployeeStatusHistoryModel($peopleEmployeeStatusHistory);				
			}
			
			return $returnArray;
		}
	}
