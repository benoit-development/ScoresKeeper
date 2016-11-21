<?php

namespace App\Validators;

/**
 * Validator checking if an array only has numeric values
 * 
 * @see is_numeric
 * 
 * @author Benoit BOUSQUET
 *
 */
class NumericArray {
    
    /**
     * Validation of the value
     * 
     * @param unknown $attribute
     * @param unknown $values
     * @param unknown $parameters
     * @return boolean
     */
    public function validate($attribute, $values, $parameters)
    {
        if(! is_array($values)) {
            return false;
        }
    
        foreach($values as $v) {
            if(! is_numeric($v)) {
                return false;
            }
        }
    
        return true;
    }
    
}