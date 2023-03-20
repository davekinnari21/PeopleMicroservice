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
	require_once($_SERVER['DOCUMENT_ROOT']."/Repositories/PeopleClientRepository.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Services/PeopleClientService.php");
	
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
	$peopleService = new PeopleService\Services\PeopleClientService(new PeopleService\Repositories\PeopleClientRepository($db));

	// get 1 specific directory listing
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "PUT")
	{
		$clientIds = $requestBody->clientIds;

		if($requestBody->peopleId != $peopleId || count($clientIds) < 1)
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $clientIds is empty, throw BadRequest
		$result = $peopleService->updatePeopleClientsByPeopleIdClientIds($peopleId, $clientIds);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$clientId = $requestBody->clientId;

		if($requestBody->peopleId != $peopleId || empty($clientId))
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $clientIds is empty, throw BadRequest
		$result = $peopleService->insertPeopleClientByPeopleIdClientId($peopleId, $clientId);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "DELETE")
	{
		$clientId = $requestBody->clientId;

		if($requestBody->peopleId != $peopleId || empty($clientId))
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $clientIds is empty, throw BadRequest
		$result = $peopleService->removePeopleClientByPeopleIdClientId($peopleId, $clientId);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "GET")
	{
		$peopleJSONResponse = $peopleService->getPeopleClientsByPeopleId($peopleId);
		
		// if StaffId is empty it wasnt found
		if(empty($peopleJSONResponse)) // JM : this should change
			$controllerService->respondNotFound();
		
		$controllerService->respondOk($peopleJSONResponse);	
	}
	else
	{
		$controllerService->respondBadRequest();
	}
	
exit;

