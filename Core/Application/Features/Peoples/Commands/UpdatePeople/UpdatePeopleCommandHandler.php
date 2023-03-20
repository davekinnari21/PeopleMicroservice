<?php
	namespace People\Core\Application\Features\Peoples\Commands\UpdatePeople;

	require_once(__DIR__."/../../../../../../../../PHPSharedLibrary/Contracts/IRequestHandler.php");

	class UpdatePeopleCommandHandler implements \Shared\Contracts\IRequestHandler
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
//			require_once("CreateBroadcastSystemValidator.php");
			
/*			$validator = new CreateBroadcastSystemValidator($this->_repositories["BroadcastSystemRepository"]);
			$validationResult = $validator->Validate($request);
			
			if($validationResult->Errors->Count > 0)
			{
				throw new $Exceptions->ValidationException($validationResult);
			}
*/			
			$repositoryResults =  $this->_repositories["PeopleRepository"]->Update($request);
			return $repositoryResults;
		}
	}