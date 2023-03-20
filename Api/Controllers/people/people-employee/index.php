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
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleEmployeeResponse.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Repositories/PeopleEmployeeRepository.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Services/PeopleEmployeeService.php");
	
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
	$peopleEmployeeService = new PeopleService\Services\PeopleEmployeeService(new PeopleService\Repositories\PeopleEmployeeRepository($db));

	// get 1 specific directory listing
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "PUT")
	{
		$peopleEmployee = $requestBody->peopleEmployee;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleEmployee is empty, throw BadRequest
		$result = $peopleEmployeeService->updatePeopleEmployeeByPeopleId($peopleId, $peopleEmployee);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$peopleEmployee = $requestBody->peopleEmployee;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleEmployee is empty, throw BadRequest
		$result = $peopleEmployeeService->insertPeopleEmployeeByPeopleId($peopleId, $peopleEmployee);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "DELETE")
	{
		echo "delete"; die;
		$peopleEmployee = $requestBody->peopleEmployee;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleEmployee is empty, throw BadRequest
		$result = $peopleEmployeeService->removePeopleEmployeeByPeopleId($peopleId, $peopleEmployee);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "GET")
	{
		$peopleEmployeeResponse = new \Shared\Models\People\PeopleEmployeeResponse(array("PeopleEmployee" =>  $peopleEmployeeService->getPeopleEmployeeByPeopleId($peopleId)));
		
		// if fileId is empty it wasnt found
		if(empty($peopleEmployeeResponse->PeopleEmployee->PeopleId))
			$controllerService->respondNotFound();
		
		$controllerService->respondOk($peopleEmployeeResponse);
	}
	else
	{
		$controllerService->respondBadRequest();
	}
	
exit;

