<?php
	namespace People\Core\Application\Features\Peoples\Queries\GetPeopleDetail;

	require_once(__DIR__."/../../../../../../../../PHPSharedLibrary/Contracts/IRequest.php");
	
	class GetPeopleDetailQuery implements \Shared\Contracts\IRequest
	{
		public $PeopleId; // INT
		
		public $Path;
				
		public function __construct($data)
		{
			if(isset($data->PeopleId))
				$this->PeopleId = $data->PeopleId;
			
			$this->Path = dirname(__FILE__);
		}
	}