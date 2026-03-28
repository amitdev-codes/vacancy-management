var publickey= document.getElementById("publickey").value;
var producturl=document.getElementById("producturl").value;
var product_name=document.getElementById("product_name").value;
var product_identity=document.getElementById("product_identity").value;
var config = {
  publicKey: publickey,
  productIdentity:product_identity,
  productName:product_name,
  productUrl: producturl,
  paymentPreference: [
    "MOBILE_BANKING",
    "KHALTI",
    "EBANKING",
    "CONNECT_IPS",
    "SCT",
  ],
  eventHandler: {
    onSuccess(payload) {
      var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");
      $.ajax({
        url: '/app/khalti/verify',
        type: "GET",
        data: {
          _token: CSRF_TOKEN,
          amount: payload.amount,
          token: payload.token,
        },
        beforeSend: function () {
          $("#khalti_payment_loader").show();
        },
        success: function (data) {
          console.log(data);
          if(data['status_code']==404){
            $("#khalti_payment_loader").hide();
            swal({
              title: "माफ गर्नुहोस!",
              text: data['message'],
              icon: "danger"
              },function () {
            window.location.replace('/app/taxduedetails/reportfailure');
             });

          }else{
            $("#khalti_payment_loader").hide();
            swal({
              title: "बधाई छ!",
              text: "!!भुक्तानी सफलतापूर्वक सम्पन्न भयो  !!",
              icon: "success"
            }, function () {
              window.location.replace('/app/paymentstatus/reportsuccess');
            });
          }

        },
        error: function (error) {
          $("#khalti_payment_loader").hide();
          console.log(error);
          swal({
            title: error.responseJSON.error,
          }, function () {
            window.history.back();
          });
        },
      });
      console.log(payload);
    },
    onError(error) {
      console.log(error);
    },
    onClose() {
      console.log("widget is closing");
    },
  },
};

var checkout = new KhaltiCheckout(config);
var btn = document.getElementById("payment-button");
btn.onclick = function () {
  $(".accept").val();

  if ($(".accept").is(":checked")) {
    var amount = $(this).attr("data-id");
    checkout.show({
      amount: amount,
    });
  } else {
    swal({
      title: "कृपया भुक्तानी सम्बन्धी शर्त स्वीकार गर्नुहोस् !!",
    });
    return false;
  }
};