<?php

namespace Tir\Crud\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Tir\Crud\Support\Requests\CrudRequest;

trait StoreTrait
{
    public function store(CrudRequest $request): \Illuminate\Http\JsonResponse
    {
        $item = $this->storeTransaction($request);
        return $this->storeResponse($item);
    }

    final function storeTransaction($request){
        return DB::transaction(function () use ($request) { // Start the transaction
            $item = $this->storeCrud($request);
            DB::commit();
            return $item;
        });
    }

    /**
     * This function store crud and relations
     */
    final function storeCrud($request)
    {
            // Store model
        if( !$this->model()->getFillable()){
            $fields = collect($this->model()->getAllDataFields())
                ->pluck('request')->flatten()->unique()->toArray();
            $this->model()->fillable($fields);
        }

//        $this->model()->fill($request->all());
            $item = $this->model()->create($request->all());
            //Store relations
            $this->storeRelations($request);

            return $item;

    }



    final function storeResponse($item): \Illuminate\Http\JsonResponse
    {
        $moduleName = $this->model()->getModuleName();
        $message = trans('core::message.item-created', ['item' => trans("message.item.$moduleName")]); //translate message

        return Response::Json(
            [
                'id'      => $item->id,
                'created' => true,
                'message' => $message,
            ]
            , 200);

    }

    final function storeRelations(Request $request): void
    {
        foreach ($this->model()->getAllDataFields() as $field) {
            if (isset($field->relation) && $field->multiple) {
                $data = $request->input($field->name);
                if(isset($data)){
                    $this->model()->{$field->relation->name}()->sync($data);
                }
            }
        }
    }

}
