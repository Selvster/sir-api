<?php

namespace App\Repositories;

use App\Models\Result;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResultRepository extends AppRepository
{
    public function __construct(Result $model)
    {
        parent::__construct($model);
    }

    public function all(Request $request)
    {
        $with = $request->with ? $request->with : [];

        $query = $this->model->with($with)
            ->whereHas('student', function ($q) {
                $q->where('id', auth()->user()->student->id);
            });


        return $this->dataTable($query, $request);
    }


}
