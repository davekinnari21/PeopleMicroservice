<?php
	require "/var/www/html/gcv/vendor/autoload.php";
	use PHPUnit\Framework\TestCase;
	
	class PeopleTest extends TestCase
	{
		public function testPeopleDetailTest()
		{
			require_once("./Core/Application/Features/Peoples/Queries/GetPeopleDetail/GetPeopleDetailQuery.php");
			$request = new \People\Core\Application\Features\Peoples\Queries\GetPeopleDetail\GetPeopleDetailQuery(json_decode(json_encode(array("PeopleId" => 1))));
			
			require_once("./test//Mocks/PeopleRepositoryMock.php");
			$mockRepository = new PeopleRepository();

			require_once("/var/www/html/gcv/PHPSharedLibrary/Mediator/Mediator.php");
			$mediator = new \Shared\Mediator\Mediator();
			$mediator->AddRepository($mockRepository);
			
			$response = $mediator->Send($request); // returns PeopleDetailVm

			include("./test/Datas/PeopleData.php");
			
			$this->assertEquals($_mockDatas["1"]["people_id"], $response->PeopleId);
			$this->assertEquals($_mockDatas["1"]["name_first"], $response->NameFirst);
			$this->assertEquals($_mockDatas["1"]["name_middle"], $response->NameMiddle);
			$this->assertEquals($_mockDatas["1"]["name_last"], $response->NameLast);
			$this->assertEquals($_mockDatas["1"]["street1"], $response->Street1);			
			$this->assertEquals($_mockDatas["1"]["street2"], $response->Street2);			
			$this->assertEquals($_mockDatas["1"]["city"], $response->City);			
			$this->assertEquals($_mockDatas["1"]["state"], $response->State);			
			$this->assertEquals($_mockDatas["1"]["zip_code"], $response->ZipCode);		
			$this->assertEquals($_mockDatas["1"]["company"], $response->Company);
			$this->assertEquals($_mockDatas["1"]["department"], $response->Department);
			$this->assertEquals($_mockDatas["1"]["phone_office"], $response->PhoneOffice);
			$this->assertEquals($_mockDatas["1"]["phone_home"], $response->PhoneHome);
			$this->assertEquals($_mockDatas["1"]["phone_cell"], $response->PhoneCell);
			$this->assertEquals($_mockDatas["1"]["fax"], $response->Fax);
			$this->assertEquals($_mockDatas["1"]["email_address_contact"], $response->EmailAddressContact);
			$this->assertEquals($_mockDatas["1"]["email_address_personal"], $response->EmailAddressPersonal);
			$this->assertEquals($_mockDatas["1"]["emergency_contact_1_name"], $response->EmergencyContact1Name);
			$this->assertEquals($_mockDatas["1"]["emergency_contact_1_relation"], $response->EmergencyContact1Relation);
			$this->assertEquals($_mockDatas["1"]["emergency_contact_1_phone_1"], $response->EmergencyContact1Phone1);
			$this->assertEquals($_mockDatas["1"]["emergency_contact_1_phone_2"], $response->EmergencyContact1Phone2);
			$this->assertEquals($_mockDatas["1"]["emergency_contact_1_email_address"], $response->EmergencyContact1EmailAddress);
			$this->assertEquals($_mockDatas["1"]["emergency_contact_2_name"], $response->EmergencyContact2Name);
			$this->assertEquals($_mockDatas["1"]["emergency_contact_2_relation"], $response->EmergencyContact2Relation);
			$this->assertEquals($_mockDatas["1"]["emergency_contact_2_phone_1"], $response->EmergencyContact2Phone1);
			$this->assertEquals($_mockDatas["1"]["emergency_contact_2_phone_2"], $response->EmergencyContact2Phone2);			
			$this->assertEquals($_mockDatas["1"]["emergency_contact_2_email_address"], $response->EmergencyContact2EmailAddress);			
			$this->assertEquals($_mockDatas["1"]["date_created_tz"], $response->DateCreatedTz);			
			$this->assertEquals($_mockDatas["1"]["created_by_id"], $response->CreatedById);			
			$this->assertEquals($_mockDatas["1"]["date_last_modified_tz"], $response->DateLastModifiedTz);			
			$this->assertEquals($_mockDatas["1"]["last_modified_by_id"], $response->LastModifiedById);			
			$this->assertEquals($_mockDatas["1"]["is_deleted"], $response->isDeleted);
			$this->assertTrue($response->isDeleted);
		}

		public function testPeopleListTest()
		{
			require_once("./Core/Application/Features/Peoples/Queries/GetPeopleList/GetPeopleListQuery.php");
			$request = new \People\Core\Application\Features\Peoples\Queries\GetPeopleList\GetPeopleListQuery(json_decode(json_encode(array())));
			
			require_once("./test/Mocks/PeopleRepositoryMock.php");
			$mockRepository = new PeopleRepository();

			require_once("/var/www/html/gcv//PHPSharedLibrary/Mediator/Mediator.php");
			$mediator = new \Shared\Mediator\Mediator();
			$mediator->AddRepository($mockRepository);
			
			$response = $mediator->Send($request); // returns PeopleListVm

			include("./test/Datas/PeopleData.php");
			
			$this->assertIsArray($response);
			$this->assertCount(3, $response);
			
			$this->assertEquals($_mockDatas["1"]["people_id"], $response[0]->PeopleId);
			$this->assertEquals($_mockDatas["1"]["name_first"], $response[0]->NameFirst);
			$this->assertEquals($_mockDatas["1"]["name_middle"], $response[0]->NameMiddle);
			$this->assertEquals($_mockDatas["1"]["name_last"], $response[0]->NameLast);
			$this->assertEquals($_mockDatas["1"]["company"], $response[0]->Company);
			$this->assertEquals($_mockDatas["1"]["department"], $response[0]->Department);
			$this->assertEquals($_mockDatas["1"]["phone_office"], $response[0]->PhoneOffice);
			$this->assertEquals($_mockDatas["1"]["phone_cell"], $response[0]->PhoneCell);
			$this->assertEquals($_mockDatas["1"]["email_address_contact"], $response[0]->EmailAddressContact);
			
			$this->assertEquals($_mockDatas["2"]["people_id"], $response[1]->PeopleId);
			$this->assertEquals($_mockDatas["2"]["name_first"], $response[1]->NameFirst);
			$this->assertEquals($_mockDatas["2"]["name_middle"], $response[1]->NameMiddle);
			$this->assertEquals($_mockDatas["2"]["name_last"], $response[1]->NameLast);
			$this->assertEquals($_mockDatas["2"]["company"], $response[1]->Company);
			$this->assertEquals($_mockDatas["2"]["department"], $response[1]->Department);
			$this->assertEquals($_mockDatas["2"]["phone_office"], $response[1]->PhoneOffice);
			$this->assertEquals($_mockDatas["2"]["phone_cell"], $response[1]->PhoneCell);
			$this->assertEquals($_mockDatas["2"]["email_address_contact"], $response[1]->EmailAddressContact);
			
			$this->assertEquals($_mockDatas["3"]["people_id"], $response[2]->PeopleId);
			$this->assertEquals($_mockDatas["3"]["name_first"], $response[2]->NameFirst);
			$this->assertEquals($_mockDatas["3"]["name_middle"], $response[2]->NameMiddle);
			$this->assertEquals($_mockDatas["3"]["name_last"], $response[2]->NameLast);
			$this->assertEquals($_mockDatas["3"]["company"], $response[2]->Company);
			$this->assertEquals($_mockDatas["3"]["department"], $response[2]->Department);
			$this->assertEquals($_mockDatas["3"]["phone_office"], $response[2]->PhoneOffice);
			$this->assertEquals($_mockDatas["3"]["phone_cell"], $response[2]->PhoneCell);
			$this->assertEquals($_mockDatas["3"]["email_address_contact"], $response[2]->EmailAddressContact);
		}

	}

	
	

	
	
