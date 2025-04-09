<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClassStudentsRepository;

class ClassStudentsController extends Controller
{
    protected $repository;
    public function __construct(ClassStudentsRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
   
}
