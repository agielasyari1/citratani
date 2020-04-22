    var userTable;
    var deletedId;
    var action;
    $(document).ready(function() {
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"supplier/view",
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },
            ],
        } );
        
        
        $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            nama_toko: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                },
            nama: {
                row: '.col-sm-9',
                validators: {
                    notEmpty: {
                        message: 'Mohon diisi'
                    }
                }
            },
            alamat: {
                row: '.col-sm-9',
                validators: {
                    notEmpty: {
                        message: 'Mohon diisi'
                    }
                }
            },
            no_telp: {
                row: '.col-sm-9',
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
        });
        
        $('#addBtn').on('click', function(){
            action = "Add";
            $('#addUserForm')[0].reset();
            $('#exampleModalLabel').text("Tambah Supplier");
            $('#exampleModal').modal('show');
        });
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"supplier/delete/"+deletedId ,
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
    
    function addUser(fv){
         
         var url;
         if(action == "Add"){
             url = site_url+"supplier/add";
         }else{
             url = site_url+"supplier/update";
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
                        $("#saveBtn").prop('disabled', false);
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
                url : site_url+"supplier/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#exampleModalLabel').text("Ubah Supplier");
                    $('#nama_toko').val(data.nama_toko);
                    $('#nama').val(data.nama);
                    $('#alamat').val(data.alamat);
                    $('#no_telp').val(data.no_telp);
                    $('#exampleModal').modal('show');
                }
            });
        
    }