<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ILoginUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Features/ILoginQuery.php";
require_once __DIR__ . "/Dto/LoginRequest.php";
require_once __DIR__ . "/Dto/LoginResponse.php";


class LoginUseCase implements ILoginUseCase {
    private $loginQuery;

    public function __construct(ILoginQuery $loginQuery)
    {
        $this->loginQuery = $loginQuery;
    }
        
    
    public function RequestAccess(LoginRequest $request) : LoginResponse{
        return $this->loginQuery->loginAction($request);
    }
}