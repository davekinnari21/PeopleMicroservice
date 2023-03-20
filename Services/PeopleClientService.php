<?php
	namespace PeopleService\Services;

	class PeopleClientService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
	
		function getPeopleClientsByPeopleId($peopleId)
		{
			// returning the array of ClientIds
			return $this->_repository->getPeopleClientsByPeopleId($peopleId);
		}
		
		function insertPeopleClientByPeopleIdClientId($peopleId, $clientId)
		{
			// returning bool if try/catch JM :  does it throw an exception if UNIQUE (can I catch a different exception)
			return $this->_repository->insertPeopleClientByPeopleIdClientId($peopleId, $clientId);
		}
		
		// peoplClient comes from RequestBody
		function updatePeopleClientsByPeopleIdClientIds($peopleId, $clientIds)
		{
			// returning bool if try/catch
			return $this->_repository->updatePeopleClientsByPeopleIdClientIds($peopleId, $clientIds);
		}
		
		function removePeopleClientByPeopleIdClientId($peopleId, $clientId)
		{
			// returning bool if try/catch
			return $this->_repository->removePeopleClientByPeopleIdClientId($peopleId, $clientId);
		}
	}
	