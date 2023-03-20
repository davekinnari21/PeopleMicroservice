<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleUserRepository extends \Shared\Repositories\BaseRepository
	{
		public function getPeopleUserByPeopleId($peopleId)
		{
			$stmt = $this->_db->prepare("SELECT people_id AS \"PeopleId\", email, username, password_last_change, login_alert, last_login, to_char( people.last_login, 'MM-DD-YYYY' ) AS \"DateLastSignIn\" FROM people where people_id = :peopleId ");
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}
	}