<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

trait HasCrudRepository
{
    public function showAny($params)
    {
        try {
            $includes   = $params['includes'] ?? [];
            $filters    = $params['filters'] ?? [];
            $model      = $this->model->with($includes)->where($filters);
            return (JsonResource::collection($model->paginate()))
                ->additional([
                    'status' => 'success',
                    'message' => 'Data Collections'
                ]);
        } catch (\Throwable $th) {
            return $this->error($th);
        }
    }

    public function create(Request $request)
    {
        try {
            $row = $this->model->create($request->all());
            return (new JsonResource($row))
                ->additional([
                    'status' => 'success',
                    'message' => 'Data has been created'
                ]);
        } catch (\Throwable $th) {
            return $this->error($th);
        }
    }

    public function show($params, Model $row)
    {
        try {
            $includes   = $params['includes'] ?? [];
            $filters    = $params['filters'] ?? [];

            $row = $row->query();
            if (!empty($includes)) {
                $row->with($includes);
            }

            foreach ($filters as $relation => $columns) {
                foreach ($columns as $key => $value) {
                    $row->whereRelation($relation, $key, '=', $value);
                }
            }
            $row = $row->first();
            return (new JsonResource($row))
                ->additional([
                    'status' => 'success',
                    'message' => 'Data founded.'
                ]);
        } catch (\Throwable $th) {
            return $this->error($th);
        }
    }

    public function update(Request $request, Model $row)
    {
        try {
            $row->update($request->all());
            return (new JsonResource($row))
                ->additional([
                    'status' => 'success',
                    'message' => 'Data has been updated'
                ]);
        } catch (\Throwable $th) {
            return $this->error($th);
        }
    }

    public function delete(Model $row)
    {
        try {
            $row->delete();
            return (new JsonResource([]))
                ->additional([
                    'status' => 'success',
                    'message' => 'Data has been deleted'
                ]);;
        } catch (\Throwable $th) {
            return $this->error($th);
        }
    }

    private function error(\Throwable $th)
    {
        return (new JsonResource([]))
            ->additional([
                'status' => 'failed',
                'message' => $th->getMessage()
            ])
            ->response()
            ->setStatusCode(500);
    }
}
