<?php
	namespace PeopleService\Services;

	
	class PeoplePreferenceService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
		
		function getPeoplePreferenceByPeopleId($peopleId)
		{
			require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeoplePreferenceModel.php");
			return new \Shared\Models\People\PeoplePreferenceModel($this->_repository->getPeoplePreferenceByPeopleId($peopleId, $peoplePreference));
		}

		
		
		
		
		
		
		
		
		
		
		function insertJobTrailers($jobTrailers)
		{
			foreach($jobTrailers as $jobTrailer)
			{
				$this->insertJobTrailer($jobTrailer);
			}
			// returning bool if try/catch JM :  does it throw an exception if UNIQUE (can I catch a different exception)
			return array("Status" => true);
		}		
		
		function insertJobTrailer($jobTrailer)
		{
			// returning bool if try/catch JM :  does it throw an exception if UNIQUE (can I catch a different exception)
			return $this->_repository->insertJobTrailer($jobTrailer);
		}

		function deleteJobTrailersByJobId($jobId)
		{
			return $this->_repository->deleteJobTrailersByJobId($jobId);
		}
		
		// jobBase comes from RequestBody
		function updateJobTrailersByJobId($jobId, $jobTrailers)
		{
			$this->deleteJobTrailersByJobId($jobId);
			// returning bool if try/catch
			return $this->_repository->updateJobBaseByJobId($jobId, $jobBase);
		}
	}