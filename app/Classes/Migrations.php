<?php

namespace App\Classes;

use Dotenv\Dotenv;
use Illuminate\Database\Capsule\Manager;
use Phinx\Migration\AbstractMigration;

class Migrations extends AbstractMigration
{
    /** @var \Illuminate\Database\Capsule\Manager $capsule */
    public $capsule;
    /** @var \Illuminate\Database\Schema\Builder $capsule */
    public $schema;

    public function init()
    {
        $env = new Dotenv(dirname(dirname(__DIR__)));
        $env->load();

        $capsule = new Manager(app());
        $capsule->addConnection([]);

        $this->capsule->bootEloquent();
        $this->capsule->setAsGlobal();
        $this->schema = $this->capsule->schema();
    }
}