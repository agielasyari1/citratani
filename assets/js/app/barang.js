    var goodTable;
    var deletedId;
    var action;
    $(document).ready(function() {
        
        goodTable = $('#example').DataTable({ 
            
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"barang/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [2,3,4,5,6] }
            ],
        } );
        
        
        $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            nama_barang: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            stok: {
                row: '.col-sm-5',
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
            harga_beli: {
                    row: '.col-sm-5',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        numeric: {
                            message: 'The value is not a number'
                        }
                    }
                },
            harga_jual_eceran: {
                    row: '.col-sm-5',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        numeric: {
                            message: 'The value is not a number'
                        }
                    }
                },
            harga_jual_grosir: {
                    row: '.col-sm-5',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        numeric: {
                            message: 'The value is not a number'
                        }
                    }
                },
            gudang: {
                    row: '.col-sm-5',
                    validators: {
                        notEmpty: {
                        }
                    }
                }
                
            }
        });
        
          $.ajax({
                url : site_url+"kategori/daftar_kategori",
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#kategori').text('');
                    $.each(data, function(key, value){
                        $('#kategori').append("<option value='"+key+"'>"+value+"</option>");
                    });
                    $('#kategori').val('');
                }
            });
            
            $.ajax({
                url : site_url+"satuan/daftar_satuan",
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#satuan').text('');
                    $.each(data, function(key, value){
                        $('#satuan').append("<option value='"+key+"'>"+value+"</option>");
                    });
                    $('#satuan').val('');
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
        
        $('#kategori').change(function (){
           alert(this.value); 
        });
        
        $('#cancelBtn').on('click', function(){
            fv.resetForm();
            $('#addUserForm')[0].reset();
        });
        
        $('#addBtn').on('click', function(){
            action = "Add";
            $('#addUserForm')[0].reset();
            $('#exampleModal').modal('show');
        });
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"barang/delete/"+deletedId ,
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
        goodTable.ajax.reload(null,false); //reload datatable ajax 
    } 
    
    function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"barang/add";
         }else{
             url = site_url+"barang/update";
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
                url : site_url+"barang/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#nama_barang').val(data.nama_barang);
                    $('#stok').val(data.stok);
                    $('#satuan').val(data.id_satuan);
                    $('#harga_beli').val(data.hrg_beli);
                    $('#harga_jual_eceran').val(data.hrg_jual_eceran);
                    $('#harga_jual_grosir').val(data.hrg_jual_grosir);
                    $('#gudang').val(data.gudang);
                    $('#kategori').val(data.id_kategori);
                    $('#exampleModal').modal('show');
                }
            });
        
    }