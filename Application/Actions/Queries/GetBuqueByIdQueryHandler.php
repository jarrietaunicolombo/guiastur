<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetBuqueById/Dto/GetBuqueByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/UseCases/GetBuqueById/Dto/GetBuqueByIdResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Actions/Queries/IGetBuqueByIdQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "/guiastur/Application/Contracts/Repositories/IBuqueRepository.php";
class GetBuqueByIdQueryHandler implements IGetBuqueByIdQuery
{

    private $buqueRepository;

    public function __construct(IBuqueRepository $buqueRepository)
    {
        $this->buqueRepository = $buqueRepository;
    }

    public function handler(GetBuqueByIdRequest $request): GetBuqueByIdResponse
    {
        $buque = $this->buqueRepository->findById($request->getId());
        $recaladaList =   $buque->recaladas;
        $atenciones = 0;
        foreach ($recaladaList as $recalada){
            $atencionList = $recalada->atencions;
            $atenciones += @count($atencionList);
        }
        
        $getBuqueByIdResponse = new GetBuqueByIdResponse(
            $buque->id,
            $buque->codigo,
            $buque->nombre,
            $buque->foto,
            @count($recaladaList),
            $atenciones
        );

        return $getBuqueByIdResponse;
    }
}