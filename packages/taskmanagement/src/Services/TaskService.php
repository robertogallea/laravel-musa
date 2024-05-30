<?php

namespace MusaFormazione\TaskManager\Services;

use MusaFormazione\TaskManager\Models\Task;

class TaskService
{
    public function next()
    {
        return Task::orderBy('created_at', 'asc')->first();
    }
}
