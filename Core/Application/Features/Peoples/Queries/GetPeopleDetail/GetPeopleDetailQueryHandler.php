<?php
	namespace People\Core\Application\Features\Peoples\Queries\GetPeopleDetail;

	require_once(__DIR__."/../../../../../../../../PHPSharedLibrary/Contracts/IRequestHandler.php");

	class GetPeopleDetailQueryHandler implements \Shared\Contracts\IRequestHandler
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
			$repositoryResults = $this->_repositories["PeopleRepository"]->GetById($request->PeopleId);

			require_once("PeopleDetailVm.php");
			$returnVm = new PeopleDetailVm($repositoryResults); // mapping here
			return $returnVm;
		}
	}