<?php
	namespace People\Core\Application\Features\Peoples\Commands\UpdatePeople;

	require_once(__DIR__."/../../../../../../../../PHPSharedLibrary/Contracts/IRequest.php");
	
	class UpdatePeopleCommand implements \Shared\Contracts\IRequest
	{
		public $PeopleId;

		public $NameFirst;
		public $NameMiddle;
		public $NameLast;
		
		public $Street1;
		public $Street2;
		public $City;
		public $State;
		public $ZipCode;
		
		public $Company;
		public $Department;
		
		public $PhoneOffice;
		public $PhoneHome;
		public $PhoneCell;
		public $Fax;
		
		public $EmailAddressContact;
		public $EmailAddressPersonal;
	
		public $EmergencyContact1Name;
		public $EmergencyContact1Relation;
		public $EmergencyContact1Phone1;
		public $EmergencyContact1Phone2;
		public $EmergencyContact1EmailAddress;

		public $EmergencyContact2Name;
		public $EmergencyContact2Relation;
		public $EmergencyContact2Phone1;
		public $EmergencyContact2Phone2;
		public $EmergencyContact2EmailAddress;

		public $isDeleted;

		public $LastModifiedById;

		public $Path;
				
		public function __construct($data)
		{
			if(isset($data->PeopleId))
				$this->PeopleId = $data->PeopleId;

			if(isset($data->NameFirst))
				$this->NameFirst = $data->NameFirst;

			if(isset($data->NameMiddle))
				$this->NameMiddle = $data->NameMiddle;

			if(isset($data->NameLast))
				$this->NameLast = $data->NameLast;

			if(isset($data->Street1))
				$this->Street1 = $data->Street1;

			if(isset($data->Street2))
				$this->Street2 = $data->Street2;

			if(isset($data->City))
				$this->City = $data->City;

			if(isset($data->State))
				$this->State = $data->State;

			if(isset($data->ZipCode))
				$this->ZipCode = $data->ZipCode;

			if(isset($data->Company))
				$this->Company = $data->Company;

			if(isset($data->Department))
				$this->Department = $data->Department;

			if(isset($data->PhoneOffice))
				$this->PhoneOffice = $data->PhoneOffice;

			if(isset($data->PhoneHome))
				$this->PhoneHome = $data->PhoneHome;

			if(isset($data->PhoneCell))
				$this->PhoneCell = $data->PhoneCell;

			if(isset($data->Fax))
				$this->Fax = $data->Fax;

			if(isset($data->EmailAddressContact))
				$this->EmailAddressContact = $data->EmailAddressContact;

			if(isset($data->EmailAddressPersonal))
				$this->EmailAddressPersonal = $data->EmailAddressPersonal;

			if(isset($data->EmergencyContact1Name))
				$this->EmergencyContact1Name = $data->EmergencyContact1Name;

			if(isset($data->EmergencyContact1Relation))
				$this->EmergencyContact1Relation = $data->EmergencyContact1Relation;

			if(isset($data->EmergencyContact1Phone1))
				$this->EmergencyContact1Phone1 = $data->EmergencyContact1Phone1;

			if(isset($data->EmergencyContact1Phone2))
				$this->EmergencyContact1Phone2 = $data->EmergencyContact1Phone2;

			if(isset($data->EmergencyContact1EmailAddress))
				$this->EmergencyContact1EmailAddress = $data->EmergencyContact1EmailAddress;

			if(isset($data->EmergencyContact2Name))
				$this->EmergencyContact2Name = $data->EmergencyContact2Name;

			if(isset($data->EmergencyContact2Relation))
				$this->EmergencyContact2Relation = $data->EmergencyContact2Relation;

			if(isset($data->EmergencyContact2Phone1))
				$this->EmergencyContact2Phone1 = $data->EmergencyContact2Phone1;

			if(isset($data->EmergencyContact2Phone2))
				$this->EmergencyContact2Phone2 = $data->EmergencyContact2Phone2;

			if(isset($data->EmergencyContact2EmailAddress))
				$this->EmergencyContact2EmailAddress = $data->EmergencyContact2EmailAddress;
			
			if(isset($data->isDeleted))
				$this->isDeleted = $data->isDeleted;
			
			if(isset($data->LastModifiedById))
				$this->LastModifiedById = $data->LastModifiedById;

			$this->Path = dirname(__FILE__);
		}
	}
        