<?php

namespace MusaFormazione\TaskManager\Facades;

use Illuminate\Support\Facades\Facade;

class TaskManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'task-manager';
    }

}
