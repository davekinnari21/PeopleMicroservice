<?php
	namespace People\Core\Application\Features\Peoples\Queries\GetPeopleList;

	require_once(__DIR__."/../../../../../../../../PHPSharedLibrary/Contracts/IRequest.php");
	
	class GetPeopleListQuery implements \Shared\Contracts\IRequest
	{
		public $Sorting;
		public $Range;
		public $Search;

		public $ShowAll;
		
		public $Path;
				
		public function __construct($data)
		{	
			if(isset($data->Sorting))
				$this->Sorting = $data->Sorting;

			if(isset($data->Range))
				$this->Range = $data->Range;

			 if(isset($data->Search))
				$this->Search = $data->Search;
					
			if(isset($data->ShowAll))
				$this->ShowAll = $data->ShowAll;
			
			$this->Path = dirname(__FILE__);
		}
	}