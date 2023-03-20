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
	require_once($_SERVER['DOCUMENT_ROOT']."/Repositories/PeopleVenueRepository.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Services/PeopleVenueService.php");
	
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
	$peopleService = new PeopleService\Services\PeopleVenueService(new PeopleService\Repositories\PeopleVenueRepository($db));

	// get 1 specific directory listing
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "PUT")
	{
		$venueIds = $requestBody->venueIds;

		if($requestBody->peopleId != $peopleId || count($venueIds) < 1)
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $venueIds is empty, throw BadRequest
		$result = $peopleService->updatePeopleVenuesByPeopleIdVenueIds($peopleId, $venueIds);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$venueId = $requestBody->venueId;

		if($requestBody->peopleId != $peopleId || empty($venueId))
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $venueIds is empty, throw BadRequest
		$result = $peopleService->insertPeopleVenueByPeopleIdVenueId($peopleId, $venueId);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "DELETE")
	{
		$venueId = $requestBody->venueId;

		if($requestBody->peopleId != $peopleId || empty($venueId))
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $venueIds is empty, throw BadRequest
		$result = $peopleService->removePeopleVenueByPeopleIdVenueId($peopleId, $venueId);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "GET")
	{
		$peopleJSONResponse = $peopleService->getPeopleVenuesByPeopleId($peopleId);
		
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

