<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleClientRepository extends \Shared\Repositories\BaseRepository
	{
		public function getPeopleClientsByPeopleId($peopleId)
		{
			$stmt = $this->_db->prepare('SELECT client_id FROM clients_people_xrf WHERE people_id = :peopleId ');
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}

		public function insertPeopleClientByPeopleIdClientId($peopleId, $clientId)
		{
			try
			{
				$stmt = $this->_db->prepare('INSERT INTO clients_people_xrf (client_id, people_id) VALUES (:clientId, :peopleId) ');
				$stmt->bindParam(":peopleId", $peopleId);
				$stmt->bindParam(":clientId", $clientId);
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
		

		public function updatePeopleClientsByPeopleId($peopleId, $clientIds)
		{
			try
			{
				$stmt = $this->_db->prepare('DELETE FROM clients_people_xrf WHERE people_id = :peopleId ');
				$stmt->bindParam(":peopleId", $peopleId);
				$stmt->execute();

				foreach ($clientIds as $clientId)
				{
					$stmt = $this->_db->prepare('INSERT INTO clients_people_xrf (client_id, people_id) VALUES (:clientId, :peopleId) ');
					$stmt->bindParam(":peopleId", $peopleId);
					$stmt->bindParam(":clientId", $clientId);
					$stmt->execute();
				}
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

		public function removePeopleClientByPeopleIdClientId($peopleId, $clientId)
		{
			try
			{
				$stmt = $this->_db->prepare('DELETE FROM clients_people_xrf WHERE people_id = :peopleId AND client_id = :clientId');
				$stmt->bindParam(":peopleId", $peopleId);
				$stmt->bindParam(":clientId", $clientId);
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

		// JM : add remove ALL by peopleId?   clientId?
	}