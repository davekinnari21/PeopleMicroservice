<?php
	namespace PeopleService\Services;

	class PeopleUserPasswordService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
		
		function updatePasswordByPeopleId($peopleId, $userPassword)
		{
			// returning bool if try/catch
			return $this->_repository->updatePasswordByPeopleId($peopleId, $userPassword);
		}

	}