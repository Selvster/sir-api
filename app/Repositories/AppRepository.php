<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AppRepository
{

    protected $model;
    public function __construct(Model $model)
    {
        $this->model = $model;
    }


    public function paginate(Request $request)
    {
        return $this->model->paginate($request->input('limit', 5));
    }

    public function all(Request $request)
    {
        $with = $request->with ? $request->with : [];
        $query = $this->model->with($with);
        return $this->dataTable($query, $request);
    }
    public function store(Request $request)
    {

        $data = $request->all();
        $item = $this->model;
        $item->fill($data);
        $item->save();
        return ['item' => $item , 'status' => 'success'];
    }

    public function update($id, Request $request)
    {
        $data = $request->all();
        $item = $this->model->findOrFail($id);
        $item->fill($data);
        $item->save();
        return $item;
    }




    public function show($id, $with = [])
    {
        return $this->model->with($with)->findOrFail($id);
    }


    public function getApi(Request $request, $with = [], $withCount = [])
    {
        $query = $this->model->with($with)->withCount($withCount);
        return $this->dataTable($query, $request);
    }

    private function applyCondition($query, $field, $value)
    {
        if (array_keys($value)[0] == 'from' || array_keys($value)[0] == 'to') {
            foreach ($value as $key => $val) {
                $query->where($field, $val[0], $val[1]);
            }
        } else {
            if ($value[1] == 'NULL') {
                $query->where($field, $value[0], null);
            } else {
                $query->where($field, $value[0], $value[1]);
            }
        }
    }

    private function applyCountCondition($query, $value, $relation)
    {
        $query->withCount($relation);
        foreach ($value as $key => $val) {
            $query->havingRaw($relation . '_count ' . $val[0] . ' ? ', [$val[1]]);
        }
    }
    public function dataTable($query, $request, $columns = [])
    {

        if ($request->filter) {
            if (str_contains($request->filter, "&&")) {
                $filterArr = explode("&&", $request->filter);
                foreach ($filterArr as $key => $value) {
                    $filter = explode("|", $value);
                    if (count($filter) == 3) {

                        $query->where($filter[0], $filter[2], $filter[1]);
                    } else
                        $query->where($filter[0], $filter[1]);
                }
            } else {
                $filter = explode("|", $request->filter);
                if (count($filter) == 3) {

                    $query->where($filter[0], $filter[2], $filter[1]);
                } else
                    $query->where($filter[0], $filter[1]);
            }
        }
        if ($request->count) return  $query->count();
        if (!$request->per_page) return  $query->get();

        $sort = explode("|", $request->sort);

        if ($request->sort) {
            if ($sort[0] == 'id') {
                $query =  $query->orderBy("id", "desc");
            }
            $query = $query->orderBy($sort[0], $sort[1]);
        } else {
            $query->orderBy("id", "desc");
        }
        $perPage = $request->per_page;

        $page = ($request->page - 1) * $request->per_page;
        return $query->skip($page)->paginate($perPage);
    }

    public function destroy($id)
    {
        return  $this->model->destroy($id);
    }
    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }
    public function find($id, $with = [])
    {
        return $this->model->with($with)->find($id);
    }
}
