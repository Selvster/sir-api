<?php

namespace App\Http\Controllers;

use App\Repositories\ResultRepository;

class ResultController extends Controller
{
    protected $repository;
    public function __construct(ResultRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
   
}
