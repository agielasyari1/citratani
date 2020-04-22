<!--footer-->
		<div class="footer">
		   <p>&copy; 2016 Shop Application. All Rights Reserved | <a href="" target="_blank">CV. Citra Tani</a></p>
		</div>
        <!--//footer-->
	</div>
	<!-- Classie -->
		<script src="<?php echo base_url('assets/js/classie.js');?>"></script>
                
                <!--<script type="text/javascript" src="https://cdn.datatables.net/t/dt/dt-1.10.11/datatables.min.js"></script>-->
                <script>
			var menuLeft = document.getElementById( 'cbp-spmenu-s1' ),
				showLeftPush = document.getElementById( 'showLeftPush' ),
				body = document.body;
				
			showLeftPush.onclick = function() {
				classie.toggle( this, 'active' );
				classie.toggle( body, 'cbp-spmenu-push-toright' );
				classie.toggle( menuLeft, 'cbp-spmenu-open' );
				disableOther( 'showLeftPush' );
			};
			

			function disableOther( button ) {
				if( button !== 'showLeftPush' ) {
					classie.toggle( showLeftPush, 'disabled' );
				}
			}
		</script>
	<!--scrolling js-->
	<script src="<?php echo base_url('assets/js/jquery.nicescroll.js');?>"></script>
	<script src="<?php echo base_url('assets/js/scripts.js');?>"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
   <script src="<?php echo base_url('assets/js/bootstrap.js');?>"> </script>
   <script src="<?php echo base_url('assets/js/moment.min.js');?>"> </script>
   <script src="<?php echo base_url('assets/js/daterangepicker.js');?>"> </script>
   <script src="<?php echo base_url('assets/js/datatables.min.js');?>"> </script>
   <script src="<?php echo base_url('assets/js/dataTables.buttons.min.js');?>"> </script>
   <script src="<?php echo base_url('assets/js/buttons.print.min.js');?>"> </script>
   <script src="<?php echo base_url('assets/js/buttons.html5.min.js');?>"> </script>
   <script src="<?php echo base_url('assets/js/jszip.min.js');?>"> </script>
   
   
</body>
</html>