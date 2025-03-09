<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TeacherClassRepository;

class TeacherClassController extends Controller
{
    protected $repository;
    public function __construct(TeacherClassRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
   
}
