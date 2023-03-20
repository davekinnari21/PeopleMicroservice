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
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleContactResponse.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Repositories/PeopleContactRepository.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Services/PeopleContactService.php");
	
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
	$peopleContactService = new PeopleService\Services\PeopleContactService(new PeopleService\Repositories\PeopleContactRepository($db));

	// get 1 specific directory listing
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "PUT")
	{
		$peopleContact = $requestBody->peopleContact;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleContact is empty, throw BadRequest
		$result = $peopleContactService->updatePeopleContactByPeopleId($peopleId, $peopleContact);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$peopleContact = $requestBody->peopleContact;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleContact is empty, throw BadRequest
		$result = $peopleContactService->insertPeopleContactByPeopleId($peopleId, $peopleContact);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "DELETE")
	{
		echo "delete"; die;
		$peopleContact = $requestBody->peopleContact;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleContact is empty, throw BadRequest
		$result = $peopleContactService->removePeopleContactByPeopleId($peopleId, $peopleContact);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "GET")
	{
		$peopleContactResponse = new \Shared\Models\People\PeopleContactResponse(array("PeopleContact" =>  $peopleContactService->getPeopleContactByPeopleId($peopleId)));
		
		// if fileId is empty it wasnt found
		if(empty($peopleContactResponse->PeopleContact->PeopleId))
			$controllerService->respondNotFound();
		
		$controllerService->respondOk($peopleContactResponse);
	}
	else
	{
		$controllerService->respondBadRequest();
	}
	
exit;

