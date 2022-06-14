<?php

namespace App\Api;

use App\Api\Examples\Log;
use PhalApi\Api;



class Callback extends Api
{
    public function getRules(): array
    {
        return array(
            'code' => array(
                'code' => array('name' => 'code', 'default' => '', 'desc' => 'code'),
                'state' => array('name' => 'state', 'default' => 'STATE', 'desc' => 'state'),
                'echostr' => array('name' => 'echostr', 'default' => '', 'desc' => 'echostr'),
            ),
        );
    }

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
