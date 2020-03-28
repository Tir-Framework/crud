@php
    //set #id for jquery confilict
    $id = preg_replace("/[^a-zA-Z_]/", "", $field->name);
    $fieldName = $field->name;
    $options = ['id'=> "select-$id", 'class'=>'dropdown-toggle form-control'];
    if(isset($field->multiple)):
        if( $field->multiple == true):
            $options['multiple'] = 'multiple';
            $fieldName = $field->name.'[]';
        endif;
    else:
        $options ['placeholder'] = trans('$crud->name::panel.select').' '.trans("$crud->name::panel.$field->display");
    endif;


    $model = $field->data[0];
    $key = $field->data[1];
    $values = $model::pluck($key,'id');

    $model::$routeName;
@endphp

<div class="{{$field->col ?? 'col-12 col-md-6'}}">
    <div class="form-group">
        {!! Form::label($fieldName,trans("$crud->name::panel.$field->display"), ['class' => 'control-label']) !!}
        {!! Form::select($fieldName, $values, null,$options)!!}
    </div>
</div>

@push('scripts')
    <script>
    $("#select-{{$id}}").select2({
        placeholder: "{{trans('crud::panel.select').' '.trans("$crud->name::panel.$field->display")}}",
        ajax: {
            url: "/admin/{{$model::$routeName}}/select/?key={{$key}}",
            dataType: 'json',
            data: function (params) {
                var query = {
                    search: params.term,
                    page: params.page || 0
                }
                return query;
            }
        }
    });
</script>
@endpush
