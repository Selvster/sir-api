<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $repository;
    private $resource;
    public function __construct($repository)

    {
        $this->repository = $repository;
    }

    public function store(Request $request)
    {
     
        return $this->repository->store($request);
    }
    public function index(Request $request)
    {
        return $this->repository->all($request);
    }
    public function show($id)
    {
        $with = [];
        if (request()->with) $with = request()->with;
        $item = $this->repository->show($id, $with);
        return $item;
    }
    public function destroy($id){
        if($this->repository->destroy($id)){
            return response()->json([
                'status' => 'success'
            ]);
        }
    }
    public function update($id, Request $request)
    {
        return $this->repository->update($id, $request);
    }
}
