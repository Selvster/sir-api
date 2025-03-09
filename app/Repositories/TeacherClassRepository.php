<?php

namespace App\Repositories;

use App\Models\TeacherClass;


class TeacherClassRepository extends AppRepository
{
    public function __construct(TeacherClass $model)
    {
        parent::__construct($model);
    }

}
