




<div class="{{$field->col ?? 'col-12 col-md-12'}}">
    <div class="form-group">
        {{ $slot }}

        <span class="invalid-feedback" role="alert">
            @error($field->name)
            <strong>{{ $message }}</strong>
            @enderror
        </span>
        <label for="{{$field->name}}"
               class="control-label text-right">

               @lang($item->getLocalization().$field->display)

            </label>
    </div>

</div>










{{-- 
@php
if( isset($item->{$field->name}) ){
    $item->{$field->name};
}
$id = $field->name;
$class = 'form-control';
// $options = ['class'=>$class , $field->validation ?? null, $field->option ?? null];
$options = ['class'=>$class , $field->option ?? null];

if(isset($field->placeholder)){
    $options['placeholder'] = $field->placeholder;
}

if($errors->has($field->name)){
    $options['class'] = $class. ' is-invalid';
}
@endphp --}}


{{-- 

<div class="{{$field->col ?? 'col-12 col-md-12'}}">
    <div class="form-group">
        {{ $slot }}

        <span class="invalid-feedback" role="alert">
                @error($field->name)
                <strong>{{ $message }}</strong>
                @enderror
            </span>
        <label for="{{$field->name}}"
               class="control-label text-right">@lang($model->getLocalization().$field->display)</label>
    </div>

</div> --}}