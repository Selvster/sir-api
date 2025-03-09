<?php

namespace App\Repositories;

use App\Models\TeacherClassRequests;


class TeacherClassRequestsRepository extends AppRepository
{
    public function __construct(TeacherClassRequests $model)
    {
        parent::__construct($model);
    }

}
