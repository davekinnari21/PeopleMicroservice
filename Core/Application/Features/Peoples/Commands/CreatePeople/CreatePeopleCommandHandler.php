<?php
	namespace People\Core\Application\Features\Peoples\Commands\CreatePeople;

	require_once(__DIR__."/../../../../../../../../PHPSharedLibrary/Contracts/IRequestHandler.php");

	class CreatePeopleCommandHandler implements \Shared\Contracts\IRequestHandler
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
//			require_once("CreatePeopleValidator.php");
			
/*			$validator = new CreatePeopleValidator($this->_repositories["PeopleRepository"]);
			$validationResult = $validator->Validate($request);
			
			if($validationResult->Errors->Count > 0)
			{
				throw new $Exceptions->ValidationException($validationResult);
			}
*/			
			$repositoryResults =  $this->_repositories["PeopleRepository"]->Create($request);
			return $repositoryResults;
		}
	}