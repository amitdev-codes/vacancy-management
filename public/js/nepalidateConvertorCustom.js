function convertAdtoBs(dateAdId,dateBsId){
    var regEx = /^\d{4}-\d{2}-\d{2}$/;
    var isvalid=$(dateAdId).val();
      if(!isvalid.match(regEx)){

      }
    else{
        $(dateBsId).val(AD2BS($(dateAdId).val()));
      }
    
}
function convertBstoAd(dateBsId,dateAdId){
var regEx = /^\d{4}-\d{2}-\d{2}$/;
var isvalid=$(dateBsId).val();
      if(!isvalid.match(regEx)){

      }
      else{
        $(dateAdId).val(BS2AD($(dateBsId).val()));
      }
}