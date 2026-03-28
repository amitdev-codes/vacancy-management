@extends('crudbooster::admin_template')
 @section('content')
<div class='panel panel-default'>
    <div class='panel-heading'>
        <h3>Total Applications</h3>
    </div>

    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>Ad. No.</th>
                        <th>Post</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tfoot>
                    @foreach ($total as $row)
                    <tr>
                        <td><strong>Total</strong></td>
                        <td></td>
                        <td><strong>{{$row->tot}}</strong></td>
                    </tr>
                    @endforeach
                </tfoot>
                @foreach ($results as $row)
                <tbody>
                    <tr>
                        <td>{{$row->ad_no}}</td>
                        <td>{{$row->post}}</td>
                        <td>{{$row->cnt}}</td>
                    </tr>
                </tbody>
                @endforeach
            </table>
        </div>
    </div>
</div>


@endsection