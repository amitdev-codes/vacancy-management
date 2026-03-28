
 $(document).ready(function(){
    $('#getEmail').click(function () {
    var mob = document.getElementById('mob').value;
    if (mob) {
        $.ajax({
            url: '/user/checkmobile',
            type: 'GET',
            data: {
                '_token': '{{ csrf_token() }}',
                'mobile': mob,
            },
            dataType: 'json',
            success: function (data) {
                console.log(data);
                if(!!data['status']){
                    if(data['status']==true){
                        swal({
                            title: "Sorry!",
                            text: data['message'],
                            icon: "info"
                        }).then(() => location.reload());
                        return false; 
                    }
                }
                else {
                    return true;
                }

            }
        });
    } else {
        $('#getEmail').empty();
    }

    })

  $('#psw').click(function () {
      var email = document.getElementById('getEmail').value;
      if (email) {
          $.ajax({
              url: '/user/checkemail',
              type: 'GET',
              data: {
                  '_token': '{{ csrf_token() }}',
                  'email': email,
              },
              dataType: 'json',
              success: function (data) {
                  console.log(data);
                  if(!!data['status']){
                      if(data['status']==true){
                          swal({
                              title: "Sorry!",
                              text: data['message'],
                              icon: "info"
                          }).then(() => location.reload());
                          return false; 
                      }
  
                  }
                  else {
                      return true;
                  }
  
              }
          });
      } 
  
  })

});