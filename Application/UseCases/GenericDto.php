<?php
class GenericDto
{
    public function toJSON() : string
    {
        return json_encode($this->getProperties(), JSON_UNESCAPED_UNICODE);
    }

    protected function getProperties(): array {
        $reflection = new ReflectionObject($this);
        $properties = [];
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $getter = 'get' . ucfirst($property->getName());
            if (method_exists($this, $getter)) {
                $value = $this->$getter();
                if (is_array($value)) {
                    // Si el valor es un array, también lo convertimos a JSON
                    $properties[$property->getName()] = array_map(function($item) {
                        return is_object($item) ? $item->toJSON() : $item;
                    }, $value);
                } else if ($value instanceof DateTime) {
                    // Convertir DateTime a formato de cadena
                    $properties[$property->getName()] = $value->format("Y-m-d H:i:s");
                } else {
                    $properties[$property->getName()] = $value;
                }
            } else {
                // Si no hay getter, obtener el valor directamente
                $properties[$property->getName()] = $property->getValue($this);
            }
        }
        return $properties;
    }
    

    protected function processArray(array $array) : array
    {
        $result = [];
        foreach ($array as $item) {
            if (is_object($item) && method_exists($item, 'toJSON')) {
                $result[] = json_decode($item->toJSON(), true);
            } else {
                $result[] = $item;
            }
        }
        return $result;
    }
}



