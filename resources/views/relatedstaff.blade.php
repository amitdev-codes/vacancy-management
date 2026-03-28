 @extends('welcome')
 
 @section('content')
 <ol class="breadcrumb">
          <li>NTC STAFF</li>
        </ol>

@foreach($related_staffs as $staff )
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 col-xs-offset-0 col-sm-offset-0  toppad" >
          <div class="panel panel-info">
            <div class="panel-heading">
              <h3 class="panel-title">{{$staff->full_name}}</h3>
            </div>
            <div class="panel-body">
              <div class="row">
                <div class="col-md-3 col-lg-3 " align="center"> <img class="user_img" alt="User Pic" src="{{$staff->photo}}"> </div>
               <div class=" col-md-9 col-lg-9 "> 
                  <table class="table table-user-information">
                    <tbody>
                      <tr>
                        <td>Post</td>
                        <td>{{$staff->post}}</td>
                      </tr>
                      <tr>
                        <td>Email</td>
                        <td><a href="mailto:{{$staff->email}}" style="color: black;">{{$staff->email}}</a></td>
                      </tr>
                        <td>Mobile Number</td>
                        <td>{{$staff->mobile}}<br><br>
                      </tr>                     
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        </div>
    @endforeach
@endsection


      
