@extends('crudbooster::admin_template')
@section('content')

<div class="panel panel-success nepali_td">
  <div class="panel-heading">भुकतनी विवरण </div>
  <div class="panel-body table-responsive">      
    <table class='table' id="tokentbl">
      <tbody>


        <tr>
          <td><label class=' pull-left'>
            <b>आर्थिक वर्ष: </b></label><span class='pull-left nepali_td'>&nbsp;{{Session::get('fiscal_year_code')}}</span>

            <a class="" style="float: right" href="{{route('receipt',['id'=>$data['txnid']])}}" target="_blank"  ><i class="fa fa-file-pdf-o" style="font-size:25px;color:red"></i> 
              </a>
          </td>
        </tr>

        <tr>
          <td><label class=' pull-left'>
            <b>पद: </b></label><span class='pull-left nepali_td'>&nbsp;{{$data['Designation']}}</span>
          </td>
        </tr>



        <tr>
          <td><label class=' pull-left'>
            <b>भुक्तानी गर्नुपर्ने रकम:</b></label><span class='pull-left nepali_td'>&nbsp;{{$data['amount']}}</span>
          </td>
        </tr>

        <tr>
          <td><label class=' pull-left'>
            <b>भुक्तानी गरेको रकम:</b></label><span class='pull-left nepali_td'>&nbsp;{{$data['amount']}}</span>
          </td>
        </tr>

        <tr>
          <td><label class=' pull-left'>
            <b>भुक्तानी गर्न बाँकी रकम:</b></label><span class='pull-left nepali_td'>&nbsp;0</span>
          </td>
        </tr>

        <tr>
          <td><label class=' pull-left'>
            <b>रसिद नं:</b></label><span class='pull-left nepali_td'>&nbsp;{{$data['receipt']}}</span>
          </td>
        </tr>

        <tr>
          <td><label class=' pull-left'>
            <b>भुक्तानी बिजक नं(Txn id): </b></label><span class='pull-left nepali_td'>&nbsp;{{$data['txnid']}}</span>
          </td>
        </tr>

      </tbody>
    </table>
  </div>
</div>
@endsection