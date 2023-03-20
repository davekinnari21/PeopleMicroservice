<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleEmployeeRepository extends \Shared\Repositories\BaseRepository
	{
		public function getPeopleEmployeeByPeopleId($peopleId)
		{
//			$stmt = $this->_db->prepare("SELECT emp_status_history.employment_status_id, emp_status_history.role_id, sm.manager_id, to_char( sm.startdate, 'MM-DD-YYYY' ) AS manager_date, ss.scheduler_id, to_char( ss.startdate, 'MM-DD-YYYY' ) AS scheduler_date, employment_status.description AS employment_status, staff_roles.role_name, staff_roles.role_abbrev, to_char( emp_status_history.startdate, 'MM-DD-YYYY' ) AS role_date, staff_roles.emp_group, people.people_id AS \"PeopleId\", people.default_truck, people.hire_date FROM emp_status_history LEFT JOIN employment_status ON emp_status_history.employment_status_id = employment_status.employment_status_id LEFT JOIN staff_roles ON emp_status_history.role_id = staff_roles.staff_role_id JOIN people ON emp_status_history.staff_id = people.people_id LEFT JOIN staff_schedulers AS ss ON( emp_status_history.staff_id = ss.staff_id AND ss.enddate IS NULL ) LEFT JOIN staff_mgrs AS sm ON( emp_status_history.staff_id = sm.staff_id AND sm.enddate IS NULL ) WHERE emp_status_history.staff_id = :peopleId ");
			$stmt = $this->_db->prepare("SELECT emp_status_history.employment_status_id, emp_status_history.role_id, sm.manager_id, to_char( sm.startdate, 'MM-DD-YYYY' ) AS manager_date, ss.scheduler_id, to_char( ss.startdate, 'MM-DD-YYYY' ) AS scheduler_date, employment_status.description AS employment_status, staff_roles.role_name, staff_roles.role_abbrev, to_char( emp_status_history.startdate, 'MM-DD-YYYY' ) AS role_date, staff_roles.emp_group, people.people_id AS \"PeopleId\", people.default_truck FROM emp_status_history LEFT JOIN employment_status ON emp_status_history.employment_status_id = employment_status.employment_status_id LEFT JOIN staff_roles ON emp_status_history.role_id = staff_roles.staff_role_id JOIN people ON emp_status_history.staff_id = people.people_id LEFT JOIN staff_schedulers AS ss ON( emp_status_history.staff_id = ss.staff_id AND ss.enddate IS NULL ) LEFT JOIN staff_mgrs AS sm ON( emp_status_history.staff_id = sm.staff_id AND sm.enddate IS NULL ) WHERE emp_status_history.staff_id = :peopleId ");
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}
	}