<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleUserPasswordRepository extends \Shared\Repositories\BaseRepository
	{
		public function updatePasswordByPeopleId($peopleId, $userPassword)
		{
			if(($peopleId != $userPassword->PeopleId) || ($userPassword->Password == null))
				return array("Status" => false, "Message" => "Mismatched Ids");
			
			// JM : should probably store name here to separate Job from People, how to handle name changes
			try
			{
				$stmt = $this->_db->prepare('UPDATE people SET password = :password, password_last_change = now() WHERE people_id = :peopleId ');
				$stmt->bindValue(":peopleId", $userPassword->PeopleId, PDO::PARAM_INT);
				$stmt->bindValue(":password", $userPassword->Password, PDO::PARAM_STR);
				$stmt->execute();
				return array("Status" => true);
			}
			catch(PDOException $ex)
			{
				error_log($ex->getMessage());
				return array("Status" => false, "Message" => $ex->getMessage());
			}
			catch(Exception $ex)
			{
				error_log($ex-getMessage());
				return array("Status" => false, "Message" => $ex->getMessage());					
			}				
		}
	}
