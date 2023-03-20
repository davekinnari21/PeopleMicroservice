<?php
	// controller config
	// allow Post for new JWT, Delete to unauthorize a token
	$acceptedRequestMethods = array("GET", "POST", "PUT", "OPTIONS"); // DELETE is not an option, only get, set, update
	
	$config = (require $_SERVER['DOCUMENT_ROOT']."/../people-config.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Includes/controller-security.php");

	$peopleId = null;
	if(isset($_GET['peopleId']) && !empty($_GET['peopleId']))
		$peopleId = $_GET['peopleId'];

	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Services/DbService.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeoplePreferenceResponse.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Repositories/PeoplePreferenceRepository.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Services/PeoplePreferenceService.php");
	
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
	$peoplePreferenceService = new PeopleService\Services\PeoplePreferenceService(new PeopleService\Repositories\PeoplePreferenceRepository($db));

	// get 1 specific directory listing
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "PUT")
	{
		$peoplePreference = $requestBody->peoplePreference;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peoplePreference is empty, throw BadRequest
		$result = $peoplePreferenceService->updatePeoplePreferenceByPeopleId($peopleId, $peoplePreference);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$peoplePreference = $requestBody->peoplePreference;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peoplePreference is empty, throw BadRequest
		$result = $peoplePreferenceService->insertPeoplePreferenceByPeopleId($peopleId, $peoplePreference);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "GET")
	{
		$peoplePreferenceResponse = new \Shared\Models\People\PeoplePreferenceResponse(array("PeoplePreference" =>  $peoplePreferenceService->getPeoplePreferenceByPeopleId($peopleId)));
		
		// if fileId is empty it wasnt found
		if(empty($peoplePreferenceResponse->PeoplePreference->PeopleId))
			$controllerService->respondNotFound();
		
		$controllerService->respondOk($peoplePreferenceResponse);
	}
	else
	{
		$controllerService->respondBadRequest();
	}
	
exit;

