<?php

namespace App\Api;

use App\Api\Examples\Log;
use PhalApi\Api;



class Callback extends Api
{


    public function code()
    {
        $code = $this->code;
        $state = $this->state;
        $echostr = $this->echostr;
        logData($_GET);
        echo $echostr;
        exit();
    }
}
