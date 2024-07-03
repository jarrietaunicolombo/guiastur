<?php
require_once __DIR__ . "/Dto/CreateTurnoRequest.php";
require_once __DIR__ . "/Dto/CreateTurnoResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionRequest.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/UseCases/GetTurnosByAtencionUseCase/Dto/GetTurnosByAtencionResponse.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/UseCases/ICreateTurnoUseCase.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Queries/IGetTurnosByAtencionQuery.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Contracts/Actions/Commands/ICreateTurnoCommand.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/DuplicateEntryException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/NumberTurnosExceededException.php";
require_once $_SERVER["DOCUMENT_ROOT"] . "guiastur/Application/Exceptions/NotFoundEntryException.php";

class CreateTurnoUseCase implements ICreateTurnoUseCase
{

    private $getTurnosByAtencionQuery;
    private $createTurnoCommand;

    public function __construct(IGetTurnosByAtencionQuery $getTurnosByAtencionQuery, ICreateTurnoCommand $createTurnoCommand)
    {
        $this->getTurnosByAtencionQuery = $getTurnosByAtencionQuery;
        $this->createTurnoCommand = $createTurnoCommand;
    }
    public function CreateTurno(CreateTurnoRequest $request): CreateTurnoResponse
    {
        // 1. Tomar el codigo de la Atencion desde el requeste
        $atencionId = $request->getAtencionId();
        // 2. Obener los Turnos de esa Atencion
        $getTurnosByAtencionRequest = new GetTurnosByAtencionRequest($atencionId);
        try {
            // 3. Obtener el total de turnos de la lista de turnos de la atencion
            $getTurnosByAtencionResponse = $this->getTurnosByAtencionQuery->handler($getTurnosByAtencionRequest);
            $totalTurnos = $getTurnosByAtencionResponse->getTotalTurnos();
            // 4. Contar el total de Turnos y validar que aun existan turnos disponibles
            $turnos = $getTurnosByAtencionResponse->getTurnos();
            $turnosCount = count($turnos);
            if ($turnosCount >= $totalTurnos) {
                $message = "No existen turnos disponibles para la Atencion $atencionId";
                throw new NumberTurnosExceededException($message, 508);
            }
            // 5. Obtener la cedula del Guia desde el Request
            $cedula = $request->getGuiaId();
            // 6. Verificar si el guia ya tiene un turno creado para esa Atencion
            foreach ($turnos as $turno) {
                if ($turno->getGuiaId() == $cedula) {
                    $message = "El guia Id: $cedula tiene un turno previamente programado para la Atencion $atencionId";
                    throw new DuplicateEntryException($message);
                }
            }
            // 7. Obtener el turno siguiente
            $lastTurno = $turnos[count($turnos) - 1];
            $nextTunrnoNumero = $lastTurno->getNumero() + 1;
            // 8. Asignar el numero del turno al Request
            $request->setNumero($nextTunrnoNumero);
        } catch (DuplicateEntryException $e) {
            throw $e;
        
        } catch (NumberTurnosExceededException $e) {
            throw $e;
        }
        catch (NotFoundEntryException $e) {
            $nextTunrnoNumero = 1;
            $request->setNumero($nextTunrnoNumero);
        }
        catch (Exception $e) {
            throw $e;
        }
        // 9. usar el CreateTurnoCommand para guardar el Turno
        return $this->createTurnoCommand->handler($request);
    }

}

