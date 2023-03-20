<?php
	namespace People\Core\Application\Features\Peoples\Queries\GetPeopleList;

	class PeopleListVm
	{
		public $PeopleId; // GUID
		public $NameFirst; // STR
		public $NameMiddle; // STR
		public $NameLast; // STR
		public $Company; // STR
		public $Department; // STR
		public $PhoneOffice; // STR
		public $PhoneCell; // STR
		public $EmailAddressContact; // STR
		
		public function __construct($entity = null)
		{
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

				if(isset($entity->Company))
					$this->Company = $entity->Company;

				if(isset($entity->Department))
					$this->Department = $entity->Department;

				if(isset($entity->PhoneOffice))
					$this->PhoneOffice = $entity->PhoneOffice;

				if(isset($entity->PhoneCell))
					$this->PhoneCell = $entity->PhoneCell;

				if(isset($entity->EmailAddressContact))
					$this->EmailAddressContact = $entity->EmailAddressContact;

			}
		}
	}