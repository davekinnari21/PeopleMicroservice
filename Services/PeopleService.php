<?php
	namespace People\Services;
	
	class PeopleService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}

		function getPeopleTotalCount()
		{
			return $this->_repository->getPeopleTotalCount();
		}
		
		function getPeopleFilteredCount($search)
		{
			return $this->_repository->getPeopleFilteredCount($search);
		}

	}