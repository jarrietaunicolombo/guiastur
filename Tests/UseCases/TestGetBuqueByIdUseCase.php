<?php
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Infrastructure/Reposotories/BuqueRepository.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Actions/Queries/GetBuqueByIdQueryHandler.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuqueById/GetBuqueByIdUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuqueById/Dto/GetBuqueByIdRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetBuqueById/Dto/GetBuqueByIdResponse.php";

class TestGetBuqueByIdUseCase{

    public static function testGetBuqueByIdShouldShowData(){
        // Arrange
        $buqueRepository = new BuqueRepository();
        $getBuqueByIdQuery = new GetBuqueByIdQueryHandler($buqueRepository);
        $getBuqueByIdUseCase = new GetBuqueByIdUseCase($getBuqueByIdQuery);
        $buqueId = 1;
        $request = new GetBuqueByIdRequest($buqueId);
        $response = $getBuqueByIdUseCase->getBuqueById($request);
        TestGetBuqueByIdUseCase::showBuqueData( array($response), "Datos del Buque ID : $buqueId");

        //Act

        //Assert
    }

 public static function showBuqueData( $buques, string $title)
    {
        $output = "<hr/><h3>$title</h3>
        <table border=4> <tr> 
          <th>BUQUE ID</th> 
          <th>CODIGO</th> 
          <th>NOMBRE ID</th> 
          <th>FOTO</th> 
          <th>RECALADAS</th> 
          <th>ATENCIONES</th> 
          </tr> ";
        foreach ($buques as $buque) {
            $output .= "<tr><td>" . $buque->getId() . "</td> 
            <td>" . $buque->getCodigo() . "</td> 
            <td>" . $buque->getNombre() . "</td> 
            <td>" . $buque->getFoto() . "</td> 
            <td>" . $buque->getTotalRecaladas() . "</td> 
            <td>" . $buque->getTotalAtenciones() ."</td></tr>";
        }
        $output .= "</table>";
        echo $output;

    }

}

TestGetBuqueByIdUseCase::testGetBuqueByIdShouldShowData( );