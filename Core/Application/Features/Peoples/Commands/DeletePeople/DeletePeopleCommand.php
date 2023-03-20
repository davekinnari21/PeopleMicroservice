<?php
	namespace People\Core\Application\Features\Peoples\Commands\DeletePeople;

	require_once(__DIR__."/../../../../../../../../PHPSharedLibrary/Contracts/IRequest.php");
	
	class DeletePeopleCommand implements \Shared\Contracts\IRequest
	{
		public $PeopleId;

		public $Path;
				
		public function __construct($data)
		{
			if(isset($data->PeopleId))
				$this->PeopleId = $data->PeopleId;

			$this->Path = dirname(__FILE__);
		}
	}