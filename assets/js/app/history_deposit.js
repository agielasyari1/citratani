    var userTable;
    var deletedId;
    var action;
    $(document).ready(function() {
        
        sisa_deposit();
        
        userTable = $('#example').DataTable({ 
            "oLanguage": {
                "sProcessing": '<div class="overlay"><i class="fa fa-spinner fa-spin"></i></div>'
            },
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "ajax": {
                "url": site_url+"history_deposit/view/"+id_deposit,
                "type": "POST",
                data:{ajaxreq:true}
            },
            "columnDefs": [
            { 
                "targets": [ 0, -1 ], //last column
                "orderable": false, //set not orderable
            },{ className: "dt-right", "targets": [2] }
            ],
        } );
        
        
        $('#addUserForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            jumlah: {
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
            $("#exampleModalLabel").text("Tambah Deposit");
            $('#exampleModal').modal('show');
        });
        
        $('#yesBtn').on('click', function(){
            $.ajax({
                url : site_url+"history_deposit/delete/"+deletedId ,
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
             url = site_url+"history_deposit/add/"+id_deposit;
         }else{
             url = site_url+"history_deposit/update";
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
                        sisa_deposit();
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
                url : site_url+"history_deposit/detail/"+id ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                     $("#exampleModalLabel").text("Ubah Deposit");
                    $('#jumlah').val(data.jumlah);
                    $('#exampleModal').modal('show');
                }
            });
        
    }
    
    function sisa_deposit(){
        $.ajax({
                url : site_url+"history_deposit/sisa_deposit/"+id_deposit,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#kios').text(data.nama_kios);
                    $('#sisa').text(data.jumlah);
                }
            });
    }