<?php
$label_width = @$form['label_width']?:"col-sm-2";
$col_width = $col_width?: "col-sm-10";
$nepaliDatePicker = @$form['class']?:"";
$cmp_ratio = @$form['cmp-ratio'];
$cmp_class = @$form['cmp-class'];
if(strlen($cmp_ratio) >= 1){
    $arr = explode(":", $cmp_ratio);
    if(count($arr) == 2){
        $label_width = "col-sm-".$arr[0];
        $col_width = "col-sm-".$arr[1];
    }
    if(count($arr) == 3){
        $cmp_class = "col-sm-".$arr[0];
        $label_width = "col-sm-".$arr[1];
        $col_width = "col-sm-".$arr[2];
    }
    
}
?>
<div class='{{$cmp_class}} form-group {{$header_group_class}} {{ ($errors->first($name))?"has-error":"" }}' id='form-group-{{$name}}'
style="{{@$form['style']}}">
    <label class='{{$label_width}}'>{{$form['label']}} {!!($required)?"<span class='text-danger' title='This field is required'>*</span>":"" !!}</label>
    <div class="{{$col_width}}">
        <input type='text' title="{{$form['label']}}" class="{{$col_width}}" style="height:25px"
                {{$required}} {{$readonly}} {!!$placeholder!!} {{$disabled}} {{$validation['max']?"maxlength=$validation[max]":""}} class='form-control'
                name="{{$name}}" id="{{$name}}" value='{{$value}}'/>

        <div class="text-danger">
            {!! $errors->first($name)?"<i class='fa fa-info-circle'></i> ".$errors->first($name):"" !!}
        </div>
        <p class='help-block'>{{ @$form['help'] }}</p>

    </div>
</div>