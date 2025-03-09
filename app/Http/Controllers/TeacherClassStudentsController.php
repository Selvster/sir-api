<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TeacherClassStudentsRepository;

class TeacherClassStudentsController extends Controller
{
    protected $repository;
    public function __construct(TeacherClassStudentsRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
   
}
