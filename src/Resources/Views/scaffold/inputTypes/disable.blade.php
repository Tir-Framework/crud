<div class="form-group">
    {!! Form::label($field->name, trans("$crud->name::panel.$field->display"), ['class' => 'col-md-2 control-label']) !!}
    <div class="col-md-10">
        {!! Form::text($field->name,null,['class' => 'form-control','disabled'])!!}
    </div>
</div>