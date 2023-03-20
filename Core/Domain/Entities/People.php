<?php
	namespace People\Domain\Entities;
	
	require_once(__DIR__."/../../../../../PHPSharedLibrary/Entities/Common/AuditableEntity.php");

	class People extends \Shared\Entities\Common\AuditableEntity
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
		public $DateLastModifiedId;
		
		public $isDeleted;
		
		// put mapper here
		public function __construct($data = null)
		{
			if(is_array($data))
			{
				if(isset($data['people_id']))
					$this->PeopleId = $data['people_id'];

				if(isset($data['name_first']))
					$this->NameFirst = $data['name_first'];

				if(isset($data['name_middle']))
					$this->NameMiddle = $data['name_middle'];

				if(isset($data['name_last']))
					$this->NameLast = $data['name_last'];

				if(isset($data['street1']))
					$this->Street1 = $data['street1'];

				if(isset($data['street2']))
					$this->Street2 = $data['street2'];

				if(isset($data['city']))
					$this->City = $data['city'];

				if(isset($data['state']))
					$this->State = $data['state'];

				if(isset($data['zip_code']))
					$this->ZipCode = $data['zip_code'];

				if(isset($data['company']))
					$this->Company = $data['company'];

				if(isset($data['department']))
					$this->Department = $data['department'];
				
				if(isset($data['phone_office']))
					$this->PhoneOffice = $data['phone_office'];
				
				if(isset($data['phone_home']))
					$this->PhoneHome = $data['phone_home'];
				
				if(isset($data['phone_cell']))
					$this->PhoneCell = $data['phone_cell'];
				
				if(isset($data['fax']))
					$this->Fax = $data['fax'];
				
				if(isset($data['email_address_contact']))
					$this->EmailAddressContact = $data['email_address_contact'];
				
				if(isset($data['email_address_personal']))
					$this->EmailAddressPersonal = $data['email_address_personal'];
				
				if(isset($data['emergency_contact_1_name']))
					$this->EmergencyContact1Name = $data['emergency_contact_1_name'];
				
				if(isset($data['emergency_contact_1_relation']))
					$this->EmergencyContact1Relation = $data['emergency_contact_1_relation'];
				
				if(isset($data['emergency_contact_1_phone_1']))
					$this->EmergencyContact1Phone1 = $data['emergency_contact_1_phone_1'];
				
				if(isset($data['emergency_contact_1_phone_2']))
					$this->EmergencyContact1Phone2 = $data['emergency_contact_1_phone_2'];
				
				if(isset($data['emergency_contact_1_email_address']))
					$this->EmergencyContact1EmailAddress = $data['emergency_contact_1_email_address'];
				
				if(isset($data['emergency_contact_2_name']))
					$this->EmergencyContact2Name = $data['emergency_contact_2_name'];
				
				if(isset($data['emergency_contact_2_relation']))
					$this->EmergencyContact2Relation = $data['emergency_contact_2_relation'];
				
				if(isset($data['emergency_contact_2_phone_1']))
					$this->EmergencyContact2Phone1 = $data['emergency_contact_2_phone_1'];
				
				if(isset($data['emergency_contact_2_phone_2']))
					$this->EmergencyContact2Phone2 = $data['emergency_contact_2_phone_2'];
				
				if(isset($data['emergency_contact_2_email_address']))
					$this->EmergencyContact2EmailAddress = $data['emergency_contact_2_email_address'];
				
				if(isset($data['date_created_tz']))
					$this->DateCreatedTz = $data['date_created_tz'];
				
				if(isset($data['created_by_id']))
					$this->CreatedById = $data['created_by_id'];
				
				if(isset($data['date_last_modified_tz']))
					$this->DateLastModifiedTz = $data['date_last_modified_tz'];
				
				if(isset($data['last_modified_by_id']))
					$this->LastModifiedById = $data['last_modified_by_id'];
				
				if(isset($data['is_deleted']))
					$this->isDeleted = $data['is_deleted'];
				
			}
		}
	}