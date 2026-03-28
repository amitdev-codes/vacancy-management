<?php
$label_width = @$form['label_width']?:"col-sm-2";
$col_width = $col_width?: "col-sm-10";

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

@if($value)
<div class='upload form-group {{$cmp_class}} {{$header_group_class}} {{ ($errors->first($name))?"has-error":"" }}' id='form-group-{{$name}}' style="{{@$form['style']}};margin-bottom:184px">
@else
<div class='upload form-group {{$cmp_class}} {{$header_group_class}} {{ ($errors->first($name))?"has-error":"" }}' id='form-group-{{$name}}' style="{{@$form['style']}}">

@endif
			<label class='{{$label_width}}'>{{$form['label']}} {!!($required)?"<span class='text-danger' title='This field is required'>*</span>":"" !!}</label>

			<div class="{{$col_width}}">
			@if($value)
				<?php
					if(Storage::exists($value)):
						$url         = asset($value);
						$ext 		 = pathinfo($url, PATHINFO_EXTENSION);
						$images_type = array('jpg','png','gif','jpeg','bmp','tiff');
						if(in_array(strtolower($ext), $images_type)):
						?>
							<p><a data-lightbox='roadtrip' href='{{$url}}'><img style='max-width:160px' title="Image For {{$form['label']}}" src='{{$url}}'/></a></p>
						<?php else:?>
							<p><a href='{{$url}}'>{{trans("crudbooster.button_download_file")}}</a></p>
						<?php endif;
							echo "<input type='hidden' name='_$name' value='$value'/>";
					else:
						echo "<p class='text-danger'><i class='fa fa-exclamation-triangle'></i> ".trans("crudbooster.file_broken")."</p>";
					endif;
				?>
				<!-- // hide Delete button for non-applicants -->
				@if(CRUDBooster::myPrivilegeId()==4 || CRUDBooster::myPrivilegeId()==5) 
					@if(!$readonly || !$disabled)
					<p><a class='btn btn-danger btn-delete btn-sm' onclick="if(!confirm('{{trans("crudbooster.delete_title_confirm")}}')) return false" href='{{url(CRUDBooster::mainpath("delete-image?image=".$value."&id=".$row->id."&column=".$name))}}'><i class='fa fa-ban'></i> {{trans('crudbooster.text_delete')}} </a></p>
					@endif
				@endif

			@endif
			@if(!$value)
			<input type='file' id="{{$name}}" title="{{$form['label']}}" class="form-control fileupload" {{$required}} {{$readonly}} {{$disabled}} name="{{$name}}"/>
			<p class='help-block'>{{ @$form['help'] }}</p>
			@else
			<p class='text-muted'><em>{{trans("crudbooster.notice_delete_file_upload")}}</em></p>
			@endif
			<div class="text-danger">{!! $errors->first($name)?"<i class='fa fa-info-circle'></i> ".$errors->first($name):"" !!}</div>

			</div>

		</div>
