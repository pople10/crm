<?php 
include_once './template/header.php';
?>


<script>

    var delete_err = function(element) {
        element.removeClass("parsley-error");
        element.parent().find(".parsley-errors-list").remove();
    }
        var add_err = function(element, msg) {
            delete_err(element)
            var e = '<ul class="parsley-errors-list filled" id="' + element.prop("id") + '-error"><li class="">' + msg + '</li></ul>';
            element.addClass("parsley-error");
            element.parent().append(e);

        }

        $(document).ready(function () {
            var nom_input = $("#nom_input");
            var prenom_input = $("#prenom_input");
            var email_input = $("#email_input");
            var old_password_input = $("#old_password_input");
            var new_password_input = $("#new_password_input");
            var conf_password_input = $('#conf_password_input'); 
            var telephone_input = $("#telephone_input");
            var image = $("#image");
            var enregistrer = $("#enregistrer_btn");
            var changermdp_btn = $("#changermdp_btn");
            var photo = $('#inputuploadimg');
            
            getData = function () {
                $.ajax({
                    url: "../../../controller/UserController.php",
                    type: 'POST',
                    async: false,
                    data: { op : "currentUser" },
                    success: function(result) {
                        //console.log(result);
                        var data = result;
                        var photo = data.photo || "no-photo.png";
                        prenom_input.val(data.prenom);
                        nom_input.val(data.nom);
                        email_input.val(data.email);
                        telephone_input.val(data.telephone);
                        image.prop("src","<? echo $serverName; ?>/public/images/"+photo);
                        
                        $("#infoTab input").each(function (i,v) {
                                        delete_err($(v));
                                     });

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        alertify.error("Opération annulée");
                    }
                });
            };
            updateRemise = function () {var flag=false;
                $.ajax({
                    url: "../../../controller/ClientController.php",
                    type: 'POST',
                    async: false,
                    data: {op:"updateAllRemises",max:parseFloat(conf_password_input.val())},
                    success: function(result) {
                        flag=true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    }
                });
                return flag;
            };
            getData();
            changermdp_btn.click(function () {
                var r = true;
                $("#passwordTab input").each(function (i,v) {
                    //v.oninput();
                    if(!v.checkValidity() || v.value == ""){
                        r = false;
                    }
                });
                
                if(new_password_input.val() != conf_password_input.val())
                    r = false;
                
                if(!r)
                    alertify.error("Vous devez remplir les champs correctement");
                else
                {
                    $.ajax({
                        url: "../../../controller/UserController.php",
                        type: 'POST',
                        async: false,
                        data: { op :"updatePassword", old_password:old_password_input.val(), new_password:new_password_input.val()},
                        success: function(result) {
                            if(typeof(result) == "object" && result.response == true)
                                {
                                    
                                    $("#passwordTab input").each(function (i,v) {
                                        delete_err($(v));
                                     });
                                    alertify.success("Modifié avec succès");
                                    $('#passwordTab input').val('');
                                }else if (typeof(result) == "object" && result.response == false)
                                    alertify.error(result.message);
                            else
                                alertify.error("Echec de modification");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alertify.error("Opération annulée");
                        }
                    });
                }
            });
            enregistrer.click(function () {
                var r = true;
                $("#infoTab input").each(function (i,v) {
                    if(!v.checkValidity()){
                        r = false;
                    }
                });
                
                if(emailExists())
                    r = false;
                
                if(!r)
                    alertify.error("Vous devez remplir les champs correctement");
                else
                {
                    $.ajax({
                        url: "../../../controller/UserController.php",
                        type: 'POST',
                        async: false,
                        data: { op :"updateCurrentUser", nom:nom_input.val(), prenom:prenom_input.val(), email:email_input.val(), telephone : telephone_input.val()},
                        success: function(result) {
                            if(typeof(result) == "object" && result.response == true)
                                {
                                    $("#infoTab input").each(function (i,v) {
                                        delete_err($(v));
                                     });
                                    alertify.success("Modifié avec succès");
                                }
                            else
                                alertify.error("Echec de modification");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alertify.error("Opération annulée");
                        }
                    });
                }
            });

            $(document).delegate('#inputuploadimg', 'change',function () {
                if (photo[0].files.length == 1) {
                    var filename = photo[0].files[0].name;
                    var extention = filename.split('.')[filename.split('.').length - 1];
                    var extentions = Array('jpg', 'png', 'jpeg');
                    if (extentions.includes(extention.toLowerCase()))
                    {
                        var fd = new FormData();
                        fd.append('file', photo[0].files[0]);
                        fd.append('reference', 'user');
                        $.ajax({
                            url: '../../../controller/Upload.php',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            dataType: "text",
                            async: true,
                            success: function (data, textStatus, jqXHR) {
                                if (data == 0 || data == 1)
                                {
                                    alertify.error("Impossible de charger l'image!");
                                }
                                else
                                    updatedimg(data)
                            },
                            error: function (jqXHR, textStatus, errorThrown) {
                                alertify.error("Impossible de charger l'image!");
                                console.log(textStatus);
                            },
                            beforeSend: function(){
                             $('.uploadimg').addClass("show");
                            },
                            complete: function(){
                             $('.uploadimg').removeClass("show");
                            }
                        });
                    } else {
                        alertify.error('La photo doit être sous format "jpg","png" ou "jpeg" ');
                    }
                }
            });
            var updatedimg = function (filename) {
                $.ajax({
                    url: '../../../controller/UserController.php',
                    async: true,
                    method: 'POST',
                    data: {op: 'updatePhoto', photo: filename},
                    success: function (data, textStatus, jqXHR) {
                        if (typeof(data) == "object" && data.response == true)
                            {
                                image.prop("src","<? echo $serverName; ?>/public/images/"+filename);
                                $("#nav_user_img").prop("src","<? echo $serverName; ?>/public/images/"+filename);
                                alertify.success("Image changée avec succès");
                            }
                        else
                            alertify.error("Impossible de charger l'image!");
                            $('.uploadimg').removeClass("show");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                        alertify.error("Impossible de charger l'image!");
                        $('.uploadimg').removeClass("show");
                    },
                    beforeSend: function(){
                     $('.uploadimg').addClass("show");
        
                    },
                    complete: function(){
                     $('.uploadimg').removeClass("show");
                    }
                });
            }
            emailExists = function () {
                var r = true;
                $.ajax({
                    url: '../../../controller/UserController.php',
                    async: false,
                    method: 'POST',
                    data: {op: 'emailExists', email: email_input.val()},
                    success: function (data, textStatus, jqXHR) {
                        if (typeof(data) == "boolean")
                            r = data;
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                        alertify.error("Erreur de connexion");
                    }
                });
                return r;
            }
        });

</script>

<div class="wrapper mt-md-5 mt-sm-1">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo __PUBLICFOLDER__;?>">CRM</a></li>
                            <li class="breadcrumb-item active">Mon Profil</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Mon Profil</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body row">

                        <div class="col-md-3 d--flex align-items-center justify-content-center" style="display:grid;">
                            <div class="uploadimgsection">
                                <label for="inputuploadimg" title="Changer l'image" class="uploadimg text-center"><i class="fas fa-camera"></i>
                                <i class="loading" style="background-image: url(./style/spinner.gif);width: 33px;height: 33px;display: none;" =""></i></label>
                                <img id="image" src="<? echo $serverName; ?>/public/images/no-photo.png" style="width: 200px;" class="imgsection img-fluid content-center">
                                <input id="inputuploadimg" name="file" type="file" hidden>
                            </div>
                        </div>
                        <div class="col-md-9 p-5">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                              <li class="nav-item">
                                <a class="nav-link active" id="info-tab" data-toggle="tab" href="#infoTab" role="tab" aria-controls="infoTab" aria-selected="true">Informations personnelles</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="password-tab" data-toggle="tab" href="#passwordTab" role="tab" aria-controls="passwordTab" aria-selected="false">Changer mot de passe</a>
                              </li>
                            </ul>
                            <div class="tab-content py-3" id="myTabContent">
                                <div class="tab-pane fade container-fluid show active" id="infoTab" role="tabpanel" aria-labelledby="info-tab">
                                      <div class="form-group row">
                                        <label for="nom_input"
                                               class="col-md-3 col-sm-3 col-form-label">Nom</label>
                                        <div class="col-md-3 col-sm-9 ">
                                            <input class="form-control form-control-sm  mr-1" type="text" value=""
                                                   id="nom_input" name="nom_input" required>
                                        </div>
                                        <label for="prenom_input"
                                               class="col-md-3 col-sm-3 col-form-label">Prenom</label>
                                        <div class="col-md-3 col-sm-9">
                                            <input class="form-control form-control-sm  mr-1" type="text" value=""
                                                   id="prenom_input" name="prenom_input" required>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="email_input"
                                               class="col-md-3 col-sm-3 col-form-label">Email</label>
                                        <div class="col-md-3 col-sm-9">
                                            <input class="form-control form-control-sm  mr-1" type="email" value=""
                                                   id="email_input" name="email_input" required
                                                   onchange="this.value =='' ? delete_err($(this)) : !emailExists()? delete_err($(this)):add_err($(this),'Email deja existant')">
                                        </div>
                                        <label for="telephone_input"
                                               class="col-sm-3 col-form-label">Telephone</label>
                                        <div class="col-sm-3">
                                            <input class="form-control form-control-sm  mr-1" type="tel" value="" pattern="(\+212|0)([ \-_/]*)(\d[ \-_/]*){9}" id="telephone_input" name="telephone_input"
                                                   onchange="this.value =='' ? delete_err($(this)) : /(\+212|0)([ \-_/]*)(\d[ \-_/]*){9}$/.test(this.value)? delete_err($(this)):add_err($(this),'Ce champ doit être un numero de telephone')">
                                        </div>
                                    </div>
                                    <div class="">
                                        <button id="enregistrer_btn" class="btn btn-primary btn-sm ml-2 float-right"><i class="mdi mdi-content-save"></i>Enregistrer</button>
                                        <button  class="btn btn-warning btn-sm float-right" onclick="getData()"><iclass="mdi mdi-close"></i>Annuler</button>
                                    </div>
                                </div>
                                <div class="tab-pane fade container-fluid" id="passwordTab" role="tabpanel" aria-labelledby="password-tab">
                                      <div class="form-group row">
                                        <label for="old_password_input"
                                               class="col-md-3 col-sm-3 col-form-label">Mot de passe actuel</label>
                                        <div class="col-md-9 col-sm-9">
                                            <input class="form-control form-control-sm  mr-1" type="password" value=""
                                                   id="old_password_input" name="old_password_input_input"
                                                   onchange="this.value != '' ? delete_err($(this)) : add_err($(this),'Vous devez remplir ce champ.')">
                                        </div>
                                        <label for="new_password_input"
                                               class="col-md-3 col-sm-3 col-form-label">Nouveau mot de passe</label>
                                        <div class="col-md-3 col-sm-9">
                                            <input class="form-control form-control-sm  mr-1" type="password" value=""
                                                   id="new_password_input" name="new_password_input"
                                                   oninput="this.value == '' ? add_err($(this),'Vous devez remplir ce champ.') : this.value == $('#conf_password_input').val() ? (delete_err($('#conf_password_input')), delete_err($(this))) : (add_err($('#conf_password_input'),'La confirmation ne correspond pas au nouveau mot de passe'), delete_err($(this)))">
                                        </div>
                                        <label for="conf_password_input"
                                               class="col-md-3 col-sm-3 col-form-label">Confirmer le mot de passe</label>
                                        <div class="col-md-3 col-sm-9">
                                            <input class="form-control form-control-sm  mr-1" type="password" value=""
                                                id="conf_password_input" name="conf_password_input"
                                                oninput="this.value == '' ? add_err($(this),'Vous devez remplir ce champ.') : this.value == $('#new_password_input').val() ? delete_err($(this)) : add_err($(this),'La confirmation ne correspond pas au nouveau mot de passe')">
                                        </div>
                                    </div>
                                    <div class="">
                                        <button id="changermdp_btn" class="btn btn-primary btn-sm ml-2 float-right"><i class="mdi mdi-content-save"></i>Enregistrer</button>
                                        <button  class="btn btn-warning btn-sm float-right" onclick="$('#passwordTab input').val('');delete_err($('#passwordTab input'))"><iclass="mdi mdi-close"></i>Annuler</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div> <!-- end container -->
</div>
<!-- end wrapper -->


<!-- Footer -->
<?php 
    include_once './template/footer.php';
?>
