<?php

namespace Tir\Crud\Support\Scaffold;

use Tir\Crud\Support\Scaffold\Fields\Button;

trait FieldsHelper
{

    private array $indexFields = [];
    private array $editFields = [];

    final function getFields(): array
    {
        $this->scaffold();

        return $this->fields;

    }


    final function getAllDataFields()
    {
        $fields = $this->getFields();
        $allFields = $this->getAllChildren($fields);
        return collect($allFields)->where('fillable', true)->values()->toArray();
    }

    final function getIndexFields(): array
    {
        $allFields = $this->getAllChildren($this->getFields());
        return collect($allFields)->where('showOnIndex')->values()->toArray();
    }

    final function getEditFields(): array
    {
        $fields = $this->getFields();
        return $this->getChildren($fields, 'showOnEditing');
    }

    final function getDetailFields(): array
    {
        $fields = $this->getFields();
        return $this->getChildren($fields, 'showOnDetail');
    }

    final function getCreateFields(): array
    {
        $fields = $this->getFields();
        return $this->getChildren($fields, 'showOnCreating');
    }

    final function getFieldByName($name)
    {
        foreach ($this->getAllDataFields() as $field) {
            if ($field->name == $name) {
                return $field;
            }
        }
    }

    final function getSearchableFields(): array
    {
        $fields = [];
        foreach ($this->getIndexFields() as $field) {
            if ($field->searchable) {
                $fields[] = $field;
            }
        }
        return $fields;
    }

    private function getSubFields($fields, $allFields)
    {
        foreach ($fields as $field) {
            if (isset($field->children) && !$field->fillable) {
                $allFields = $this->getSubFields($field->subFields, $allFields);
            } elseif ($field->fillable) {
                $allFields[] = $field;
            }
        }
        return $allFields;
    }


    private function getChildren($fields, $page): array
    {
        $allFields = [];
        foreach ($fields as $field) {
            if ($field->{$page}) {
                if (isset($field->children) && $field->type != 'Additional') {
                    $field->children = collect($field->children)->where($page, true)->values()->toArray();
                    $field->children = $this->getChildren($field->children, $page);
                }
                $allFields[] = $field;
            }
        }

        return $allFields;
    }

    private function getAllChildren($fields): array
    {
        $allFields = [];
        foreach ($fields as $field) {
            if (isset($field->children) && $field->type != 'Additional') {
                $children = $field->children;
//                $field->children = [];
                $allFields[] = $field;
                $allFields = array_merge($allFields, $this->getAllChildren($children));
            } else {
                $allFields[] = $field;
            }
        }

        return $allFields;
    }

}
