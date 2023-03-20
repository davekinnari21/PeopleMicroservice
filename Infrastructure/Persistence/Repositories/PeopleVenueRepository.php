<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleVenueRepository extends \Shared\Repositories\BaseRepository
	{
		public function getPeopleVenuesByPeopleId($peopleId)
		{
			$stmt = $this->_db->prepare('SELECT venue_id FROM venues_people_xrf WHERE people_id = :peopleId ');
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetchAll(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}

		public function insertPeopleVenueByPeopleIdVenueId($peopleId, $venueId)
		{
			try
			{
				$stmt = $this->_db->prepare('INSERT INTO venues_people_xrf (venue_id, people_id) VALUES (:venueId, :peopleId) ');
				$stmt->bindParam(":peopleId", $peopleId);
				$stmt->bindParam(":venueId", $venueId);
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
		

		public function updatePeopleVenuesByPeopleId($peopleId, $venueIds)
		{
			try
			{
				$stmt = $this->_db->prepare('DELETE FROM venues_people_xrf WHERE people_id = :peopleId ');
				$stmt->bindParam(":peopleId", $peopleId);
				$stmt->execute();

				foreach ($venueIds as $venueId)
				{
					$stmt = $this->_db->prepare('INSERT INTO venues_people_xrf (venue_id, people_id) VALUES (:venueId, :peopleId) ');
					$stmt->bindParam(":peopleId", $peopleId);
					$stmt->bindParam(":venueId", $venueId);
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

		public function removePeopleVenueByPeopleIdVenueId($peopleId, $venueId)
		{
			try
			{
				$stmt = $this->_db->prepare('DELETE FROM venues_people_xrf WHERE people_id = :peopleId AND venue_id = :venueId');
				$stmt->bindParam(":peopleId", $peopleId);
				$stmt->bindParam(":venueId", $venueId);
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

		// JM : add remove ALL by peopleId?   venueId?
	}