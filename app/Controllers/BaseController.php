<?php

namespace App\Controllers;

class BaseController
{
    protected static $db;

    function __construct()
    {
        $this->db = new \GuzzleHttp\Client([
            'base_uri' => server()->ip_address.':3000'
        ]);
    }
}