<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ApiStorePersonRequest;
use App\Http\Resources\V1\PersonResource;
use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonController extends Controller
{
    public $model = Person::class;
    public $resource = PersonResource::class;
    public $storeValidation = ApiStorePersonRequest::class;
    public $updateValidation = ApiStorePersonRequest::class;
    public $paginationPerPage = 10;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $query = $this->model::paginate($this->paginationPerPage);
        $data = $this->resource::collection($query);

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApiStorePersonRequest $request)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $data = new $this->model;
            $data->name = $validated["name"];
            $data->dob = $validated["dob"];
            $data->address = $validated["address"];
            $data->created_by = 1;
            $data->updated_by = 1;
            $data->save();

            DB::commit();
            return new $this->resource($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = $this->model::findOrFail($id);
        return new $this->resource($data);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApiStorePersonRequest $request, string $id)
    {
        try {
            DB::beginTransaction();

            $validated = $request->validated();
            $data = $this->model::findOrFail($id);
            $data->name = $validated["name"];
            $data->dob = $validated["dob"];
            $data->address = $validated["address"];
            $data->created_by = 1;
            $data->updated_by = 1;
            $data->save();

            DB::commit();
            return new $this->resource($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();

            $data = $this->model::findOrFail($id);
            $data->delete();

            DB::commit();
            return new $this->resource($data);
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
