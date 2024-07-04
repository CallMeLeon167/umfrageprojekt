<?php

namespace CML\DataStructure;

/**
 * Class Entity
 *
 * This abstract class offers functions to manage the value assignment for the DB pattern 
 */
abstract class Entity 
{
    /**
     * get the required fields for the db.
     *
     * This method is implented in the extending classes.
     *
     * @return array The required fields of the regarding object.
     */
    protected abstract function getRequiredFields(): array;
    /**
     * get the field mapping for the assignment.
     *
     * This method is implented in the extending classes.
     *
     * @return array The required fields of the regarding object.
     */
    protected abstract function getFieldMappings(): array;
    /**
     * get the assigned object with values useing getFieldMappings().
     *
     * @param array the values to assign
     * @return ?self The required fields of the regarding object.
     */
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
    /**
     * checks array for completeness with getRequiredFields.
     *
     * @param array the existing fields 
     * @return bool
     */
    private function validateFields(array $row): bool {
        foreach ($this->getRequiredFields() as $field) {
            if (!array_key_exists($field, $row)) {
                return false;
            }
        }
        return true;
    }
}