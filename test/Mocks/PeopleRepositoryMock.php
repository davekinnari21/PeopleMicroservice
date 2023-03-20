<?php

	class PeopleRepository
	{
		public $_mockJwt = array("Jwt" => "asdfadfadfweadfad");
		public $_mockResponse = array("Job" => null, "Jobs" => null, "ReturnCode" => 200, "ReturnCodeMessage" => "this is a message");

		public function __construct()
		{
			
		}
		
		public function GetById($id)
		{
			include("./test/Datas/PeopleData.php");
		
			require_once(__DIR__."/../../Core/Domain/Entities/People.php");
			return new \People\Domain\Entities\People($_mockDatas[$id]);
		}
		
		public function GetAll()
		{
			include("./test/Datas/PeopleData.php");
		
			$peopleList = array();
			
			require_once(__DIR__."/../../Core/Domain/Entities/People.php");
			foreach($_mockDatas as $peopleId => $people)
			{
				$peopleList[] = new \People\Domain\Entities\People($people);
			}
			
			return $peopleList;
		}
		
		public function Create($people)
		{
			
		}
		
		public function Update($people)
		{
			
		}
		
		public function DeleteById($people)
		{
			
		}
		
	}
