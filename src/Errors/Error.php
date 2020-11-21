<?php
namespace App\Errors;

class Error
{

    private $MsgError;

    public function getMessage()
    {
        return $this->MsgError;
    }

    public function setMessage($Msg)
    {
        $this->MsgError = $Msg;
    }

}

