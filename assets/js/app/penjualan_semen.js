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
        
        $('#kategori').on('change', function (){
           
          
               countTotal();
             
           
           daftar_pembeli(this.value, "") 
           
        });
        
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"semen_penjualan/view",
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
            harga_jual: {
                validators: {
                    notEmpty: {
                        message: 'Mohon diisi'
                    }
                }
            },
            kategori: {
                validators: {
                    notEmpty: {
                        message: 'Mohon diisi'
                    }
                }
            },
            pembeli: {
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
        $('#harga_jual').on('keyup', function(){
            countTotal();
        });
        $('#biaya_kuli').on('keyup', function(){
            countTotal();
        });
        
        $('#addBtn').on('click', function(){
            action = "Add";
             $("#saveBtn").prop('disabled',false);
            $("#exampleModalLabel").text("Tambah Pembelian");
            $("#addUserForm")[0].reset();
            $('#pembeli').text('');
            generateNO();
            $('#exampleModal').modal('show');
            
        });
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"semen_penjualan/delete/"+deletedId ,
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
    
    
    function daftar_pembeli(kategori, val){
        $.ajax({
                url : site_url+"pembeli/daftar_pembeli",
                type: "POST",
                data: {'kategori': kategori},
                dataType: "JSON",
                success: function(data)
                {
                    $('#pembeli').text('');
                    $.each(data, function(key, value){
                        $('#pembeli').append("<option value='"+key+"'>"+value+"</option>");
                    });
                    $('#pembeli').val(val);
                }
            });  
    }
    
    function reload_table()
    {
        userTable.ajax.reload(null,false); //reload datatable ajax 
    } 
    
    function generateNO(){
        
        $.ajax({
                url : site_url+"semen_penjualan/generateNO",
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                        $('#no_penjualan').val(data.no_penjualan);
                }
            });
        
    }
    
    function countTotal(){
        var biaya_kuli;
        if($('#biaya_kuli').val() == ""){
            biaya_kuli = parseInt(0);
        }else{
            biaya_kuli = parseInt($('#biaya_kuli').val());
        }
        
        $('#total').val(parseInt($('#harga_jual').val()*$('#jumlah').val())+biaya_kuli);
        $('#ppn').val(parseInt($('#total').val()/ppn));
        $('#dpp').val($('#total').val() - parseInt($('#total').val()/ppn));
        
    }
    
    function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"semen_penjualan/add";
         }else{
             url = site_url+"semen_penjualan/update";
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
         $("#saveBtn").prop('disabled',false);
        $('#username2').val(id);
        $.ajax({
                url : site_url+"semen_penjualan/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $("#exampleModalLabel").text("Ubah Pembelian");
                    $('#no_penjualan').val(data.no_penjualan);
                    $('#keterangan').val(data.keterangan);
                    $('#kategori').val(data.kategori);
                    daftar_pembeli(data.kategori, data.id_pembeli)
                    $('#harga_jual').val(data.harga_jual);
                    $('#biaya_kuli').val(data.biaya_kuli);
                    $('#jumlah').val(data.jumlah);
                    $('#dpp').val(data.dpp);
                    $('#ppn').val(data.ppn);
                    $('#total').val(data.total);
                    $('#tanggal_penjualan').val(data.tanggal_penjualan);
                    $('#tanggal_pengantaran').val(data.tanggal_pengantaran);
                    $('#exampleModal').modal('show');
                }
            });
        
    }
    
    function view(id){
        $.ajax({
                url : site_url+"semen_penjualan/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $("#exampleModalLabel").text("Detail Pembelian");
                    $('#no_penjualan').val(data.no_penjualan);
                    $('#keterangan').val(data.keterangan);
                    $('#kategori').val(data.kategori);
                    daftar_pembeli(data.kategori, data.id_pembeli)
                    $('#harga_jual').val(data.harga_jual);
                    $('#biaya_kuli').val(data.biaya_kuli);
                    $('#jumlah').val(data.jumlah);
                    $('#dpp').val(data.dpp);
                    $('#ppn').val(data.ppn);
                    $('#total').val(data.total);
                    $('#tanggal_penjualan').val(data.tanggal_penjualan);
                    $('#tanggal_pengantaran').val(data.tanggal_pengantaran);
                     $("#saveBtn").prop('disabled',true);
                    $('#exampleModal').modal('show');
                }
            });
        
    }
    
      function print_kw(id){
        window.open(site_url+"print_kw/p_kuitansi/"+id);
    }