<?php
	namespace People\Infrastructure\Persistence\Repositories;
	
	require_once(__DIR__."/../../../../../PHPSharedLibrary/Repositories/Base/BasePostgresqlRepository.php");
	require_once(__DIR__."/../../../../../PHPSharedLibrary/Contracts/IRepository.php");

	class PeopleRepository extends \Shared\Repositories\Base\BasePostgresqlRepository // implements \Shared\Contracts\IRepository
	{
//		public $selectAll = "SELECT peoples.people_id, peoples.name_first, peoples.name_middle, peoples.name_last, peoples.street1, peoples.street2, peoples.city, peoples.state, peoples.zip_code, peoples.company, peoples.department, peoples.phone_office, peoples.phone_home, peoples.phone_cell, peoples.fax, peoples.email_address_contact, peoples.email_address_personal, peoples.emergency_contact_1_name, peoples.emergency_contact_1_relation, peoples.emergency_contact_1_phone_1, peoples.emergency_contact_1_phone_2, peoples.emergency_contact_1_email_address, peoples.emergency_contact_2_name, peoples.emergency_contact_2_relation, peoples.emergency_contact_2_phone_1, peoples.emergency_contact_2_phone_2, peoples.emergency_contact_2_email_address, peoples.date_created_tz, peoples.created_by_id, peoples.date_last_modified_tz, peoples.last_modified_by_id, peoples.is_deleted ";
		
		public $selectAll = "SELECT people.people_id, people.firstname AS name_first, people.initial AS name_middle, people.lastname AS name_last, people.street1, people.street2, people.city, people.state, people.zip AS zip_code, people.company, people.department, people.office_phone AS phone_office, people.home_phone AS phone_home, people.cell_phone AS phone_cell, people.fax, people.email AS email_address_contact, people.email_personal AS email_address_personal, people.ec1_name AS emergency_contact_1_name, people.ec1_relation AS emergency_contact_1_relation, people.ec1_phone1 AS emergency_contact_1_phone_1, people.ec1_phone2 AS emergency_contact_1_phone_2, people.ec1_email AS emergency_contact_1_email_address, people.ec2_name AS emergency_contact_2_name, people.ec2_relation AS emergency_contact_2_relation, people.ec2_phone1 AS emergency_contact_2_phone_1, people.ec2_phone2 AS emergency_contact_2_phone_2, people.ec2_email AS emergency_contact_2_email_address, people.date_created_tz, people.created_by_id, people.modified AS date_last_modified_tz, people.modified_by AS last_modified_by_id, people.is_deleted ";
		
		public function __construct($settings)
		{
			parent::__construct($settings);
		}

		public function GetById($peopleId)
		{
//			$stmt = $this->_db->prepare($this->selectAll." FROM peoples WHERE people_id = :peopleId ");
			$stmt = $this->_db->prepare($this->selectAll." FROM people WHERE people_id = :peopleId ");
			$stmt->bindValue(":peopleId", $peopleId, \PDO::PARAM_INT);
			$result = parent::FetchAssoc($stmt);
			
			require_once(__DIR__."/../../../Core/Domain/Entities/People.php");
			return new \People\Domain\Entities\People($result);
		}

		public function GetAll($request)
		{
			$sorting = $request->Sorting;
			$range = $request->Range;
			$search = trim($request->Search);
                    
			$peopleList = array();
			$orderby ="";
			$searchString = "";

			if(isset($sorting)){
				$order = implode(",",$sorting);
				$orderby = " ORDER BY ". $order;     
			}

			if(!empty($search)){
				$searchString = " AND CONCAT_WS(' ', ' ', firstname, initial, lastname, email, ' ') ILIKE '%".strtolower($search)."%' ";
			}

			$stmt = $this->_db->prepare($this->selectAll." FROM people WHERE (is_deleted is null or is_deleted = false)" . $searchString . $orderby . $range);
			$results = parent::FetchAllAssoc($stmt);
			
			require_once(__DIR__."/../../../Core/Domain/Entities/People.php");
			foreach($results as $result)
			{
				$peopleList[] = new \People\Domain\Entities\People($result);
			}
			return $peopleList;
		}
		
		public function getPeopleTotalCount()
		{
			$stmt = $this->_db->prepare("SELECT COUNT(people_id) FROM people WHERE (is_deleted is null OR is_deleted = false) ");
			return parent::FetchAssoc($stmt);
		}
		
		public function getPeopleFilteredCount($search)
		{
			$searchString = "";
			if(!empty($search))
				$searchString = " AND CONCAT_WS(' ', ' ', firstname, initial, lastname, email, ' ') ILIKE '%".strtolower($search)."%' ";
			
			$stmt = $this->_db->prepare("SELECT COUNT(people_id) FROM people WHERE (is_deleted is null OR is_deleted = false) ".$searchString);
			
			return parent::FetchAssoc($stmt);
		}
		
		public function GetActive()
		{
			$peopleList = array();

//			$stmt = $this->_db->prepare($this->selectAll." FROM peoples WHERE (is_deleted is null OR is_deleted = false) ORDER BY peoples.name_last ASC, peoples.name_first ASC, peoples.name_middle ");
			$stmt = $this->_db->prepare($this->selectAll." FROM people WHERE (is_deleted is null OR is_deleted = false) ORDER BY people.lastname ASC, people.firstname ASC, people.initial ");
			$results = parent::FetchAllAssoc($stmt);
			
			require_once(__DIR__."/../../../Core/Domain/Entities/People.php");
			foreach($results as $result)
			{
				$peopleList[] = new \People\Domain\Entities\People($result);
			}
			return $peopleList;
		}
		
		public function Create($people)
		{
			$stmt = $this->_db->prepare("INSERT INTO peoples (name_first, name_middle, name_last, street1, street2, city, state, zip_code, company, department, phone_office, phone_home, phone_cell, fax, email_address_contact, email_address_personal, emergency_contact_1_name, emergency_contact_1_relation, emergency_contact_1_phone_1, emergency_contact_1_phone_2, emergency_contact_1_email_address, emergency_contact_2_name, emergency_contact_2_relation, emergency_contact_2_phone_1, emergency_contact_2_phone_2, emergency_contact_2_email_address, date_created_tz, created_by_id) VALUES (:nameFirst, :nameMiddle, :nameLast, :street1, :street2, :city, :state, :zipCode, :company, :department, :phoneOffice, :phoneHome, :phoneCell, :fax, :emailAddressContact, :emailAddressPersonal, :emergencyContact1Name, :emergencyContact1Relation, :emergencyContact1Phone1, :emergencyContact1Phone2, :emergencyContact1EmailAddress, :emergencyContact2Name, :emergencyContact2Relation, :emergencyContact2Phone1, :emergencyContact2Phone2, :emergencyContact2EmailAddress, current_timestamp, :createdById)  RETURNING people_id AS return_id ");
			$stmt->bindValue(":nameFirst", $people->NameFirst, \PDO::PARAM_STR);
			$stmt->bindValue(":nameMiddle", $people->NameMiddle, \PDO::PARAM_STR);
			$stmt->bindValue(":nameLast", $people->NameLast, \PDO::PARAM_STR);
			$stmt->bindValue(":street1", $people->Street1, \PDO::PARAM_STR);
			$stmt->bindValue(":street2", $people->Street2, \PDO::PARAM_STR);
			$stmt->bindValue(":city", $people->City, \PDO::PARAM_STR);
			$stmt->bindValue(":state", $people->State, \PDO::PARAM_STR);
			$stmt->bindValue(":zipCode", $people->ZipCode, \PDO::PARAM_STR);
			$stmt->bindValue(":company", $people->Company, \PDO::PARAM_STR);
			$stmt->bindValue(":department", $people->Department, \PDO::PARAM_STR);
			$stmt->bindValue(":phoneOffice", $people->PhoneOffice, \PDO::PARAM_STR);
			$stmt->bindValue(":phoneHome", $people->PhoneHome, \PDO::PARAM_STR);
			$stmt->bindValue(":phoneCell", $people->PhoneCell, \PDO::PARAM_STR);
			$stmt->bindValue(":fax", $people->Fax, \PDO::PARAM_STR);
			$stmt->bindValue(":emailAddressContact", $people->EmailAddressContact, \PDO::PARAM_STR);
			$stmt->bindValue(":emailAddressPersonal", $people->EmailAddressPersonal, \PDO::PARAM_STR);			
			$stmt->bindValue(":emergencyContact1Name", $people->EmergencyContact1Name, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact1Relation", $people->EmergencyContact1Relation, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact1Phone1", $people->EmergencyContact1Phone1, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact1Phone2", $people->EmergencyContact1Phone2, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact1EmailAddress", $people->EmergencyContact1EmailAddress, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2Name", $people->EmergencyContact2Name, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2Relation", $people->EmergencyContact2Relation, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2Phone1", $people->EmergencyContact2Phone1, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2Phone2", $people->EmergencyContact2Phone2, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2EmailAddress", $people->EmergencyContact2EmailAddress, \PDO::PARAM_STR);
			$stmt->bindValue(":createdById", $people->CreatedById, \PDO::PARAM_STR);
			$results = parent::FetchAssoc($stmt);
			
			$resultStatus = false;
			if(isset($results["return_id"]))
				$resultStatus = true;
			
			return array("Status" => $resultStatus, "PeopleId" => $results["return_id"]);
		}

		public function Update($people)
		{
                    
			$stmt = $this->_db->prepare('UPDATE peoples SET name_first = :nameFirst, name_middle = :nameMiddle, name_last = :nameLast, street1 = :street1, street2 = :street2, city = :city, state = :state, zip_code = :zipCode, company = :company, department = :department, phone_office = :phoneOffice, phone_home = :phoneHome, phone_cell = :phoneCell, fax = :fax, email_address_contact = :emailAddressContact, email_address_personal = :emailAddressPersonal, emergency_contact_1_name = :emergencyContact1Name, emergency_contact_1_relation = :emergencyContact1Relation, emergency_contact_1_phone_1 = :emergencyContact1Phone1, emergency_contact_1_phone_2 = :emergencyContact1Phone2, emergency_contact_1_email_address = :emergencyContact1EmailAddress, emergency_contact_2_name = :emergencyContact2Name, emergency_contact_2_relation = :emergencyContact2Relation, emergency_contact_2_phone_1 = :emergencyContact2Phone1, emergency_contact_2_phone_2 = :emergencyContact2Phone2, emergency_contact_2_email_address = :emergencyContact2EmailAddress, date_last_modified_tz = current_timestamp, last_modified_by_id = :lastModifiedById, is_deleted = :isDeleted WHERE people_id = :peopleId ');
			$stmt->bindValue(":peopleId", $people->PeopleId, \PDO::PARAM_INT);
			$stmt->bindValue(":nameFirst", $people->NameFirst, \PDO::PARAM_STR);
			$stmt->bindValue(":nameMiddle", $people->NameMiddle, \PDO::PARAM_STR);
			$stmt->bindValue(":nameLast", $people->NameLast, \PDO::PARAM_STR);
			$stmt->bindValue(":street1", $people->Street1, \PDO::PARAM_STR);
			$stmt->bindValue(":street2", $people->Street2, \PDO::PARAM_STR);
			$stmt->bindValue(":city", $people->City, \PDO::PARAM_STR);
			$stmt->bindValue(":state", $people->State, \PDO::PARAM_STR);
			$stmt->bindValue(":zipCode", $people->ZipCode, \PDO::PARAM_STR);
			$stmt->bindValue(":company", $people->Company, \PDO::PARAM_STR);
			$stmt->bindValue(":department", $people->Department, \PDO::PARAM_STR);
			$stmt->bindValue(":phoneOffice", $people->PhoneOffice, \PDO::PARAM_STR);
			$stmt->bindValue(":phoneHome", $people->PhoneHome, \PDO::PARAM_STR);
			$stmt->bindValue(":phoneCell", $people->PhoneCell, \PDO::PARAM_STR);
			$stmt->bindValue(":fax", $people->Fax, \PDO::PARAM_STR);
			$stmt->bindValue(":emailAddressContact", $people->EmailAddressContact, \PDO::PARAM_STR);
			$stmt->bindValue(":emailAddressPersonal", $people->EmailAddressPersonal, \PDO::PARAM_STR);			
			$stmt->bindValue(":emergencyContact1Name", $people->EmergencyContact1Name, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact1Relation", $people->EmergencyContact1Relation, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact1Phone1", $people->EmergencyContact1Phone1, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact1Phone2", $people->EmergencyContact1Phone2, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact1EmailAddress", $people->EmergencyContact1EmailAddress, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2Name", $people->EmergencyContact2Name, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2Relation", $people->EmergencyContact2Relation, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2Phone1", $people->EmergencyContact2Phone1, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2Phone2", $people->EmergencyContact2Phone2, \PDO::PARAM_STR);
			$stmt->bindValue(":emergencyContact2EmailAddress", $people->EmergencyContact2EmailAddress, \PDO::PARAM_STR);
			$stmt->bindValue(":isDeleted", $people->isDeleted, \PDO::PARAM_BOOL);
			$stmt->bindValue(":lastModifiedById", $people->LastModifiedById, \PDO::PARAM_STR);
 		
			$result = parent::Execute($stmt);
                			
			if($result["Status"])
				return array("Status" => $result["Status"], "PeopleId" => intval($people->PeopleId));
			else
				return array("Status" => false);

		}
		
		public function DeleteById($peopleId)
		{
			$stmt = $this->_db->prepare('UPDATE peoples SET is_deleted = true WHERE people_id  = :peopleId ');
			$stmt->bindValue(":peopleId", $peopleId, \PDO::PARAM_INT);
			$result = parent::Execute($stmt);
			
			if($result["Status"])
				return array("Status" => $result["Status"], "PeopleId" => intval($peopleId));
			else
				return array("Status" => false);
		}
	}
