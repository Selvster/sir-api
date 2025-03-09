<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\TeacherClassRequestsRepository;

class TeacherClassRequestsController extends Controller
{
    protected $repository;
    public function __construct(TeacherClassRequestsRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }
   
}
