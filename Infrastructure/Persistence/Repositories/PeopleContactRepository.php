<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleContactRepository extends \Shared\Repositories\BaseRepository
	{
		public function getPeopleContactByPeopleId($peopleId)
		{
			// JM : define what makes up the contract records
			$stmt = $this->_db->prepare('SELECT people_id AS "PeopleId", email, street1, street2, city, state, zip, office_phone, cell_phone, home_phone, fax, pager, ec1_name, ec1_relation, ec1_phone1, ec1_phone2, ec1_email, ec2_name, ec2_relation, ec2_phone1, ec2_phone2, ec2_email  FROM people WHERE people_id = :peopleId');
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}

		public function updatePeopleContactByPeopleId($peopleContact)
		{
			try
			{
				$stmt = $this->_db->prepare('UPDATE people SET active = :active, lastname = :lastName, firstname = :firstName, initial = :initial, street1 = :street1, street2 = :street2, city = :city, state = :state, zip = :zipCode, title = :title, company = :company, department = :department, cell_phone = :phoneCell, office_phone = :phoneOffice, home_phone = :phoneHome, fax = :fax, pager = :pager, note = :note WHERE people_id = :peopleId');
				$stmt->bindParam(":peopleId", $peopleContact->PeopleId);
				$stmt->bindParam(":active", $peopleContact->isActive);
				$stmt->bindParam(":lastName", $peopleContact->LastName);
				$stmt->bindParam(":firstName", $peopleContact->FirstName);
				$stmt->bindParam(":initial", $peopleContact->Initial);
				$stmt->bindParam(":street1", $peopleContact->Street1);
				$stmt->bindParam(":street2", $peopleContact->Street2);
				$stmt->bindParam(":city", $peopleContact->City);
				$stmt->bindParam(":state", $peopleContact->State);
				$stmt->bindParam(":zipCode", $peopleContact->ZipCode);
				$stmt->bindParam(":title", $peopleContact->Title);
				$stmt->bindParam(":company", $peopleContact->Company);
				$stmt->bindParam(":department", $peopleContact->Department);
				$stmt->bindParam(":phoneCell", $peopleContact->PhoneCell);
				$stmt->bindParam(":phoneOffice", $peopleContact->PhoneOffice);
				$stmt->bindParam(":phoneHome", $peopleContact->PhoneHome);
				$stmt->bindParam(":fax", $peopleContact->Fax);
				$stmt->bindParam(":pager", $peopleContact->Pager);
				$stmt->bindParam(":note", $peopleContact->Note);
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