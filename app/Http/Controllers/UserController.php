<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\UserRepository;

class UserController extends Controller
{
    protected $repository;
    public function __construct(UserRepository $repository)
    {
        parent::__construct($repository);
        $this->repository = $repository;
    }

    public function login(Request $request)
    {
        return $this->repository->login($request);
    }

    public function register(Request $request)
    {
        return $this->repository->register($request);
    }
   
}
