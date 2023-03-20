<?php
	namespace PeopleService\Repositories;

	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleEmployeeStatusHistoryRepository extends \Shared\Repositories\BaseRepository
	{
		public function getPeopleEmployeeStatusHistoryByEmployeeStatusHistoryId($employeeStatusHistoryId)
		{
			$stmt = $this->_db->prepare("SELECT emp_status_history_id, staff_id, employment_status_id, modified, modified_by, role_id, to_char( startdate, 'MM-DD-YYYY' ) AS \"DateStarted\", to_char( enddate, 'MM-DD-YYYY' ) AS \"DateEnded\", startdate, enddate FROM emp_status_history WHERE emp_status_history_id = :employeeStatusHistoryId ");
			$stmt->bindParam(":employeeStatusHistoryId", $employeeStatusHistoryId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}

		public function getPeopleEmployeeStatusHistorysByPeopleId($peopleId)
		{
			// JM : this selects more than 1 sometimes, acccount for this
			$stmt = $this->_db->prepare("SELECT emp_status_history_id, staff_id, employment_status_id, modified, modified_by, role_id, to_char( startdate, 'MM-DD-YYYY' ) AS \"DateStarted\", to_char( enddate, 'MM-DD-YYYY' ) AS \"DateEnded\", startdate, enddate FROM emp_status_history WHERE staff_id = :peopleId ");
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}
	}
