<?php
	namespace PeopleService\Repositories;
	// https://stackoverflow.com/questions/16176990/proper-repository-pattern-design-in-php
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleRepository extends \Shared\Repositories\BaseRepository
	{
		public $selectAll = "SELECT people_id, lastname, firstname, , abbrev, street1, street2, city, state, zip, phone, fax, contact, brands, comments, active, modified, modified_by, website, form, instructions ";
		
		public $whereSort = "WHERE concat(lastname, ' ', firstname, ' ', company, ' ', email, ' ', street1, ' ', street2, ' ', city, ' ', state, ' ', zip , ' ', cell_phone, ' ', office_phone) ILIKE '%' || :searchTerm || '%' ";

		function getPeopleTotalCount()
		{
			$stmt = $this->_db->prepare("SELECT COUNT(people_id) FROM people");
			$stmt->execute();
			return $stmt->fetchColumn();
		}
		
		function getPeopleFilteredCount($search)
		{
			$searchString = "";
			if(!empty($search))
			{
				$searchString = $this->whereSort;
			}
			
			$stmt = $this->_db->prepare("SELECT COUNT(people_id) FROM people ".$searchString);
			if(!empty($search))
			{
				$stmt->bindValue(":searchTerm", strtolower($search), PDO::PARAM_STR);
			}
			$stmt->execute();
			return $stmt->fetchColumn();
		}
		
		function getPeoples($start, $length, $order, $search)
		{
			if(!empty($order))
				$order = "ORDER BY ".$order;
			
			$searchString = "";
			if(!empty($search))
			{
				$searchString = $this->whereSort;
			}

			$stmt = $this->_db->prepare($this->selectAll." FROM people ".$searchString." ".$order.((isset($length))?" LIMIT :length ":"").((isset($start))?" OFFSET :start ":""));
			$stmt->bindValue(":start", $start, PDO::PARAM_INT);
			$stmt->bindValue(":length", $length, PDO::PARAM_INT);
			if(!empty($search))
			{
				$stmt->bindValue(":searchTerm", strtolower($search), PDO::PARAM_STR);
			}
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();			
		}

		function getPeoplesFiltered($start, $length, $order, $search)
		{
			if(!empty($order))
				$order = "ORDER BY ".$order;
			
			$searchString = "";
			if(!empty($search))
			{
				$searchString = $this->whereSort;
			}

			$stmt = $this->_db->prepare("SELECT people_id, lastname, firstname, company, email, cell_phone, office_phone, street1, street2, city, state, zip FROM people ".$searchString." ".$order.((isset($length))?" LIMIT :length ":"").((isset($start))?" OFFSET :start ":""));
			$stmt->bindValue(":start", $start, PDO::PARAM_INT);
			$stmt->bindValue(":length", $length, PDO::PARAM_INT);
			if(!empty($search))
			{
				$stmt->bindValue(":searchTerm", strtolower($search), PDO::PARAM_STR);
			}
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();			
		}
		
		public function getPeopleByPeopleId($peopleId)
		{
			$stmt = $this->_db->prepare('SELECT people_id, active, modified, modified_by FROM people WHERE people_id = :peopleId');
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}
		
		public function getAllActivePeoples()
		{
			$stmt = $this->_db->prepare($this->selectAll." FROM people WHERE active = 't' ORDER by name ASC");
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		}
		
		public function findAll()
		{
			$stmt = $this->_db->prepare($this->selectAll.' FROM people ORDER by name ASC');
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll();
		}
		
		public function insertPeople($people)
		{
			try
			{
				$stmt = $this->_db->prepare('INSERT INTO people (lastname, firstname, initial, street1, street2, city, state, zip, office_phone, cell_phone, home_phone, fax, pager, email, note, title, company, department, active, modified, modified_by) VALUES (:lastName, :firstName, :initial, :street1, :street2, :city, :state, :zipCode, :phoneOffice, :phoneCell, :phoneHome, :fax, :pager, :emailAddress, :note, :title, :company, :department, :isActive, now(), :modifiedById) ');
				$stmt->bindValue(":lastName", $people->Basic->LastName, PDO::PARAM_STR);
				$stmt->bindValue(":firstName", $people->Basic->FirstName, PDO::PARAM_STR);
				$stmt->bindValue(":initial", $people->Basic->Initial, PDO::PARAM_STR);
				$stmt->bindValue(":street1", $people->Contact->Street1, PDO::PARAM_STR);
				$stmt->bindValue(":street2", $people->Contact->Street2, PDO::PARAM_STR);
				$stmt->bindValue(":city", $people->Contact->City, PDO::PARAM_STR);
				$stmt->bindValue(":state", $people->Contact->State, PDO::PARAM_STR);
				$stmt->bindValue(":zipCode", $people->Contact->ZipCode, PDO::PARAM_STR);
				$stmt->bindValue(":phoneOffice", $people->Contact->PhoneOffice, PDO::PARAM_STR);
				$stmt->bindValue(":phoneCell", $people->Contact->PhoneCell, PDO::PARAM_STR);
				$stmt->bindValue(":phoneHome", $people->Contact->PhoneHome, PDO::PARAM_STR);
				$stmt->bindValue(":fax", $people->Contact->Fax, PDO::PARAM_STR);
				$stmt->bindValue(":pager", $people->Contact->Pager, PDO::PARAM_STR);
				$stmt->bindValue(":emailAddress", strtolower($people->Contact->EmailAddress), PDO::PARAM_STR);
				$stmt->bindValue(":note", $people->Basic->Note, PDO::PARAM_STR);
				$stmt->bindValue(":title", $people->Basic->Title, PDO::PARAM_STR);
				$stmt->bindValue(":company", $people->Basic->Company, PDO::PARAM_STR);
				$stmt->bindValue(":department", $people->Basic->Department, PDO::PARAM_STR);
				$stmt->bindValue(":isActive", $people->isActive, PDO::PARAM_BOOL);
				$stmt->bindValue(":modifiedById", $people->ModifiedById, PDO::PARAM_INT);
				$stmt->execute();
				return array("Status" => true);
			}
			catch(PDOException $ex)
			{
				return array("Status" => false, "Message" => $ex->getMessage());
			}
			catch(Exception $ex)
			{
				return array("Status" => false, "Message" => $ex->getMessage());					
			}	
		}
		
		public function updatePeopleByPeopleId($people)
		{
			try
			{
				$stmt = $this->_db->prepare('UPDATE people SET lastname = :lastName, firstname = :firstName, initial = :initial, street1 = :street1, street2 = :street2, city = :city, state = :state, zip = :zipCode, office_phone = :phoneOffice, cell_phone = :phoneCell, home_phone = :phoneHome, fax = :fax, pager = :pager, email = :emailAddress, note = :note, title = :title, company = :company, department = :department, active = :isActive, modified = now(), modified_by = :modifiedById WHERE people_id = :peopleId ');
				$stmt->bindValue(":peopleId", $people->PeopleId, PDO::PARAM_INT);
				$stmt->bindValue(":lastName", $people->Basic->LastName, PDO::PARAM_STR);
				$stmt->bindValue(":firstName", $people->Basic->FirstName, PDO::PARAM_STR);
				$stmt->bindValue(":initial", $people->Basic->Initial, PDO::PARAM_STR);
				$stmt->bindValue(":street1", $people->Contact->Street1, PDO::PARAM_STR);
				$stmt->bindValue(":street2", $people->Contact->Street2, PDO::PARAM_STR);
				$stmt->bindValue(":city", $people->Contact->City, PDO::PARAM_STR);
				$stmt->bindValue(":state", $people->Contact->State, PDO::PARAM_STR);
				$stmt->bindValue(":zipCode", $people->Contact->ZipCode, PDO::PARAM_STR);
				$stmt->bindValue(":phoneOffice", $people->Contact->PhoneOffice, PDO::PARAM_STR);
				$stmt->bindValue(":phoneCell", $people->Contact->PhoneCell, PDO::PARAM_STR);
				$stmt->bindValue(":phoneHome", $people->Contact->PhoneHome, PDO::PARAM_STR);
				$stmt->bindValue(":fax", $people->Contact->Fax, PDO::PARAM_STR);
				$stmt->bindValue(":pager", $people->Contact->Pager, PDO::PARAM_STR);
				$stmt->bindValue(":emailAddress", strtolower($people->Contact->EmailAddress), PDO::PARAM_STR);
				$stmt->bindValue(":note", $people->Basic->Note, PDO::PARAM_STR);
				$stmt->bindValue(":title", $people->Basic->Title, PDO::PARAM_STR);
				$stmt->bindValue(":company", $people->Basic->Company, PDO::PARAM_STR);
				$stmt->bindValue(":department", $people->Basic->Department, PDO::PARAM_STR);
				$stmt->bindValue(":isActive", $people->isActive, PDO::PARAM_BOOL);
				$stmt->bindValue(":modifiedById", $people->ModifiedById, PDO::PARAM_INT);
				$stmt->execute();
				return array("Status" => true);
			}
			catch(PDOException $ex)
			{
				return array("Status" => false, "Message" => $ex->getMessage());
			}
			catch(Exception $ex)
			{
				return array("Status" => false, "Message" => $ex->getMessage());					
			}	
		}

		public function removePeopleByPeopleId($peopleId)
		{
			try
			{
				$stmt = $this->_db->prepare('DELETE FROM people WHERE people_id = :peopleId');
				$stmt->bindParam(":peopleId", $peopleId);
				$stmt->execute();
				return array("Status" => true);
			}
			catch(PDOException $ex)
			{
				return array("Status" => false, "Message" => $ex->getMessage());
			}
			catch(Exception $ex)
			{
				return array("Status" => false, "Message" => $ex->getMessage());					
			}	
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	class ArchivedPeopleRepository extends \Shared\Repositories\BaseRepository
	{
		public function getActivePeoplePhotosByEmpGroups($employmentGroups, $employmentStatusIds, $orderBy)
		{
			$stmt = $this->_db->prepare('SELECT DISTINCT firstname, lastname, staff_id, emp_group, employment_status_id, title, role_name FROM all_staff WHERE emp_group IN ('.$employmentGroups.') AND employment_status_id IN ('.$employmentStatusIds.') ORDER BY '.$orderBy);
//			$stmt->bindParam(":employmentGroups", $employmentGroups);
//			$stmt->bindParam(":employmentStatusIds", $employmentStatusIds);
//			$stmt->bindParam(":orderBy", $orderBy);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}

		public function getPeoplePhotosByJobId($jobId, $employmentGroups, $employmentStatusIds, $orderBy)
		{
			$stmt = $this->_db->prepare('SELECT DISTINCT firstname, lastname, staff_id, emp_group, employment_status_id, title, role_name FROM all_staff AS a JOIN job_staff AS js USING(staff_id) WHERE js.job_id = :jobId AND a.emp_group IN ('.$employmentGroups.') AND a.employment_status_id IN ('.$employmentStatusIds.') ORDER BY '.$orderBy);
			$stmt->bindParam(":jobId", $jobId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}

		public function getActiveStaffDirectorysByEmpGroups($employmentGroups, $employmentStatusIds, $orderBy)
		{
			$stmt = $this->_db->prepare('SELECT DISTINCT all_staff.staff_id, all_staff.fullname, all_staff.title, all_staff.emp_status, all_staff.role_name, all_staff.startdate, all_staff.enddate, all_staff.emp_group, all_staff.employment_status_id, all_staff.role_id, all_staff.firstname, all_staff.initial, all_staff.lastname, all_staff.manager_id, all_staff.manager_name, all_staff.manager_date, all_staff.scheduler_id, all_staff.scheduler_name, all_staff.scheduler_date, p.street1, p.street2, p.city, p.state, p.zip, p.office_phone, p.cell_phone, p.email, up.make_address_public, p.company FROM all_staff INNER JOIN people AS p ON (p.people_id = all_staff.staff_id) LEFT JOIN user_prefs AS up ON (all_staff.staff_id = up.staff_id) WHERE p.active = TRUE AND emp_group IN ('.$employmentGroups.') AND employment_status_id IN ('.$employmentStatusIds.') ORDER BY '.$orderBy);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}

		public function getActiveStaffDirectorysByJobId($jobId, $employmentGroups, $employmentStatusIds, $orderBy)
		{
			$stmt = $this->_db->prepare('SELECT DISTINCT all_staff.staff_id, all_staff.fullname, all_staff.title, all_staff.emp_status, all_staff.role_name, all_staff.startdate, all_staff.enddate, all_staff.emp_group, all_staff.employment_status_id, all_staff.role_id, all_staff.firstname, all_staff.initial, all_staff.lastname, all_staff.manager_id, all_staff.manager_name, all_staff.manager_date, all_staff.scheduler_id, all_staff.scheduler_name, all_staff.scheduler_date, p.street1, p.street2, p.city, p.state, p.zip, p.office_phone, p.cell_phone, p.email, up.make_address_public, p.company FROM all_staff INNER JOIN job_staff as js USING(staff_id) INNER JOIN people AS p ON (p.people_id = all_staff.staff_id) LEFT JOIN user_prefs AS up ON (all_staff.staff_id = up.staff_id) WHERE js.job_id = :jobId');
			$stmt->bindParam(":jobId", $jobId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}


		public function getStaffByPeopleId($peopleId)
		{
			$stmt = $this->_db->prepare('SELECT people_id, people_id AS "StaffId", lastname, firstname, initial, street1, street2, city, state, zip, title, active, company, department, cell_phone, office_phone, home_phone, email, fax, pager, note, perms, perms2, perms3, inv_perms, prohibit_login, estimate_travel_days, active, modified, modified_by FROM people WHERE people_id = :peopleId');
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}
		
		public function getAllStaffs()
		{
			$stmt = $this->_db->prepare('SELECT people_id, people_id AS "StaffId", lastname, firstname, initial, street1, street2, city, state, zip, title, active, company, department, cell_phone, office_phone, home_phone, email, fax, pager, note, perms, perms2, perms3, inv_perms, prohibit_login, estimate_travel_days, active, modified, modified_by FROM people ');
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}
		

		
		
		
		
		public function getPeopleByPeopleId($peopleId)
		{
			$stmt = $this->_db->prepare('SELECT people_id, active, modified, modified_by FROM people WHERE people_id = :peopleId');
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}		
		// new below this
	}