<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\QuizRepository;

class QuizController extends Controller
{
    protected $repository;
    public function __construct(QuizRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function attempt($id){
        return $this->repository->attempt($id);
    }
   
}
