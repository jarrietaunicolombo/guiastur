<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IValidateRecaladaQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/CreateRecalada/Dto/ValidaRecaladaRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Repositories/IRecaladaRepository.php";

class ValidateRecaladaQueryHandler implements IValidateRecaladaQuery{


    private $recaladaRepository;
    
    public function __construct(IRecaladaRepository $recaladaRepository)
    {
        $this->recaladaRepository = $recaladaRepository;
    }

    public function handler(ValidateRecaldaRequest $request) : bool{
    
        return $this->recaladaRepository->validateRecalada($request->getBuqueId(), $request->getFecha());
         
    }
}
