var SmartMultiFiled = (function(){
    var rowcount, html, addBtn, tableBody;

    addBtn = $("#addNew");
    rowcount = $("#autocomplete_table tbody tr").length+1;
    tableBody = $("#autocomplete_table tbody");


    function formHtml() {
        html = '<tr id="row_'+rowcount+'">';
        html += '<th id="delete_'+rowcount+'" scope="row" class="delete_row"><img src="src/images/minus.svg"   onmouseout="deleteRow();"  style="cursor:pointer"></th>';
        html += '<td>';
        html += '<input type="text" data-type="service" name="service[]" id="service_'+rowcount+'" class="form-control autocomplete_txt" autocomplete="off">';
        html += '</td>';
        html += '<td>';
        html += '<input type="text" data-type="qty" name="qty[]" id="qty_'+rowcount+'" class="qty form-control"   autocomplete="off">';
        html += '</td>';
         html += '<td>';
        html += '<input type="text" data-type="price" name="price[]" id="price_'+rowcount+'" class="form-control"   autocomplete="off">';
        html += '</td>';
        html += '<td>';
        html += '<input type="text" data-type="brandname" name="brandname[]" id="brandname_'+rowcount+'" class="form-control"   autocomplete="off">';
        html += '</td>';
        html += '<td>';
       html += '<input type="hidden" data-type="category" name="category[]" id="category_'+rowcount+'"  class="form-control" autocomplete="off">';
        html += '</td>';
        html += '</tr>';
        rowcount++;
        return html;
    }
    function getFieldNo(type){
        var fieldNo;
        switch (type) {
            case 'service':
                fieldNo = 0;
                break;
                  case 'qty':
                fieldNo = 1;
                break;
             case 'price':
                fieldNo = 2;
                break;
                case 'brandname':
                fieldNo = 3;
                break;
			case 'category':
                fieldNo = 4;
                break;	
		    default:
                break;
        }
        return fieldNo;
    }

    function handleAutocomplete() {
        var type, fieldNo, currentEle; 
        type = $(this).data('type');
        fieldNo = getFieldNo(type);
        currentEle = $(this);

        if(typeof fieldNo === 'undefined') {
            return false;
        }

        $(this).autocomplete({
            source: function( data, cb ) {	 
                $.ajax({
                    url:'ajax.php',
                    method: 'GET',
                    dataType: 'json',
                    data: {
                        name:  data.term,
                        fieldNo: fieldNo
                    },
                    success: function(res){
                        var result;
                        result = [
                            {
                                label: 'There is matching record found for '+data.term,
                                value: ''
                            }
                        ];

                        if (res.length) {
                            result = $.map(res, function(obj){
                                var arr = obj.split("|");
                                return {
                                    label: arr[fieldNo],
                                    value: arr[fieldNo],
                                    data : obj
                                };
                            });
                        }
                        cb(result);
                    }
                });
            },
            autoFocus: true,	      	
            minLength: 1,
            select: function( event, ui ) {
                var resArr, rowNo;
                
                
                rowNo = getId(currentEle);
                resArr = ui.item.data.split("|");	
             
                $('#service_'+rowNo).val(resArr[0]);
				$('#qty_'+rowNo).val(resArr[1]);
                $('#price_'+rowNo).val(resArr[2]);
				$('#category_'+rowNo).val(resArr[3]);
             }		      	
        });
    }

    function getId(element){
        var id, idArr;
        id = element.attr('id');
        idArr = id.split("_");
        return idArr[idArr.length - 1];
    }

    function addNewRow() { 
        tableBody.append( formHtml() );
    }

    function deleteRow() { 
        var currentEle, rowNo;
        currentEle = $(this);
        rowNo = getId(currentEle);		
        $("#row_"+rowNo).remove();
		
    }

    function registerEvents() {
        addBtn.on("click", addNewRow);
        $(document).on('click', '.delete_row', deleteRow);
        //register autocomplete events
        $(document).on('focus','.autocomplete_txt', handleAutocomplete);
    }
    function init() {
        registerEvents();
    }

    return {
        init: init
    };
})();



$(document).ready(function(){
    SmartMultiFiled.init();
});