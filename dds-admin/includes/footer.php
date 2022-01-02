	<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
		});
		</script>
<div class="copyrights">
	 	 <p>&copy; <?= date('Y');?>  All Rights Reserved.  Design by 
			<a href="#">xyz</a> </p>
</div>
</div>
</div>

<script>
$(document).ready(function() {
    $('#table1').DataTable( {	
        dom: 'Bfrtip',
		lengthMenu: [
            [ 10, 25, 50, -1 ],
            [ '10 rows', '25 rows', '50 rows', 'Show all' ]
        ],
		buttons: [
    {
        extend: 'pageLength'
        
    },
	{
        extend: 'excel',
        text: 'Export',
        exportOptions: {
            columns: 'th:not(:last-child)'
        }
    },
	{
extend: 'csvHtml5',
text: ' CSV',
exportOptions: {
columns: ':not(:last-child)',
}
},
	{
extend: 'pdfHtml5',
text: ' PDF',
exportOptions: {
columns: ':not(:last-child)',
}
}
	]
    } );
} );

</script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/dataTables.buttons.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script> 
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> 
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.4/js/buttons.html5.min.js"></script> 

<script src="js/jquery-ui.js"></script>

