<?php

namespace Tir\Crud\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

trait IndexTrait
{

    public function index(): JsonResponse
    {
        $cols = [];
        $scaffold = $this->model()->getIndexScaffold();
        foreach ($scaffold['fields'] as $index => $field) {
            $cols[$index] = [
                'title'     => $field->display,
                'dataIndex' => $this->getDataIndex($field),
                'fieldName' => $field->name,
                'valueType' => $field->valueType,
                'comment'   => $field->comment,
                'dataSet' => $field->dataSet,
                'dataKey' => $field->relation->key ?? null,
                'dataField' => $field->relation->field ?? null,
                'relational' => isset($field->relation),
                'type'    => $field->type,
                'field' => $field,
            ];
            if($field->filterable){
                $cols[$index]['filters'] = $field->filter;
                $cols[$index]['filterType'] = $field->filterType;
            }
        }

        $data = [
            'actions'    => $this->model()->getActions(),
            'configs'    => $scaffold['configs'],
            'cols'       => $cols,
            'dataRoute'  => route('admin.' . $this->model()->getmoduleName() . '.data'),
            'trashRoute' => route('admin.' . $this->model()->getmoduleName() . '.trashData'),
        ];

        return Response::json($data, '200');
    }

    private function getDataIndex($field)
    {
        if(isset($field->relation) && $field->multiple){
            return $field->relation->name;
        }else{
            return $field->name;
        }
    }
}
