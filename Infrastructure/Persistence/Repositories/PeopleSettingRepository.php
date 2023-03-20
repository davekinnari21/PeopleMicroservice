<?php
	namespace PeopleService\Repositories;
	
	use \PDO;
	use \PDOException;
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Repositories/BaseRepository.php");

	class PeopleSettingRepository extends \Shared\Repositories\BaseRepository
	{

		public function getPeopleSettingByPeopleId($peopleId)
		{
//			$stmt = $this->_db->prepare("SELECT people.people_id AS \"PeopleId\", staff_roles.allowed_permissions, staff_roles.allowed_permissions2, staff_roles.allowed_permissions3, staff_roles.allowed_permissions_inv, staff_roles.calc_days_owed, staff_roles.count_weekends, to_char( people.date_to_start_counting_days, 'MM-DD-YYYY' 	) AS \"DateToStartCountingDays\", people.days_owed_gcv_dec_2009, staff_roles.default_job_summary_view, staff_roles.display_in_lists, 	employment_status.earn_vacation_days AS earn_vacation,  staff_roles.edit_emergency_contacts, people.estimate_travel_days, people.grid_sort_order, to_char( people.hire_date_override, 'MM-DD-YYYY' 	) AS \"DateHireOverriden\", people.hire_date_override AS \"DateHireOverridenTs\", people.last_concur_sync, staff_roles.overtime_eligible, 	people.perms, people.perms2, people.perms3, people.inv_perms, people.photos_to_s3, people.prohibit_login, staff_roles.request_removal_window_days, staff_roles.sick_time_units, staff_roles.staff_status_units AS \"StatusUnit\", staff_roles.vac_hours_after_cutoff_date, staff_roles.vac_requests_skip_holidays, to_char( people.vpn_access_until, 'MM-DD-YYYY' ) AS \"DateVPNAccessUntil\" FROM emp_status_history LEFT JOIN employment_status ON emp_status_history.employment_status_id = employment_status.employment_status_id LEFT JOIN staff_roles ON emp_status_history.role_id = staff_roles.staff_role_id JOIN people ON emp_status_history.staff_id = people.people_id WHERE emp_status_history.staff_id = :peopleId ");
			$stmt = $this->_db->prepare("SELECT people.people_id AS \"PeopleId\", staff_roles.allowed_permissions, staff_roles.allowed_permissions2, staff_roles.allowed_permissions3, staff_roles.allowed_permissions_inv, staff_roles.calc_days_owed, staff_roles.count_weekends, to_char( people.date_to_start_counting_days, 'MM-DD-YYYY' 	) AS \"DateToStartCountingDays\", people.days_owed_gcv_dec_2009, staff_roles.default_job_summary_view, staff_roles.display_in_lists, 	employment_status.earn_vacation_days AS earn_vacation,  staff_roles.edit_emergency_contacts, people.estimate_travel_days, people.grid_sort_order, to_char( people.hire_date_override, 'MM-DD-YYYY' 	) AS \"DateHireOverriden\", people.hire_date_override AS \"DateHireOverridenTs\", people.last_concur_sync, staff_roles.overtime_eligible, 	people.perms, people.perms2, people.perms3, people.inv_perms, people.photos_to_s3, people.prohibit_login, staff_roles.request_removal_window_days, staff_roles.sick_time_units, staff_roles.staff_status_units AS \"StatusUnit\", staff_roles.vac_hours_after_cutoff_date, staff_roles.vac_requests_skip_holidays FROM emp_status_history LEFT JOIN employment_status ON emp_status_history.employment_status_id = employment_status.employment_status_id LEFT JOIN staff_roles ON emp_status_history.role_id = staff_roles.staff_role_id JOIN people ON emp_status_history.staff_id = people.people_id WHERE emp_status_history.staff_id = :peopleId ");
			$stmt->bindParam(":peopleId", $peopleId);
			$stmt->execute();
			$stmt->setFetchMode(PDO::FETCH_ASSOC);
			return $stmt->fetch(); // JM : add error handling here?  or does the setAttribute handle raising an exception
		}
	}