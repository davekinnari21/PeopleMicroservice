<?php
	namespace People\Core\Application\Features\Peoples\Queries\GetPeopleList;

	require_once(__DIR__."/../../../../../../../../PHPSharedLibrary/Contracts/IRequestHandler.php");

	class GetPeopleListQueryHandler implements \Shared\Contracts\IRequestHandler
	{
		private $_services;
		private $_repositories;
		
		public function __construct($services, $repositories)// , categoryRepository
		{
			$this->_services = $services;
			$this->_repositories = $repositories;
		}
		
		public function Handle($request)
		{
			$returnArray = null;

			$repositoryResults = $this->_repositories["PeopleRepository"]->GetAll($request);

			require_once("PeopleListVm.php");
			
			foreach($repositoryResults as $repositoryResult)
			{
				$returnArray[] = new PeopleListVm($repositoryResult); // mapping here
			}
			
			return $returnArray;
		}
	}
	