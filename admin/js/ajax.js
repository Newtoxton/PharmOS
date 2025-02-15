
//adds extra table rows
var i=$('table tr').length;
$(".addmore").on('click',function(){
	html = '<tr>';
	html += '<td><input class="case" type="checkbox"/></td>';
	html += '<td><input type="text" data-type="trade_name" name="itemNo[]" id="itemNo_'+i+'" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<input type="hidden" data-type="generic_name" name="sno[]" id="itemName_'+i+'" class="form-control autocomplete_txt" autocomplete="off">';
    html += '<td><input type="text" name="batch[]" id="batch" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td><input type="text" step="any" name="expiry_date[]" id="expiry_date" class="form-control autocomplete_txt" autocomplete="off"></td>';
	html += '<td><input type="text" step="any" name="sell_price[]" id="sellPrice_'+i+'" class="form-control changesNo"  ></td>';
	html += '<td><input type="text" step="any" name="wsale_price[]" id="wsalePrice_'+i+'" class="form-control changesNo"  ></td>';
	html += '<td><input type="text" name="price[]" id="price_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td><input type="text" name="quantity[]" id="quantity_'+i+'" class="form-control changesNo" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
	html += '<td><input type="text" name="total[]" id="total_'+i+'" class="form-control totalLinePrice" autocomplete="off" onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;"></td>';
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
			 var array = $.map(prices, function (item) {
                 var code = item.split("|");
                 return {
                     label: code[autoTypeNo],
                     value: code[autoTypeNo],
                     data : item
                 }
             });
             //call the filter here
             response($.ui.autocomplete.filter(array, request.term));
		},
		autoFocus: true,
		minLength: 2,
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
