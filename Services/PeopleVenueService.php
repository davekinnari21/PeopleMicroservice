<?php
	namespace PeopleService\Services;

	class PeopleVenueService
	{
		private $_repository;
		
		public function __construct($repository)
		{
			 $this->_repository = $repository;
		}
	
		function getPeopleVenuesByPeopleId($peopleId)
		{
			// returning the array of VenueIds
			return $this->_repository->getPeopleVenuesByPeopleId($peopleId);
		}
		
		function insertPeopleVenueByPeopleIdVenueId($peopleId, $venueId)
		{
			// returning bool if try/catch JM :  does it throw an exception if UNIQUE (can I catch a different exception)
			return $this->_repository->insertPeopleVenueByPeopleIdVenueId($peopleId, $venueId);
		}
		
		// peopleVenue comes from RequestBody
		function updatePeopleVenuetsByPeopleIdVenueIds($peopleId, $venueIds)
		{
			// returning bool if try/catch
			return $this->_repository->updatePeopleVenuesByPeopleIdVenueIds($peopleId, $venueIds);
		}
		
		function removePeopleVenueByPeopleIdVenueId($peopleId, $venueId)
		{
			// returning bool if try/catch
			return $this->_repository->removePeopleVenueByPeopleIdVenueId($peopleId, $venueId);
		}
	}
	