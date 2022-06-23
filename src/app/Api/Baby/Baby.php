<?php

namespace App\Api\Baby;

use App\Api\Controller;

class Baby extends Controller
{
    private $beginDate = '2022-02-22';
    // 返回多少周
    public function getWeek(): array
    {
        $beginTimestamp = strtotime($this->beginDate);
        $beginWeek = date('W', $beginTimestamp);
        $endWeek = date('W');

        return [
            'duration' => (int)((time() - $beginTimestamp) / 86400),
            'time' => '2020-1-26 12:00:00',
            'week' => $endWeek - $beginWeek,
            'day' =>  date('N'),
        ];

    }
}