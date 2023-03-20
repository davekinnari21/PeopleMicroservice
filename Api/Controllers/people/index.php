<?php
	// controller config
	// allow Post for new JWT, Delete to unauthorize a token
	$acceptedRequestMethods = array("GET", "PUT", "POST", "DELETE", "OPTIONS");
	
	$config = (require __DIR__."/../../../../people-config.php");

	require_once(__DIR__."/../../../../../PHPSharedLibrary/Includes/controller-security.php");

	$peopleId = null;
	if(isset($_GET['peopleId']) && !empty($_GET['peopleId']))
		$peopleId = $_GET['peopleId'];
	
	$peopleIds = null;
	if(isset($_GET['peopleIds']) && !empty($_GET['peopleIds']))
		$peopleIds = $_GET['peopleIds'];
	
	// flags	
	$active = false;
	if(isset($_GET['active']))
		$active = true;
	
	$showAll = false;
	if(isset($_GET["showAll"]) && $_GET["showAll"] == 1)
		$showAll = true;

	require_once(__DIR__."/../../../Infrastructure/Persistence/Repositories/PeopleRepository.php");

	$settings = array("Db" => array("Host" => $config["SisDb"]["Host"], "Name" => $config["SisDb"]["Name"], "User" => $config["SisDb"]["User"], "Password" => $config["SisDb"]["Password"]));
	$peopleRepository = new \People\Infrastructure\Persistence\Repositories\PeopleRepository($settings);


	require_once(__DIR__."/../../../../../PHPSharedLibrary/Mediator/Mediator.php");
	$mediator = new \Shared\Mediator\Mediator();
	$mediator->AddRepository($peopleRepository);
	
	if(isset($peopleId))
	{
		if($requestMethod == "PUT")
		{
			if(!isset($requestBody->EditPeopleDto->PeopleId) || $requestBody->EditPeopleDto->PeopleId != $peopleId)
				$controllerService->respondBadRequest();

				require_once(__DIR__."/../../../Core/Application/Features/Peoples/Commands/UpdatePeople/UpdatePeopleCommand.php");

				// from requestBody
				$request = new \People\Core\Application\Features\Peoples\Commands\UpdatePeople\UpdatePeopleCommand($requestBody->EditPeopleDto);
				$response = $mediator->Send($request); // returns PeopleId

				if($response["Status"])
					$controllerService->respondOk($response);
				else
					$controllerService->respondConflict($response);
		}
		else if($requestMethod == "DELETE")
		{
			require_once(__DIR__."/../../../Core/Application/Features/Peoples/Commands/DeletePeople/DeletePeopleCommand.php");

			$requestBody = json_decode(json_encode(array("PeopleId" => $peopleId)));

			// from requestBody
			$request = new \People\Core\Application\Features\Peoples\Commands\DeletePeople\DeletePeopleCommand($requestBody);

			$response = $mediator->Send($request); // returns PeopleId
		
			if($response["Status"])
				$controllerService->respondOk($response);
			else
				$controllerService->respondNotFound();
                        
			exit;
		}
		else if($requestMethod == "GET")
		{
			require_once(__DIR__."/../../../Core/Application/Features/Peoples/Queries/GetPeopleDetail/GetPeopleDetailQuery.php");

			$requestBody = json_decode(json_encode(array("PeopleId" => $peopleId)));

			// from requestBody
			$request = new \People\Core\Application\Features\Peoples\Queries\GetPeopleDetail\GetPeopleDetailQuery($requestBody);
			
			$peopleDetailVm = $mediator->Send($request); // returns PeopleDetailVm
		
			//validation
			if(isset($peopleDetailVm->PeopleId) && !empty($peopleDetailVm->PeopleId))
				$controllerService->respondOk(array("PeopleDetailVm" => $peopleDetailVm));
			else
				$controllerService->respondNotFound();
			exit;
		}
	}
	else if($requestMethod == "POST")
	{
		require_once(__DIR__."/../../../Core/Application/Features/Peoples/Commands/CreatePeople/CreatePeopleCommand.php");
		
		// from requestBody
		$request = new \People\Core\Application\Features\Peoples\Commands\CreatePeople\CreatePeopleCommand($requestBody->CreatePeopleDto);

		$response = $mediator->Send($request); // returns PeopleId

		if($response["Status"])
			$controllerService->respondOk($response);
		else
			$controllerService->respondConflict();
		exit;
	}
	else if($requestMethod == "GET")
	{
		require_once(__DIR__."/../../../Core/Application/Features/Peoples/Queries/GetPeopleList/GetPeopleListQuery.php");

		$start = null;
		$length = null;
		$search = null;
		
		if(isset($_GET['start']) && !empty($_GET['start']))
			$start = $_GET['start'];

		if(isset($_GET['length']) && !empty($_GET['length']))
			$length = $_GET['length'];

		if(isset($_GET['search']) && !empty($_GET['search']))
			$search = $_GET['search'];

		$peopleSortMap = array (
			"firstname" => "FirstName",
			"lastname" => "LastName"
		);

		$sorting = array();

		// get sorting object from requestBody
		if(isset($requestBody->PeopleSort))
		{
			$sortarr = $requestBody->PeopleSort;
			foreach($sortarr as $column){
				$key = array_search($column[0],$peopleSortMap);
				$column[0] = $key;
				$add = implode(" ",$column);
				array_push($sorting,$add);
			}
		}
		$params = array();  
		$params["Range"] = null;
		if(count($sorting) > 0)
			$params["Sorting"] = $sorting;
		if(isset($search))
			$params["Search"] = $search;
		if(isset($length))
			$params["Range"] = " LIMIT " . $length;
		 if(isset($start))
			$params["Range"] .= " OFFSET ". $start;

		$requestBody = json_decode(json_encode($params));
		
		// from requestBody
		$request = new \People\Core\Application\Features\Peoples\Queries\GetPeopleList\GetPeopleListQuery($requestBody);

		$response = $mediator->Send($request); // returns PeopleListVm

		require_once(__DIR__."/../../../Services/PeopleService.php");
		$peopleService = new \People\Services\PeopleService($peopleRepository);
		
		$metaData = array();
		$totalCount = $peopleService->getPeopleTotalCount();
		$filteredResultCount = $peopleService->getPeopleFilteredCount($search);
		$metaData = array("totalCount" => $totalCount, "filteredResultCount" => $filteredResultCount);

		if(is_array($response))
		{
			if(isset($response["Status"]) && !$response["Status"])
				$controllerService->respondInternalServerError($response);
			else if(count($response) > 0 && isset($response[0]->PeopleId))
			{
				$controllerService->respondOk(array("PeopleListVms" => $response, "Metadata" => $metaData));
			}
			else
				$controllerService->respondNotFound();
		}
		else
			$controllerService->respondNotFound();
	}
	else
		$controllerService->respondBadRequest(); // no permutation of values and methods resulted in a valid request
	
exit;