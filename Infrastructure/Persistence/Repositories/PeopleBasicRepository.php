<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleBasicRepository extends \Shared\Repositories\BaseRepository
	{

		public function getPeopleBasicByPeopleId($peopleId)
		{
			$stmt = $this->_db->prepare('SELECT people_id AS "PeopleId", firstname, initial, lastname, title, company, department, note FROM people WHERE people_id = :peopleId');
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}
	}