<?php
	namespace People\Core\Application\Features\Peoples\Queries\GetPeopleDetail;

	class PeopleDetailVm
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

		public $DateCreatedTz;
		public $CreatedById;
		public $DateLastModifiedTz;
		public $LastModifiedById;
		
		public $isDeleted;
		
		public function __construct($entity = null)
		{
			// entity to Vm mapping
			if(isset($entity))
			{
				if(isset($entity->PeopleId))
					$this->PeopleId = $entity->PeopleId;

				if(isset($entity->NameFirst))
					$this->NameFirst = $entity->NameFirst;

				if(isset($entity->NameMiddle))
					$this->NameMiddle = $entity->NameMiddle;

				if(isset($entity->NameLast))
					$this->NameLast = $entity->NameLast;

				if(isset($entity->Street1))
					$this->Street1 = $entity->Street1;

				if(isset($entity->Street2))
					$this->Street2 = $entity->Street2;

				if(isset($entity->City))
					$this->City = $entity->City;

				if(isset($entity->State))
					$this->State = $entity->State;

				if(isset($entity->ZipCode))
					$this->ZipCode = $entity->ZipCode;

				if(isset($entity->Company))
					$this->Company = $entity->Company;

				if(isset($entity->Department))
					$this->Department = $entity->Department;
				
				if(isset($entity->PhoneOffice))
					$this->PhoneOffice = $entity->PhoneOffice;
				
				if(isset($entity->PhoneHome))
					$this->PhoneHome = $entity->PhoneHome;
				
				if(isset($entity->PhoneCell))
					$this->PhoneCell = $entity->PhoneCell;
				
				if(isset($entity->Fax))
					$this->Fax = $entity->Fax;
				
				if(isset($entity->EmailAddressContact))
					$this->EmailAddressContact = $entity->EmailAddressContact;
				
				if(isset($entity->EmailAddressPersonal))
					$this->EmailAddressPersonal = $entity->EmailAddressPersonal;
				
				if(isset($entity->EmergencyContact1Name))
					$this->EmergencyContact1Name = $entity->EmergencyContact1Name;
				
				if(isset($entity->EmergencyContact1Relation))
					$this->EmergencyContact1Relation = $entity->EmergencyContact1Relation;
				
				if(isset($entity->EmergencyContact1Phone1))
					$this->EmergencyContact1Phone1 = $entity->EmergencyContact1Phone1;
				
				if(isset($entity->EmergencyContact1Phone2))
					$this->EmergencyContact1Phone2 = $entity->EmergencyContact1Phone2;
				
				if(isset($entity->EmergencyContact1EmailAddress))
					$this->EmergencyContact1EmailAddress = $entity->EmergencyContact1EmailAddress;
				
				if(isset($entity->EmergencyContact2Name))
					$this->EmergencyContact2Name = $entity->EmergencyContact2Name;
				
				if(isset($entity->EmergencyContact2Relation))
					$this->EmergencyContact2Relation = $entity->EmergencyContact2Relation;
				
				if(isset($entity->EmergencyContact2Phone1))
					$this->EmergencyContact2Phone1 = $entity->EmergencyContact2Phone1;
				
				if(isset($entity->EmergencyContact2Phone2))
					$this->EmergencyContact2Phone2 = $entity->EmergencyContact2Phone2;
				
				if(isset($entity->EmergencyContact2EmailAddress))
					$this->EmergencyContact2EmailAddress = $entity->EmergencyContact2EmailAddress;
				
				if(isset($entity->DateCreatedTz))
					$this->DateCreatedTz = $entity->DateCreatedTz;
				
				if(isset($entity->CreatedById))
					$this->CreatedById = $entity->CreatedById;
				
				if(isset($entity->DateLastModifiedTz))
					$this->DateLastModifiedTz = $entity->DateLastModifiedTz;
				
				if(isset($entity->LastModifiedById))
					$this->LastModifiedById = $entity->LastModifiedById;
				
				if(isset($entity->isDeleted))
					$this->isDeleted = $entity->isDeleted;
				
			}
		}
	}