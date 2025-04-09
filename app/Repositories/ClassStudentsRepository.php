<?php

namespace App\Repositories;

use App\Models\ClassStudents;


class ClassStudentsRepository extends AppRepository
{
    public function __construct(ClassStudents $model)
    {
        parent::__construct($model);
    }

}
