<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClassRepository;

class ClassController extends Controller
{
    protected $repository;
    public function __construct(ClassRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function removeStudent($id, $student_id){
        return $this->repository->removeStudent($id, $student_id);
    }

    public function getQuizzes($id){
        return $this->repository->getQuizzes($id);
    }
   
}
