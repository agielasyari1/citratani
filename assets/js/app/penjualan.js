    var userTable;
    var deletedId;
    var action;
    $(document).ready(function() {
        
        var date = new Date();
        date.setDate(date.getDate()-1);
        
        $("#printBtn").click(function (){
            print_kw();
        });
        
        $('#tanggal_pengantaran').datepicker({
            format: "yyyy-mm-dd",
            container: '#addUserForm' ,
            startDate: date
        });
        
        $.ajax({
            url : site_url+"pengecer/daftar_pengecer",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $.each(data, function(key, value){
                    $('#id_pengecer').append("<option value='"+key+"'>"+value+"</option>");
                });
                $.each(data, function(key, value){
                    $('#vid_pengecer').append("<option value='"+key+"'>"+value+"</option>");
                });
                $('#id_pengecer').val("");
                $('#vid_pengecer').val("");
            }
        });  
        
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"penjualan/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, 8, 9, 10, 11, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [4,5,6,7] }
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
            id_pengecer: {
                validators: {
                    notEmpty: {
                        message: 'Mohon diisi'
                    }
                }
            },
            jumlah: {
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
                },
            tanggal_pengantaran: {
                row: '.col-sm-4',
                validators: {
                    notEmpty: {
                        message: 'Mohon diisi'
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
            $('#saveBtn').prop('disabled', false);
            $("#exampleModalLabel").text("Tambah Penjualan");
            generateNO();
            $('#exampleModal').modal('show');
            
        });
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"penjualan/delete/"+deletedId ,
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
                url : site_url+"penjualan/generateNO",
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                        $('#no_penjualan').val(data.no_penjualan);
                }
            });
        
    }
    
    function countTotal(){
        
        $.ajax({
                    url : site_url+"penjualan/calculateTotal",
                    type: "POST",
                    data: {jumlah : $("#jumlah").val(), id_barang : $('#id_barang').val()},
                    dataType: "JSON",
                    success: function(data)
                    {
                            $('#total').val(data.total);
                            $('#ppn').val(parseInt(data.total/ppn));
                            $('#dpp').val(parseInt(data.total - (data.total)/ppn));
                    }
                });
    }
    
    function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"penjualan/add";
         }else{
             url = site_url+"penjualan/update";
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
                    $("#saveBtn").prop('disabled',false); // disable button
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
                url : site_url+"penjualan/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $("#exampleModalLabel").text("Ubah Penjualan");
                    $('#no_penjualan').val(data.no_penjualan);
                    $('#keterangan').val(data.keterangan);
                    $('#id_pengecer').val(data.id_pembeli);
                    $('#id_barang').val(data.id_barang);
                    $('#jumlah').val(data.jumlah);
                    $('#dpp').val(data.dpp);
                    $('#ppn').val(data.ppn);
                    $('#total').val(data.total);
                    $('#tanggal_penjualan').val(data.tanggal_penjualan);
                    $('#tanggal_pengantaran').val(data.tanggal_pengantaran);
                    $('#saveBtn').prop('disabled', false);
                    $('#exampleModal').modal('show');
                }
            });
        
    }
    
    function view(id){
       
        $.ajax({
                url : site_url+"penjualan/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $("#exampleModalLabel").text("Detail Penjualan");
                    $('#no_penjualan').val(data.no_penjualan);
                    $('#keterangan').val(data.keterangan);
                    $('#id_pengecer').val(data.id_pembeli);
                    $('#id_barang').val(data.id_barang);
                    $('#jumlah').val(data.jumlah);
                    $('#dpp').val(data.dpp);
                    $('#ppn').val(data.ppn);
                    $('#total').val(data.total);
                    $('#tanggal_penjualan').val(data.tanggal_penjualan);
                    $('#tanggal_pengantaran').val(data.tanggal_pengantaran);
                    $('#saveBtn').prop('disabled', true);
                    $('#exampleModal').modal('show');
                }
            });
        
    }
    
    function print_kw(id){
        window.open(site_url+"print_kw/p_kuitansi/"+id);
    }