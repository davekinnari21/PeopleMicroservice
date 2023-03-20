<?php
	// controller config
	// allow Post for new JWT, Delete to unauthorize a token
	$acceptedRequestMethods = array("PUT", "OPTIONS");
	
	$config = (require $_SERVER['DOCUMENT_ROOT']."/../people-config.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Includes/controller-security.php");

	$peopleId = null;	
	if(isset($_GET['peopleId']) && !empty($_GET['peopleId']))
		$peopleId = $_GET['peopleId'];

/* flags */
	$htmlOptions = false;
	if(isset($_GET['htmlOptions']))
		$htmlOptions = true;
/* end flags */	
	
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Services/DbService.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/../../PHPSharedLibrary/Models/People/PeopleUserPasswordResponse.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Repositories/PeopleUserPasswordRepository.php");
	require_once($_SERVER['DOCUMENT_ROOT']."/Services/PeopleUserPasswordService.php");
	
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
	$peopleUserPasswordService = new PeopleService\Services\PeopleUserPasswordService(new PeopleService\Repositories\PeopleUserPasswordRepository($db));

	if(isset($peopleId) && $_SERVER['REQUEST_METHOD'] == "PUT")
	{
		$userPassword = $requestBody->PeopleUserPassword;

		if($userPassword->PeopleId != $peopleId) // JM : other verification
			$controllerService->respondBadRequest(); // JM : is this correct resposne?

		$result = $peopleUserPasswordService->updatePasswordByPeopleId($peopleId, $userPassword);

		if($result['Status']) // JM : this should change
			$controllerService->respondOk($result);
		else
			$controllerService->respondConflict();
	}
	else
	{
		$controllerService->respondBadRequest();
	}
	
exit;

