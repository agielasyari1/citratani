
$(document).ready(function (){
    
     $.ajax({
                url : site_url+"pengguna/foto" ,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    var src;
                    $("#profilPict").attr('src',base_url+data.photo);
                }
            });
    
    
    $('#profilForm').formValidation({
           icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
                validating: 'glyphicon glyphicon-refresh'
            },
            fields: {
            nama: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        regexp: {
                            regexp: /^[a-z\s]+$/i,
                            message: 'The full name can consist of alphabetical characters and spaces only'
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
                },
            password: {
                    row: '.col-sm-9',
                    validators: {
                        notEmpty: {
                            message: 'Mohon diisi'
                        },
                        stringLength: {
                            min: 6,
                            message: 'The password must be at least 6 characters'
                        }
                    }
                }
            }
        });
        
        var fv =  $('#profilForm').data('formValidation');
    
    
    $("#updateBtn").click(function (){
        fv.validate();
            if(fv.isValid()){
                $.ajax({
                    url : site_url+"profil/update",
                    type: "POST",
                    data: $("#profilForm").serialize(),
                    dataType: "JSON",
                    success: function(data)
                    {
                        if(data.status){
                            alert("saved");
                            $('#hnama').text($('#nama').val());
                            $('#halamat').text($('#alamat').val());
                            $('#hno_telp').text($('#no_telp').val());
                        }else{
                            alert('Fail');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown)
                    {
                        alert('Error deleting data');
                    }
                });
                
            }else{
                alert('Not Valid');
            }
        
    });
    
    $("#changeBtn").click(function (){
       $('#exampleModal').modal('show'); 
    });
    
    
    $("#saveBtn").click(function (){
       
         if (typeof FormData !== 'undefined') {

                var formData = new FormData( $("#addUserForm")[0]);
            
            $.ajax({
                   url : site_url+"profil/ubah_foto" ,
                   type: "POST",
                   data : formData,
                   cache : false,
                   contentType : false,
                   processData : false,
                   dataType: "JSON",
                   success: function(data)
                   {
                       if(data.status){
                           $('#modal-form').modal('hide');
                           window.location = site_url+"profil";
                       }else{
                           alert(data.error);
                       }
                   }
               });
           }else{
               message("Your Browser Don't support FormData API! Use IE 10 or Above!");
           }
       
        
        
    });
    
    
});
