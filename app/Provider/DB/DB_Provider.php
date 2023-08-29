<?php

namespace App\Provider\DB;

use 
    Psr\Container\ContainerInterface,

    Illuminate\Database\Capsule\Manager;

// SERVICE FACTORY FOR THE DATABASE (ORM MYSQL ELOQUENT | JSON | TXT).

class DB_Provider {

    protected $ciContainer;

    public function __construct (ContainerInterface $ciContainer) { 

        $this -> ciContainer = $ciContainer; 

    }

    public function setDB () {

        $aConfig = $this -> ciContainer -> get('config');

        $mManager = new Manager;

        if ($aConfig['db']['driver'] != 'mysql') return $aConfig['db'][$aConfig['db']['driver']];

        $mManager -> addConnection($aConfig['db'][$aConfig['db']['driver']]);

        $mManager -> setAsGlobal();
        $mManager -> bootEloquent();

        return $mManager;

    }

}