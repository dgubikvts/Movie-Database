<?php

abstract class MVDB_Abstract_Import_Mapper
{
    protected array $fields;

    public function to(array $data): array
    {
        foreach($this->fields as $key => $value){
            if(!isset($data[$key])) continue;
            $mapped[$value] = $this->prepareAttribute($key, $data[$key]);
        }

        return $mapped ?? [];
    }

    protected function prepareAttribute(string $key, mixed $value)
    {
        $key = str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
        $method = "prepare{$key}Attribute";
        if(method_exists($this, $method)) return $this->$method($value);
        return $value;
    }
}