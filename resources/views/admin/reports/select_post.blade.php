@extends('crudbooster::admin_template')
@section('content')
    @if ($message)
        <div class="alert alert-success">
            {{ $message }}
        </div>
    @endif

    <div class="panel panel-primary">
        <div class="panel-heading">Select Vacancy post</div>
        <div class="panel-body">
            <div class="container-fluid">
                <form role="form" method="post" action="{{route('post_bulk_applied_file_promotion_report')}}">
                    @csrf
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="vacancy_post">Vacancy Post</label>
                            <select class="form-control" id="vacancy_post_id" name="vacancy_post_id">
                                <option value="">Select Vacancy Post</option>
                                @foreach($vacancy_posts as $post)
                                    <option value="{{ $post->id }}">{{ $post->designation_en }}
                                        -{{ $post->designation }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="panel-footer">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection