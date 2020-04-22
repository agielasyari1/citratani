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
                "url": site_url+"pengguna/view",
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
            username: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        stringLength: {
                            min: 8,
                            message: 'The username must be at least 8 characters'
                        }
                    }
                },
            password: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        stringLength: {
                            min: 8,
                            message: 'The password must be at least 8 characters'
                        }
                    }
                },
            posisi: {
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        }
                    }
                }
            }
        });
        
        var fv =  $('#addUserForm').data('formValidation');
        
       $('#posisi').change(function (){
          generateID(); 
       }); 
        
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
            $('#exampleModalLabel').text("Tambah Pengguna");
            //generateID();
            $('#exampleModal').modal('show');
        });
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"pengguna/delete/"+deletedId ,
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
             url = site_url+"pengguna/add";
         }else{
             url = site_url+"pengguna/update";
         }
        
         $.ajax({
                url : url,
                type: "POST",
                data: $("#addUserForm").serialize(),
                dataType: "JSON",
                success: function(data)
                {
                    if(data.status){
                        $('#exampleModal').modal('hide');
                        reload_table();
                        fv.resetForm();
                        $('#addUserForm')[0].reset();
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
                url : site_url+"pengguna/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#exampleModalLabel').text("Ubah Pengguna");
                    $('#username').val(data.username);
                    $('#password').val("........");
                    $('#nama').val(data.nama);
                    $('#alamat').val(data.alamat);
                    $('#no_telp').val(data.no_telp);
                    $('#posisi').val(data.posisi);
                    $('#exampleModal').modal('show');
                }
            });
        
    }
    
    function generateID(){
        
        $.ajax({
                url : site_url+"pengguna/generateID",
                type: "POST",
                data: {'posisi':$("#posisi").val()},
                dataType: "JSON",
                success: function(data)
                {
                        $('#username').val(data.username);
                }
            });
        
    }