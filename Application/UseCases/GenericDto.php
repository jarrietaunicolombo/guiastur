<?php
class GenericDto
{
    public function toJSON() : string
    {
        return json_encode($this->getProperties(), JSON_UNESCAPED_UNICODE);
    }

    protected function getProperties() : array
    {
        $reflection = new ReflectionObject($this);
        $properties = [];
        foreach ($reflection->getProperties() as $property) {
            $property->setAccessible(true);
            $getter = 'get' . ucfirst($property->getName());
            if (method_exists($this, $getter)) {
                $properties[$property->getName()] = $this->$getter();
            }
        }
        return $properties;
    }
}
