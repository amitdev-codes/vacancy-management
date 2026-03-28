function paymentdata(tid, epaycode, amount) {
  var CSRF_TOKEN = $('meta[name="csrf-token"]').attr("content");

  $.ajax({
    url: "/app/paymentdata/view",
    type: "GET",
    data: {
      _token: "{{ csrf_token() }}",
      tpid: tid,
      epaycode: epaycode,
      amount: amount,
    },
    timeout: 50000,
    beforeSend: function () {
      $("#loader").show();
      // debugger;
    },
    success: function (data) {
      5;
      $("#loader").hide();
      console.log(data);
      if (data["check_receipt_status"] == "true") {
        window.location = "/app/verifyTaxStatus?epay=" + data["epaycode"];
      } else {
        var msg = data["check_receipt_message"];
        swal(
          {
            title: "माफ गर्नुहोस!",
            text: msg,
            icon: "warning",
          },
          function () {
            location.reload();
          }
        );
      }
    },
    error: function () {
      swal(
        {
          title: "माफ गर्नुहोस!",
          text: "कृपया पुनः प्रयास गर्नुहोला",
          icon: "warning",
          // }).then(() => location.reload());
        },
        function () {
          location.reload();
        }
      );
    },
  });
}
