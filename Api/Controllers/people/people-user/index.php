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
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleUserResponse.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Repositories/PeopleUserRepository.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Services/PeopleUserService.php");
	
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
	
	$db = init_db(); // db_connection(); // connect to the microservice DB
	$peopleUserService = new PeopleService\Services\PeopleUserService(new PeopleService\Repositories\PeopleUserRepository($db));

	// get 1 specific directory listing
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "PUT")
	{
		$peopleUser = $requestBody->peopleUser;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleUser is empty, throw BadRequest
		$result = $peopleUserService->updatePeopleUserByPeopleId($peopleId, $peopleUser);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$peopleUser = $requestBody->peopleUser;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleUser is empty, throw BadRequest
		$result = $peopleUserService->insertPeopleUserByPeopleId($peopleId, $peopleUser);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "DELETE")
	{
		echo "delete"; die;
		$peopleUser = $requestBody->peopleUser;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleUser is empty, throw BadRequest
		$result = $peopleUserService->removePeopleUserByPeopleId($peopleId, $peopleUser);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "GET")
	{
		$peopleUserResponse = new \Shared\Models\People\PeopleUserResponse(array("PeopleUser" =>  $peopleUserService->getPeopleUserByPeopleId($peopleId)));
		
		// if fileId is empty it wasnt found
		if(empty($peopleUserResponse->PeopleUser->PeopleId))
			$controllerService->respondNotFound();
		
		$controllerService->respondOk($peopleUserResponse);
	}
	else
	{
		$controllerService->respondBadRequest();
	}
	
exit;

