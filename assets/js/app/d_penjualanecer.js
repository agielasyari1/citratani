    var userTable;
    var deletedId;
    var action = "Add";
    var autoUrl = "";
    $(document).ready(function() {
       
        var date = new Date();
        date.setDate(date.getDate()-1);
        
        $("#printBtn").click(function (){
            print_kw();
        });
        
        total_jual($("#no_penjualan").val());
       
       $("#batalBtn").click(function (){
            $.ajax({
                url : site_url+'d_penjualanecer/batal/'+$("#no_penjualan").val(),
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                   if(data.status){
                       window.location = site_url+"penjualanecer";
                   }
                }
            });  
       });
       
       $('#gudang').change(function (){
          generate_auto();
           
       });
       
       
        $('#ppembayaran').keyup(function (){
           if(($('#gtotal').val() - $('#ppembayaran').val()) < 0){
               $('#psisa').val("0");
               $('#pkembali').val($('#ppembayaran').val() - $('#gtotal').val());
               
           }else{
               $('#psisa').val($('#gtotal').val() - $('#ppembayaran').val());
              $('#pkembali').val("0");
           }
        });
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"d_penjualanecer/view/"+$("#no_penjualan").val(),
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
                        notEmpty:{
                            
                        }
                    }
                },
            gudang: {
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
            id_customer: {
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
        
        $('#harga_satuan').keyup(function (){
           countTotal(); 
        });
        
        $('#prosessBtn').on('click', function(){
            
             $.ajax({
                url : site_url+"penjualanecer/detail/"+$("#pno_penjualan").val(),
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#id_customer').val(data.nama_pembeli);
                    $('#ptotal').val(data.total);
                    $('#ppn').val(data.total * ppn / 100);
                    $('#gtotal').val(parseFloat($('#ptotal').val()) + parseFloat($('#ppn').val()));
                    $('#ppembayaran').val(data.pembayaran);
                    $('#psisa').val(parseFloat($('#gtotal').val()) - parseFloat($('#ppembayaran').val()));
                   
                }
            });
            
            $('#exampleModal').modal('show');
            
        });
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"d_penjualanecer/delete/"+deletedId ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    reload_table();
                    total_jual($("#no_penjualan").val());
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
             url = site_url+"d_penjualanecer/add";
         }else{
             url = site_url+"d_penjualanecer/update";
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
                        total_jual($("#no_penjualan").val());
                        $('#id_barang').text("");
                        $('#addUserForm')[0].reset();
                        $("#saveBtn").html("<i class='fa fa-plus'></i>");
                        $("#saveBtn").prop('disabled',false); // disable button
                    }else{
                        alert('Fail');
                    }
                }
            });
    }
    
    
    function addUser2(fv){
       
         var url = site_url+"penjualanecer/update";
        
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
                    window.location = site_url+"penjualanecer";
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
                url : site_url+"d_penjualanecer/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#no_penjualan').val(data.no_penjualan);
                    $('#gudang').val(data.gudang);
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
                url : site_url+"penjualanecer/get_total_jual/"+id,
                type: "GET",
                dataType: "JSON",
                success: function(resp)
                {
                    var total = resp.total;
                    $('#totalTxt').text(resp.total);
                }
            });
    }
    
    function generate_auto(){
        var gudang = $( "#gudang" ).val(); 
        $( "#id_barang" ).autocomplete();
          if(gudang != ""){
              if(gudang == "Gudang A"){
                  autoUrl = site_url+"barang/daftar_barang";
                  $( "#id_barang" ).autocomplete('destroy');
              }else{
                  autoUrl = site_url+"barang/daftar_barangB";
                  $( "#id_barang" ).autocomplete('destroy');
              }
              
              $( "#id_barang" ).autocomplete({
                    source: autoUrl,
                    minLength: 2,
                    select: function( event, ui ) {
                        var str = ui.item.value;
                        var res = str.split("-",1);

                        $.ajax({
                        url : site_url+'barang/get_harga_ecer/'+res,
                        type: "GET",
                        dataType: "JSON",
                        success: function(data)
                        {
                            $('#harga_satuan').val(data.harga_grosir);
                            $('#qty').val("");
                            countTotal();
                        }
                        });  

                    }
                  });
              
          }else{
               $( "#id_barang" ).autocomplete('destroy');
               
          }
    }