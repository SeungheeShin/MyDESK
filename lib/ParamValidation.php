<?php
class ParamValidation 
{
    public function stringCheck($num) 
    {
        $strlen = strlen($num);
        $isString = is_string($num);
        
        if (($strlen == 0) || ($isString === false)) {
            $message = "잘못된 문자열";
            return $message;
        } else {
            return true;
        }
    }
    
    public function emailCheck($email) 
    {
        $strlen = strlen($email);
        $isString = is_string($email);
        $filterVar = filter_var($email, FILTER_VALIDATE_EMAIL);
        
        if (($strlen == 0) || ($isString === false) || ($filterVar === false)) {
            $message = "잘못된 이메일 형식";
            return $message;
        } else {
            return true;
        }
    }
}
?>