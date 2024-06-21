<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ILoginUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/ILoginQuery.php";
require_once __DIR__ . "/Dto/LoginRequest.php";
require_once __DIR__ . "/Dto/LoginResponse.php";


class LoginUseCase implements ILoginUseCase {
    private $loginQuery;

    public function __construct(ILoginQuery $loginQuery)
    {
        $this->loginQuery = $loginQuery;
    }
        
    
    public function login(LoginRequest $request) : LoginResponse{
        return $this->loginQuery->handler($request);
    }
}