<?php
	// controller config
	// allow Post for new JWT, Delete to unauthorize a token
	$acceptedRequestMethods = array("GET", "POST", "PUT", "DELETE", "OPTIONS");
	
	$config = (require $_SERVER['DOCUMENT_ROOT']."/../people-config.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Includes/controller-security.php");

	$peopleId = null;
	if(isset($_GET['peopleId']) && !empty($_GET['peopleId']))
		$peopleId = $_GET['peopleId'];

	$employeeStatusHistoryId = null;
	if(isset($_GET['employeeStatusHistoryId']) && !empty($_GET['employeeStatusHistoryId']))
		$employeeStatusHistoryId = $_GET['employeeStatusHistoryId'];

	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Services/DbService.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/EmployeeStatusHistoryResponse.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Repositories/PeopleEmployeeStatusHistoryRepository.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Services/PeopleEmployeeStatusHistoryService.php");
	
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
	$peopleEmployeeStatusHistoryService = new PeopleService\Services\PeopleEmployeeStatusHistoryService(new PeopleService\Repositories\PeopleEmployeeStatusHistoryRepository($db));

	// get 1 specific directory listing
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "PUT")
	{
		$peopleEmployeeStatusHistory = $requestBody->peopleEmployeeStatusHistory;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleEmployeeStatusHistory is empty, throw BadRequest
		$result = $peopleEmployeeStatusHistoryService->updatePeopleEmployeeStatusHistoryByPeopleId($peopleId, $peopleEmployeeStatusHistory);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "POST")
	{
		$peopleEmployeeStatusHistory = $requestBody->peopleEmployeeStatusHistory;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleEmployeeStatusHistory is empty, throw BadRequest
		$result = $peopleEmployeeStatusHistoryService->insertPeopleEmployeeStatusHistoryByPeopleId($peopleId, $peopleEmployeeStatusHistory);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "DELETE")
	{
		echo "delete"; die;
		$peopleEmployeeStatusHistory = $requestBody->peopleEmployeeStatusHistory;

		if($requestBody->peopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		// if $peopleEmployeeStatusHistory is empty, throw BadRequest
		$result = $peopleEmployeeStatusHistoryService->removePeopleEmployeeStatusHistoryByPeopleId($peopleId, $peopleEmployeeStatusHistory);

		if($result) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "GET")
	{
		$peopleEmployeeStatusHistoryResponse = new \Shared\Models\EmployeeStatusHistoryResponse(array("EmployeeStatusHistorys" =>  $peopleEmployeeStatusHistoryService->getPeopleEmployeeStatusHistorysByPeopleId($peopleId)));
		
		// if EmployeeStatusHistorys is empty it wasnt found
		if(empty($peopleEmployeeStatusHistoryResponse->EmployeeStatusHistorys)) // JM : this should change
			$controllerService->respondNotFound();
		
		$controllerService->respondOk($peopleEmployeeStatusHistoryResponse);
	}
	else
	{
		$controllerService->respondBadRequest();
	}
	
exit;

