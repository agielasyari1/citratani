    var userTable;
    var deletedId;
    var action;
    $(document).ready(function() {
        
        var date = new Date();
        date.setDate(date.getDate()-1);
        
        $('#tanggal_pengantaran').datepicker({
            format: "yyyy-mm-dd",
            container: '#addUserForm' ,
            startDate: date
        });
        
     
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"transaksi_lain/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [3] }
            ],
        } );
        
        
        $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            keterangan: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            total: {
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        numeric: {
                            message: 'The value is not a number',
                            // The default separators
                            decimalSeparator: '.'
                        }
                    }
                }
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
        $('#saveBtn').on('click', function(){
            
            fv.validate();
            if(fv.isValid()){
                addUser(fv);
                
            }else{
                alert('Not Valid');
            }
            
        });
        
        $('#cancelBtn').on('click', function(){
            fv.resetForm();
            $('#addUserForm')[0].reset();
            $('#id_barang').val("");
            $('#id_pengecer').val("");
        });
        
        $('#jumlah').on('keyup', function(){
            countTotal();
        });
        $('#id_barang').on('change', function(){
            countTotal();
        });
        
        $('#addBtn').on('click', function(){
            action = "Add";
            $("#exampleModalLabel").text("Tambah Transaksi");
            generateNO();
            $('#exampleModal').modal('show');
            
        });
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"transaksi_lain/delete/"+deletedId ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    reload_table();
                    $('#modal-confirm').modal('hide');
                }
            });
        });
        
        
    } );
    
    function reload_table()
    {
        userTable.ajax.reload(null,false); //reload datatable ajax 
    } 
    
    function generateNO(){
        
        $.ajax({
                url : site_url+"transaksi_lain/generateNO",
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                        $('#no_penjualan').val(data.no_penjualan);
                }
            });
        
    }
    
    
    
    function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"transaksi_lain/add";
         }else{
             url = site_url+"transaksi_lain/update";
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
                        $('#addUserForm')[0].reset();
                    $("#saveBtn").text("Save");
                    $("#saveBtn").prop('disabled', false); // disable button
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
                url : site_url+"transaksi_lain/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $("#exampleModalLabel").text("Ubah Transaksi");
                    $('#no_penjualan').val(data.id_transaksi);
                    $('#keterangan').val(data.keterangan);
                    $('#total').val(data.total);
                    $('#exampleModal').modal('show');
                }
            });
        
    }