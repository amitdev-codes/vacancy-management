@push('bottom')
<script type="text/javascript">
								$(document).ready(function() {
								  $('#textarea_{{$name}}').summernote({
								  	height: ($(window).height() - 300),
								    callbacks: {
								        onImageUpload: function(image) {
								            uploadImage{{$name}}(image[0]);
								        }
								    }
								  });
								  function uploadImage{{$name}}(image) {
									    var data = new FormData();
									    data.append("userfile", image);
									    $.ajax({
									        url: '{{CRUDBooster::mainpath("upload-summernote")}}',
									        cache: false,
									        contentType: false,
									        processData: false,
									        data: data,
									        type: "post",
									        success: function(url) {
									            var image = $('<img>').attr('src',url);
									            $('#textarea_{{$name}}').summernote("insertNode", image[0]);
									        },
									        error: function(data) {
									            console.log(data);
									        }
									    });
									}
								})
							</script>
							@endpush



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
							<div class='form-group {{$cmp_class}}' id='form-group-{{$name}}' style="{{@$form['style']}}">
								<label class='{{$label_width}}'>{{$form['label']}}</label>

								<div class="{{$col_width}}">
									<textarea id='textarea_{{$name}}' id="{{$name}}" {{$required}} {{$readonly}} {{$disabled}} name="{{$form['name']}}" class='form-control' rows='5'>{{ $value }}</textarea>
									<div class="text-danger">{{ $errors->first($name) }}</div>
									<p class='help-block'>{{ @$form['help'] }}</p>
								</div>
						</div>
