<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ClassRequestsRepository;

class ClassRequestsController extends Controller
{
    protected $repository;
    public function __construct(ClassRequestsRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function accept($id){
        return $this->repository->accept($id);
    }

    public function reject($id){
        return $this->repository->reject($id);
    }
   
}
