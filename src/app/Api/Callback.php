<?php

namespace App\Api;

use PhalApi\Api;



class Callback extends Api
{
    public function getRules(): array
    {
        return array(
            'code' => array(
                'code' => array('name' => 'code', 'default' => '', 'desc' => 'code'),
                'state' => array('name' => 'state', 'default' => 'STATE', 'desc' => 'state'),
            ),
        );
    }

    public function code(): array
    {
        $code = $this->code;
        $state = $this->state;

        return [
            'c' => $code,
            's' => $state
        ];

    }
}
