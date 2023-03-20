<?php
	// controller config
	// allow Post for new JWT, Delete to unauthorize a token
	$acceptedRequestMethods = array("GET", "POST", "PUT", "DELETE", "OPTIONS");
	
	$config = (require $_SERVER['DOCUMENT_ROOT']."/../people-config.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Includes/controller-security.php");

	$peopleId = null;
	if(isset($_GET['peopleId']) && !empty($_GET['peopleId']))
		$peopleId = $_GET['peopleId'];

	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Services/DbService.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleSettingResponse.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Repositories/PeopleSettingRepository.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Services/PeopleSettingService.php");
	
// JM : pass tokenservice to controller service?  or vice versa
	// controller service, setup access rights, parsing, etc
//	$tokenService = new Shared\Services\TokenService();
//	$requestBody = json_decode(file_get_contents("php://input"));
//	$decrypted = $tokenService->ParseToken($requestBody->Jwt);
/*	if($decrypted->SystemId != $tokenService->SystemId)
	{
		http_response_code(401);
		exit;
	}*/
	// JM : add permissions here
	
	$db = \Shared\Services\DbService::connect($config["SisDb"]["Host"], $config["SisDb"]["Name"], $config["SisDb"]["User"], $config["SisDb"]["Password"]);
	$peopleSettingService = new PeopleService\Services\PeopleSettingService(new PeopleService\Repositories\PeopleSettingRepository($db));

	// get 1 specific directory listing
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "PUT")
	{
		$peopleSetting = $requestBody->peopleSetting;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleSetting is empty, throw BadRequest
		$result = $peopleSettingService->updatePeopleSettingByPeopleId($peopleId, $peopleSetting);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$peopleSetting = $requestBody->peopleSetting;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleSetting is empty, throw BadRequest
		$result = $peopleSettingService->insertPeopleSettingByPeopleId($peopleId, $peopleSetting);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "DELETE")
	{
		echo "delete"; die;
		$peopleSetting = $requestBody->peopleSetting;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleSetting is empty, throw BadRequest
		$result = $peopleSettingService->removePeopleSettingByPeopleId($peopleId, $peopleSetting);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "GET")
	{
		$peopleSettingResponse = new \Shared\Models\People\PeopleSettingResponse(array("PeopleSetting" =>  $peopleSettingService->getPeopleSettingByPeopleId($peopleId)));
		
		// if fileId is empty it wasnt found
		if(empty($peopleSettingResponse->PeopleSetting->PeopleId))
			$controllerService->respondNotFound();
		
		$controllerService->respondOk($peopleSettingResponse);
	}
	else
	{
		$controllerService->respondBadRequest();
	}
	
exit;

