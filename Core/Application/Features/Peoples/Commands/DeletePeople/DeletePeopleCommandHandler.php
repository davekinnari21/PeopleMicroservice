<?php
	namespace People\Core\Application\Features\Peoples\Commands\DeletePeople;

	require_once(__DIR__."/../../../../../../../../PHPSharedLibrary/Contracts/IRequestHandler.php");

	class DeletePeopleCommandHandler implements \Shared\Contracts\IRequestHandler
	{
		private $_services;
		private $_repositories;
		
		public function __construct($services, $repositories)
		{
			$this->_services = $services;
			$this->_repositories = $repositories;
		}
		
		public function Handle($request)
		{
			$repositoryResults =  $this->_repositories["PeopleRepository"]->DeleteById($request->PeopleId);
			return $repositoryResults;
		}
	}