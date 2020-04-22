    var userTable;
    var deletedId;
    var action = "Add";
    $(document).ready(function() {
        
        var date = new Date();
        date.setDate(date.getDate()-1);
        
        $('#batas_pembayaran').datepicker({
            format: "yyyy-mm-dd",
            container: '#addUserForm2' ,
            startDate: date
        });
        
        $('#tanggal_permintaan').datepicker({
            format: "yyyy-mm-dd",
            container: '#addUserForm2' ,
            startDate: date
        });
        
        $("#printBtn").click(function (){
            print_kw();
        });
       
       total_jual($("#no_pembelian").val());
       
       $("#batalBtn").click(function (){
            $.ajax({
                url : site_url+'d_pembeliana/batal/'+$("#no_pembelian").val(),
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                   if(data.status){
                       window.location = site_url+"a_pembelian";
                   }
                }
            });  
       });
       
      
         
      $( "#id_supplier" ).autocomplete({
            source: site_url+"supplier/daftar_supplier",
            minLength: 2,
            appendTo: "#addUserForm2"
          });
       
       generate_auto();
       
       $("#qty").keyup(function (){
           countTotal();
       });
       $("#harga_satuan").keyup(function (){
           countTotal();
       });
       
        
        $('#ppembayaran').keyup(function (){
           count_sisa_kembali();
        });
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"d_pembeliana/view/"+$("#no_pembelian").val(),
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [2,3,4] }
            ],
        } );
        
        
        $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            qty: {
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            harga_satuan: {
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            id_barang: {
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                }
            
            }
        }).on('err.field.fv', function(e, data) {
            // $(e.target)  --> The field element
            // data.fv      --> The FormValidation instance
            // data.field   --> The field name
            // data.element --> The field element

            // Hide the messages
            data.element
                .data('fv.messages')
                .find('.help-block[data-fv-for="' + data.field + '"]').hide();
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
        $('#saveBtn').on('click', function(){
            
            fv.validate();
            if(fv.isValid()){
                addUser(fv);
                
            }
        });
        
         $('#addUserForm2').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            id_supplier: {
                    row: '.col-sm-5',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            ppembayaran: {
                    row: '.col-sm-5',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                }
            
            }
        });
        
        var fv2 =  $('#addUserForm2').data('formValidation');
        
        $('#saveBtn2').on('click', function(){
            
            fv2.validate();
            if(fv2.isValid()){
                addUser2(fv2);
                
            }
            
        });
        
        
        $('#cancelBtn').on('click', function(){
            fv2.resetForm();
            $('#addUserForm2')[0].reset();
        });
        
        $('#qty').on('keyup', function(){
            countTotal();
        });
        
         $('#prosessBtn').on('click', function(){
            
             $.ajax({
                url : site_url+"a_pembelian/detail/"+$("#pno_pembelian").val(),
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                   
                    if(data.id_supplier != 0){
                        $('#id_supplier').val(data.id_supplier+"- "+data.nama_toko);
                    }else{
                        $('#id_supplier').val("");
                    }
                   
                    $('#ptotal').val(data.total);
                    
                    if(data.tanggal_permintaan != "0000-00-00"){
                        $('#tanggal_permintaan').val(data.tanggal_permintaan);
                    }else{
                            var today = new Date();
                            var dd = today.getDate();
                            var mm = today.getMonth()+1; //January is 0!

                            var yyyy = today.getFullYear();
                            if(dd<10){
                                dd='0'+dd
                            } 
                            if(mm<10){
                                mm='0'+mm
                            } 
                            var today = yyyy+'-'+mm+'-'+dd;
                        $('#tanggal_permintaan').val(today);
                    }
                    
                    $('#batas_pembayaran').val(data.batas_pembayaran);
                    $('#ppembayaran').val(data.pembayaran);
                    $('#psisa').val(data.sisa);
                    count_sisa_kembali();
                }
            });
            
            $('#exampleModal').modal('show');
            
        });
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"d_pembeliana/delete/"+deletedId ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    reload_table();
                    total_jual($("#no_pembelian").val());
                    $('#modal-confirm').modal('hide');
                }
            });
        });
        
        
    } );
    
    function reload_table()
    {
        userTable.ajax.reload(null,false); //reload datatable ajax 
    } 
    
   
  
    
    function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"d_pembeliana/add";
         }else{
             url = site_url+"d_pembeliana/update";
             action = "Add";
         }
        
         $.ajax({
                url : url,
                type: "POST",
                data: $("#addUserForm").serialize(),
                dataType: "JSON",
                beforeSend: function() { 
                    $("#saveBtn").text("Saving...");
                    $("#saveBtn").prop('disabled', true); // disable button
                },
                success: function(data)
                {
                    if(data.status){
                        $('#exampleModal').modal('hide');
                        reload_table();
                        fv.resetForm();
                        total_jual($("#no_pembelian").val());
                        $('#addUserForm')[0].reset(); 
                        $('#id_barang').val('') 
                        $("#saveBtn").html("<i class='fa fa-plus'></i>");
                        $("#saveBtn").prop('disabled',false); // disable button
                    }else{
                        alert('Fail');
                    }
                }
            });
    }
    
    function addUser2(fv){
       
         var url = site_url+"a_pembelian/update";
        
         $.ajax({
                url : url,
                type: "POST",
                data: $("#addUserForm2").serialize(),
                dataType: "JSON",
                beforeSend: function() { 
                    $("#saveBtn2").text("Saving...");
                    $("#saveBtn2").prop('disabled', true); // disable button
                },
                success: function(data)
                {
                    if(data.status){
                        $('#exampleModal').modal('hide');
                        fv.resetForm();
                        $('#addUserForm2')[0].reset(); 
                    $("#saveBtn2").text("Save");
                    $("#saveBtn2").prop('disabled',false); // disable button
                    window.location = site_url+"a_pembelian";
                    }else{
                        alert('Fail');
                    }
                }
            });
    }
    
    
    function del(id){
        deletedId = id;
        $('#modal-confirm').modal('show');
    }
    
    function change(id){
        action = "Update";
        $('#username2').val(id);
        $.ajax({
                url : site_url+"d_pembeliana/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#no_pembelian').val(data.no_pembelian);
                    $('#id_barang').val(data.id_barang+"-"+data.nama_barang);
                    $('#total').val(data.harga_total);
                    $('#harga_satuan').val(data.harga_satuan);
                    $('#qty').val(data.qty);
                    generate_auto();
                    $("#saveBtn").html("<i class='fa fa-save'></i>");
                    $('#saveBtn').prop('disabled', false);
                }
            });
        
    }
    
   
    
    function countTotal(){
        $('#total').val($("#qty").val()*$("#harga_satuan").val());
    }
    
    function detail(id){
        window.location = site_url+"d_penjulanpartai/"+id;
    }
    
    function print_kw(id){
        window.open(site_url+"print_kw/p_kuitansi/"+id);
    }
    
     function total_jual(id){
         $.ajax({
                url : site_url+"a_pembelian/get_total_jual/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(resp)
                {
                    var total = resp.total;
                    $('#totalTxt').text(resp.total);
                }
            });
    }
    
    function count_sisa_kembali(){
       
              $('#psisa').val($('#ptotal').val() - $('#ppembayaran').val());
       
    }
    
    function generate_auto(){
        
        $( "#id_barang" ).autocomplete();
         
              $( "#id_barang" ).autocomplete({
                    source: site_url+"barang/daftar_barang2",
                    minLength: 2,
                    select: function( event, ui ) {
                        $('#qty').val("");

                    }
                  });
              
         
    }