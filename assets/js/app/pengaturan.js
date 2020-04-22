$(document).ready(function(){
    
    view_setting();
    
    $('#saveBtn').on('click', function (){
       
       $.ajax({
          
            url : site_url+"pengaturan/update",
            type: "POST",
            data: $('#formSetting').serialize(),
            dataType: "JSON",
            success: function(data)
            {
                if(data.status){
                    alert('Disimpan');
                }else{
                    alert('Gagal');
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
            
       });
       
    });
    
    
//    $('#backupBtn').on('click', function (){
//       $.ajax({
//          
//            url : site_url+"pengaturan/backup_db",
//            type: "GET",
//            dataType: "JSON",
//            success: function(data)
//            {
//               if(data.status){
//                    alert('Disimpan di "'+data.dir+'"');
//                }else{
//                    alert('Gagal');
//                }
//            }
//       });
//    });
    
    $('#restoreBtn').on('click', function (){
        
        if (typeof FormData !== 'undefined') {

                var formData = new FormData( $("#formSetting3")[0]);
            
            $.ajax({
                   url : site_url+"pengaturan/restore_db" ,
                   type: "POST",
                   data : formData,
                   cache : false,
                   contentType : false,
                   processData : false,
                   dataType: "JSON",
                   beforeSend: function() { 
                    $("#restoreBtn").html('<i class="fa fa-refresh"></i> Restoring...');
                    $("#restoreBtn").prop('disabled', true); // disable button
                   },
                   success: function(data)
                   {
                       if(data.status){
                           $("#restoreBtn").html('<i class="fa fa-upload"></i> Restore');
                           $("#restoreBtn").prop('disabled', false); 
                           alert('Restored!');
                       }else{
                           
                           $("#restoreBtn").html('<i class="fa fa-upload"></i> Restore');
                           $("#restoreBtn").prop('disabled', false); 
                           $('#formSetting3')[0].reset();
                           alert(data.error);
                       }
                   }
               });
           }else{
               message("Your Browser Don't support FormData API! Use IE 10 or Above!");
           }
        
    });
    
});

function view_setting(){
    $.ajax({
          
            url : site_url+"pengaturan/view",
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {
                $('#ppn').val(data.ppn);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error deleting data');
            }
            
       });
}