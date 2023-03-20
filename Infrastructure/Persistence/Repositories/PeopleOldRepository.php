<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleOldRepository extends \Shared\Repositories\BaseRepository
	{

		public function getPeopleOldByPeopleId($peopleId)
		{
			$stmt = $this->_db->prepare("SELECT people_id AS \"PeopleId\", old_contact_id, old_role_id, to_char( old_term_date, 'MM-DD-YYYY' ) AS \"DateOldTerm\", old_employment_status_id FROM people where people_id = :peopleId ");
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}
	}