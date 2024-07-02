<?php

namespace CML\DataStructure;

abstract class Entity {

    protected abstract function getRequiredFields(): array;
    protected abstract function getFieldMappings(): array;


    public function hydrateFromDBRow(array $row): ?self {
        if (!$this->validateFields($row)) {
            return null;
        }
        foreach ($this->getFieldMappings() as $property => $dbField) {
            if (array_key_exists($dbField, $row)) {
                $this->$property = $row[$dbField];
            }
        }
        return $this;
    }

    private function validateFields(array $row): bool {
        foreach ($this->getRequiredFields() as $field) {
            if (!array_key_exists($field, $row)) {
                return false;
            }
        }
        return true;
    }
}