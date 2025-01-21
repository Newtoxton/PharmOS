
//adds extra table rows
var i=$('table tr').length;
$(".addmore").on('click',function(){
	html = '<tr>';
	html += '<td><input class="case" type="checkbox"/></td>';
	html += '<td><input type="text" data-type="trade_name" name="itemNo[]" id="itemNo_'+i+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<input type="hidden" data-type="generic_name" name="data['+i+'][sno]" id="itemName_'+i+'" class="form-control autocomplete_txt" autocomplete="off">';
	html += '<td><input type="text" name="data['+i+'][batch]" id="batch" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td><input type="text" step="any" name="data['+i+'][expiry_date]" id="expiry_date" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td><input type="text" step="any" name="data['+i+'][sell_price]" id="sellPrice_'+i+'" class="form-control changesNo" readonly ></td>';
	html += '<td><input type="text" step="any" name="data['+i+'][wsale_price]" id="wsalePrice_'+i+'" class="form-control changesNo"  readonly ></td>';
	html += '<td><input type="text" name="data['+i+'][price]" id="price_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td><input type="text" name="data['+i+'][quantity]" id="quantity_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td><input type="text" name="data['+i+'][total]" id="total_'+i+'" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '</tr>';
	$('table').append(html);
	i++;
});

//to check all checkboxes
$(document).on('change','#check_all',function(){
	$('input[class=case]:checkbox').prop("checked", $(this).is(':checked'));
});

//deletes the selected table rows
$(".delete").on('click', function() {
	$('.case:checkbox:checked').parents("tr").remove();
	$('#check_all').prop("checked", false);
	calculateTotal();
});

//autocomplete script
$(document).on('focus','.autocomplete_txt',function(){
	type = $(this).data('type');

	if(type =='trade_name' )autoTypeNo=0;
	if(type =='generic_name' )autoTypeNo=1;

	$(this).autocomplete({
		source: function( request, response ) {
			$.ajax({
				url : 'ajax.php',
				dataType: "json",
				method: 'post',
				data: {
				   name_startsWith: request.term,
				   type: type
				},
				 success: function( data ) {
					 response( $.map( data, function( item ) {
					 	var code = item.split("|");
						return {
							label: code[autoTypeNo],
							value: code[autoTypeNo],
							data : item
						}
					}));
				}
			});
		},
		autoFocus: true,
		minLength: 0,
		select: function( event, ui ) {
			var names = ui.item.data.split("|");
			id_arr = $(this).attr('id');
	  		id = id_arr.split("_");
			$('#itemNo_'+id[1]).val(names[0]);
			$('#itemName_'+id[1]).val(names[1]);
			$('#quantity_'+id[1]).val(1);
			$('#sellPrice_'+id[1]).val(names[2]);
			$('#wsalePrice_'+id[1]).val(names[3]);
			$('#total_'+id[1]).val( 1*names[2] );
			calculateTotal();
		}
	});
});

//price change
$(document).on('change keyup blur','.changesNo',function(){
	id_arr = $(this).attr('id');
	id = id_arr.split("_");
	quantity = $('#quantity_'+id[1]).val();
	price = $('#price_'+id[1]).val();
	if( quantity!='' && price !='' ) $('#total_'+id[1]).val( (parseFloat(price)*parseFloat(quantity)).toFixed(2) );
	calculateTotal();
});

$(document).on('change keyup blur','#tax',function(){
	calculateTotal();
});

//total price calculation
function calculateTotal(){
	subTotal = 0 ; total = 0;
	$('.totalLinePrice').each(function(){
		if($(this).val() != '' )subTotal += parseFloat( $(this).val() );
	});
	$('#subTotal').val( subTotal.toFixed(2) );
	tax = $('#tax').val();
	if(tax != '' && typeof(tax) != "undefined" ){
		taxAmount = subTotal * ( parseFloat(tax) /100 );
		$('#taxAmount').val(taxAmount.toFixed(2));
		total = subTotal + taxAmount;
	}else{
		$('#taxAmount').val(0);
		total = subTotal;
	}
	$('#totalAftertax').val( total.toFixed(2) );
	calculateAmountDue();
}

$(document).on('change keyup blur','#amountPaid',function(){
	calculateAmountDue();
});

//due amount calculation
function calculateAmountDue(){
	amountPaid = $('#amountPaid').val();
	total = $('#totalAftertax').val();
	if(amountPaid != '' && typeof(amountPaid) != "undefined" ){
		amountDue = parseFloat(total) - parseFloat( amountPaid );
		$('.amountDue').val( amountDue.toFixed(2) );
	}else{
		total = parseFloat(total).toFixed(2);
		$('.amountDue').val( total );
	}
}


//It restrict the non-numbers
var specialKeys = new Array();
specialKeys.push(8,46); //Backspace
function IsNumeric(e) {
    var keyCode = e.which ? e.which : e.keyCode;
    console.log( keyCode );
    var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
    return ret;
}


$(document).ready(function(){
	if(typeof errorFlag !== 'undefined'){
		$('.message_div').delay(5000).slideUp();
	}
});


$('#to').datepicker({format: 'mm/dd/yyyy' , todayHighlight: true});
$('#to').on('changeDate', function(ev){
	$(this).datepicker('hide');
});


Date.prototype.addDays =function(s)
{

  var targetDays = parseInt(s)
  var thisYear = parseInt(this.getFullYear())
  var thisDays = parseInt(this.getDate())
  var thisMonth = parseInt(this.getMonth() + 1)

  var currDays = thisDays;
  var currMonth = thisMonth;
  var currYear = thisYear;

  var monthArr;

  var nonleap = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
  // leap year
  var leap = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

  if ((thisYear % 4) == 0) {
    if ((thisYear % 100) == 0 && (thisYear % 400) != 0) { monthArr = nonleap; }
    else { monthArr = leap; }
  }
  else {  monthArr = nonleap; }

  var daysCounter = 0;
  var numDays = 0;
  var monthDays = 0;

  if( targetDays < 0) {

    while(daysCounter < (targetDays * -1) ) {

      if(daysCounter == 0) {
        if((targetDays * -1) < thisDays) {
          break;
        } else {
          daysCounter = thisDays;
        }
      }else {
        numDays = monthArr[currMonth - 1];
        daysCounter += parseInt(numDays)
      }

      if(daysCounter > (targetDays * -1) ) {
        break;
      }

      currMonth = currMonth - 1;

      if(currMonth == 0) {
        currYear = currYear - 1;
        if ((currYear % 4) == 0) {
          if ((currYear % 100) == 0 && (currYear % 400) != 0) { monthArr = nonleap; }
          else { monthArr = leap; }
        }
        else {  monthArr = nonleap; }
        currMonth = 12;
      }
    }

    t = this.getTime();
    t += (targetDays * 86400000);
    this.setTime(t)
    var thisDate = new Date(currYear,currMonth - 1,this.getDate())
    return thisDate;

  } else {

    var diffDays = monthArr[currMonth - 1] - thisDays;

    numDays = 0;
    var startedC = true;

    while(daysCounter < targetDays  ) {

      if(daysCounter == 0 && startedC == true) {
        monthDays = thisDays;
        startedC = false;
      }else {
       monthDays++;
       daysCounter++;

        if(monthDays > monthArr[currMonth - 1]){
          currMonth = currMonth + 1;
          monthDays = 1;
        }

      }

      if(daysCounter > targetDays) {
        break;
      }

      if(currMonth == 13) {
        currYear = currYear + 1;
        if ((currYear % 4) == 0) {
          if ((currYear % 100) == 0 && (currYear % 400) != 0) { monthArr = nonleap; }
          else { monthArr = leap; }
        }
        else {  monthArr = nonleap; }
        currMonth = 1;
      }
    }

    var thisDate = new Date(currYear,currMonth - 1,monthDays)
    return thisDate;
  }
}
