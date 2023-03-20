<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeoplePreferenceRepository extends \Shared\Repositories\BaseRepository
	{
		public $selectAll = "SELECT notification_email, staff_id, cal_initials, default_cal, default_cal_truck_id, jump_to_today, mobile_default_full_cal, default_job_summary_view, ignore_mobile_devices, google_token, google_cal_url, cal_popup_options, long_cal_weeks, calendar_start, select_staff_split_list, make_address_public, select_staff_order, notifications, google_access_token, google_calendar_sync, google_calendar_id, news_share, inv_datatable, google_acct_mgr_calendar_sync ";

		public function getPeoplePreferenceByPeopleId($peopleId)
		{
			$stmt = $this->_db->prepare($this->selectAll.' FROM user_prefs WHERE staff_id = :peopleId');
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}











		
		public function insertPeoplePreference($jobTrailer)
		{
			try
			{
				$stmt = $this->_db->prepare('INSERT INTO job_trucks (job_id, truck_id, comment, modified, modified_by, concur_status, concur_status_time, assignment_preference) VALUES (:jobId, :trailerId, :comment, current_timestamp, :modifiedById, :concurStatus, to_timestamp(:dateConcurStatusTz), :assignmentPreferenceId) ');
				$stmt->bindValue(":jobId", $jobTrailer->JobId, PDO::PARAM_INT);
				$stmt->bindValue(":trailerId", $jobTrailer->TrailerId, PDO::PARAM_INT);
				$stmt->bindValue(":comment", $jobTrailer->Comment, PDO::PARAM_STR);
				$stmt->bindValue(":modifiedById", $jobTrailer->ModifiedById, PDO::PARAM_INT);
				$stmt->bindValue(":concurStatus", $jobTrailer->ConcurStatus, PDO::PARAM_STR);
				$stmt->bindValue(":dateConcurStatusTz", ((!empty($jobTrailer->DateConcurStatusTz))?$jobTrailer->DateConcurStatusTz:null), PDO::PARAM_STR);
				$stmt->bindValue(":assignmentPreferenceId", (($jobTrailer->AssignmentPreferenceId < 0)?$jobTrailer->AssignmentPreferenceId:100), PDO::PARAM_INT);
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
		
		public function updatePeoplePreferenceByPeopleId($jobId, $jobTrailers)
		{
			echo "not setup, can't update until we get a primary key";die;

			try
			{
				$stmt = $this->_db->prepare('UPDATE jobs SET client_id = :clientId, venue_id = :venueId, category_id = :categoryId, contract_id = :contractId, name = :name, startdat) = to_timestamp(:dateStartedTz), enddate = to_timestamp(:dateEndedTz), truck_position = :truckPosition, comment = :comment, tentative = :isTentative, non_billable = :isNonBillable, reg_staff_required = :isRegularStaffRequired, canceled = :isCancelled, video_format_id = :videoFormatId, transmission = :transmission, modified_by = :modifiedById, account_mgr_id = :accountManagerId, bill_to_client_id = :billToClientId, client_show_code = :clientShowCode, travel_reimburseable = :travelReimbursableId, modified = current_timestamp WHERE job_id = :jobId ');
				$stmt->bindValue(":jobId", $jobId, PDO::PARAM_INT); // using JobId as a validation
				$stmt->bindValue(":clientId", $jobBase->ClientId, PDO::PARAM_INT);
				$stmt->bindValue(":venueId", $jobBase->VenueId, PDO::PARAM_INT);
				$stmt->bindValue(":categoryId", $jobBase->CategoryId, PDO::PARAM_INT);
				$stmt->bindValue(":contractId", $jobBase->ContractId, PDO::PARAM_INT);
				$stmt->bindValue(":name", $jobBase->Name, PDO::PARAM_STR);
				$stmt->bindValue(":dateStartedTz", $jobBase->DateStartedTz, PDO::PARAM_STR);
				$stmt->bindValue(":dateEndedTz", $jobBase->DateEndedTz, PDO::PARAM_STR);
				$stmt->bindValue(":truckPosition", $jobBase->TruckPosition, PDO::PARAM_STR);
				$stmt->bindValue(":comment", $jobBase->Comment, PDO::PARAM_STR);
				$stmt->bindValue(":isTentative", $jobBase->isTentative, PDO::PARAM_BOOL);
				$stmt->bindValue(":isNonBillable", $jobBase->isNonBillable, PDO::PARAM_BOOL);
				$stmt->bindValue(":isRegularStaffRequired", $jobBase->isRegularStaffRequired, PDO::PARAM_BOOL);
				$stmt->bindValue(":isCancelled", $jobBase->isCancelled, PDO::PARAM_BOOL);
				$stmt->bindValue(":videoFormatId", $jobBase->VideoFormatId, PDO::PARAM_INT);
				$stmt->bindValue(":transmission", $jobBase->Transmission, PDO::PARAM_STR);
				$stmt->bindValue(":modifiedById", $jobBase->ModifiedById, PDO::PARAM_INT);
				$stmt->bindValue(":accountManagerId", $jobBase->AccountManagerId, PDO::PARAM_INT);
				$stmt->bindValue(":billToClientId", $jobBase->BillToClientId, PDO::PARAM_INT);
				$stmt->bindValue(":clientShowCode", $jobBase->ClientShowCode, PDO::PARAM_STR);
				$stmt->bindValue(":travelReimbursableId", $jobBase->TravelReimbursableId, PDO::PARAM_INT);

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
		
		public function deleteJobTrailersByJobId($jobId)
		{
			try
			{
				$stmt = $this->_db->prepare('DELETE FROM job_trucks WHERE job_id = :jobId');
				$stmt->bindParam(":jobId", $jobId);
				$stmt->execute();
				$stmt->setFetchMode(PDO::FETCH_ASSOC);
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
