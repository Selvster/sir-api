<?php

namespace App\Repositories;

use App\Models\TeacherClassStudents;


class TeacherClassStudentsRepository extends AppRepository
{
    public function __construct(TeacherClassStudents $model)
    {
        parent::__construct($model);
    }

}
