<?php

abstract class TurnoStatusEnum {
    const CREATED = "Creado";
    const INUSE = "En uso";
    const RELEASE = "Liberado";
    const FINALIZED = "Finalizado";
    const CANCELLED = "Cancelado";

    public static function getConstansValues(): array
    {
        $reflect = new ReflectionClass(__CLASS__);
        $constProperties = $reflect->getConstants();
        $values = array();
        foreach ($constProperties as $constantName => $value) {
            $values[] = $value;
        }
        return $values;
    }
}