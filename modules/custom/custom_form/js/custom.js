jQuery(document).ready(function(){
  jQuery(".cu_row").keyup(function(){
    var id = jQuery(this).attr('id');
    sum(id);
  });
});

function sum (cid) {
  var idarr = cid.split("-");
  var row = idarr[2]; //Storing row no of input column
  var column = idarr[4]; //Strong Column no of input column
  var one = jQuery("#edit-mytable-" + row + "-col-1").val();  //Fetching value of particular row
  var two = jQuery("#edit-mytable-" + row + "-col-2").val();  //Fetching value of particular row
  if(one != NaN && two != NaN && one != '' && two != '')
  {
    var sum = parseInt(one) + parseInt(two); // If values are not empty then adding the values
    jQuery("#edit-mytable-" + row + "-col-3").val(sum);   // Showing the values in
  }
  else if(one == '' || two == '' || one == NaN || two == NaN){
    jQuery("#edit-mytable-" + row + "-col-3").val(0);
  }

// To add Total Values and show it in the GrandTotal
  var total = 0;
  jQuery(".cu_total").each(function() {
    if (this.value != ''){
      total += parseInt(this.value);
      jQuery(".Grandtotal").val(total);
    }
    else
    jQuery(".Grandtotal").val(0);
  });
}
