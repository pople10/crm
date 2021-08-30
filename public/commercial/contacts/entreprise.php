<?php 
chdir('..');
chdir('..');
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
    function checkRemiseValidity()
    {
        function isNormalFloat(str) {
            var n = Number(str);
            return n !== Infinity && String(n) === str;
        }
        var remise = $('#remise_input').val();
        if(!isNormalFloat(remise) || parseFloat(remise)>100 || parseFloat(remise)<0 || remise=="")
            return false;
        else
            return true;
    }

        $(document).ready(function () {
            var nomfr_input = $("#nomfr_input");
            var nomar_input = $("#nomar_input");
            var indicationfr_input = $("#indicationfr_input");
            var indicationar_input = $("#indicationar_input");
            var codeice_input = $("#codeice_input");
            var codeif_input = $("#codeif_input");
            var adresse_input = $("#adresse_input");
            var ville_input = $("#ville_input");
            var telephone_input = $("#telephone_input");
            var fax_input = $("#fax_input");
            var image = $("#image");
            var enregistrer = $("#enregistrer_btn");
            var photo = $('#inputuploadimg');
            var remise_input = $('#remise_input'); 
            
            getData = function () {
                $.ajax({
                    url: "../../../controller/EntrepriseController.php",
                    type: 'POST',
                    async: false,
                    data: { },
                    success: function(result) {
                        //console.log(result);
                        var data = result.data;
                        nomar_input.val(data.nom_ar);
                        nomfr_input.val(data.nom_fr);
                        indicationar_input.val(data.indication_ar);
                        indicationfr_input.val(data.indication_fr);
                        codeice_input.val(data.code_ice);
                        codeif_input.val(data.code_if);
                        adresse_input.val(data.adresse);
                        ville_input.val(data.ville);
                        telephone_input.val(data.telephone);
                        fax_input.val(data.fax);
                        remise_input.val(data.remise);
                        image.prop("src","<? echo $serverName; ?>/public/images/"+data.logo)

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
                    data: {op:"updateAllRemises",max:parseFloat(remise_input.val())},
                    success: function(result) {
                        flag=true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                    }
                });
                return flag;
            };
            getData();

            enregistrer.click(function () {
                var r = true;
                $("input").each(function (i,v) {
                    if(!v.checkValidity()){
                        r = false;
                    }
                });
                if(!checkRemiseValidity())
                    r=false;
                if(updateRemise()){
                if(!r)
                    alertify.error("Vous devez remplir les champs correctement");
                else
                {
                    $.ajax({
                        url: "../../../controller/EntrepriseController.php",
                        type: 'POST',
                        async: false,
                        data: { op :"update", nomFr:nomfr_input.val(), nomAr:nomar_input.val(), indicationFr:indicationfr_input.val(), indicationAr:indicationar_input.val(),codeice:codeice_input.val(),codeif:codeif_input.val(), adresse: adresse_input.val(), telephone : telephone_input.val(), fax : fax_input.val(),ville : ville_input.val(),remise : remise_input.val() },
                        success: function(result) {
                            if(typeof(result) == "object" && result.response == true)
                                alertify.success("Modifié avec succès");
                            else
                                alertify.error("Echec de modification");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            alertify.error("Opération annulée");
                        }
                    });
                }}
                else
                    alertify.error("Les clients ne peuvent pas être modifiés selon le remise maximal");
            });

            photo.change(function () {
                if (photo[0].files.length == 1) {
                    var filename = photo[0].files[0].name;
                    var extention = filename.split('.')[filename.split('.').length - 1];
                    var extentions = Array('jpg', 'png', 'jpeg');
                    if (extentions.includes(extention.toLowerCase()))
                    {
                        var fd = new FormData();
                        fd.append('file', photo[0].files[0]);
                        fd.append('reference', 'entreprise');
                        $.ajax({
                            url: '../../../controller/Upload.php',
                            type: 'post',
                            data: fd,
                            contentType: false,
                            processData: false,
                            dataType: "text",
                            async: false,
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
                            }
                        });
                    } else {
                        alertify.error('La photo doit être sous format "jpg","png" ou "jpeg" ');
                    }
                }
            });
            var updatedimg = function (filename) {
                $.ajax({
                    url: '../../../controller/EntrepriseController.php',
                    async: false,
                    method: 'POST',
                    data: {op: 'updateLogo', logo: filename},
                    success: function (data, textStatus, jqXHR) {
                        if (typeof(data) == "object" && data.response == true)
                            {
                                image.prop("src","<? echo $serverName; ?>/public/images/"+filename);
                                alertify.success("Image changée avec succès");
                            }
                        else
                            alertify.error("Impossible de charger l'image!");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(textStatus);
                        alertify.error("Impossible de charger l'image!");
                    }
                });
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
                            <li class="breadcrumb-item"><a href="<?php echo __CONTACTSFOLDER__;?>">Contacts</a></li>
                            <li class="breadcrumb-item active">Entreprise</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Entreprise</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body row">

                        <div class="col-md-3 d-flex align-items-center justify-content-center">
                            <div class="uploadimgsection mb-3">
                                <label for="inputuploadimg" title="Changer l'image" class="uploadimg text-center"><i class="fas fa-camera"></i></label>
                                <img id="image" src="<? echo $serverName; ?>/public/images/no-photo.png" style="width: 200px;" class="imgsection img-fluid content-center">
                                <input id="inputuploadimg" name="file" type="file" hidden>
                            </div>
                        </div>
                        <div class="col-md-9 p-5">
                            <div class="form-group row">
                                <label for="nomfr_input"
                                       class="col-md-3 col-sm-3 col-form-label">Nom en français</label>
                                <div class="col-md-3 col-sm-9 ">
                                    <input class="form-control form-control-sm  mr-1" type="text" value=""
                                           id="nomfr_input" name="nomfr_input">
                                </div>
                                <label for="nomar_input"
                                       class="col-md-3 col-sm-3 col-form-label">Nom en arabe</label>
                                <div class="col-md-3 col-sm-9">
                                    <input class="form-control form-control-sm  mr-1" type="text" value=""
                                           id="nomar_input" name="nomar_input">  <!--
                                           pattern="^[ء-ي0-9]+$"
                                           onchange="this.value =='' ? delete_err($(this)) : /^[ء-ي0-9]+$/.test(this.value)? delete_err($(this)):add_err($(this),'Ce champ doit être en arabe')"
                                           -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="indicationfr_input"
                                       class="col-md-3 col-sm-3 col-form-label">Indication en français</label>
                                <div class="col-md-3 col-sm-9">
                                    <input class="form-control form-control-sm  mr-1" type="text" value=""
                                           id="indicationfr_input" name="indicationfr_input">
                                </div>
                                <label for="indicationar_input"
                                       class="col-md-3 col-sm-3 col-form-label">Indication en arabe</label>
                                <div class="col-md-3 col-sm-9">
                                    <input class="form-control form-control-sm  mr-1" type="text" value=""
                                           id="indicationar_input" name="indicationar_input"> <!--
                                           pattern="^[ء-ي0-9]+$"
                                           onchange="this.value =='' ? delete_err($(this)) : /^[ء-ي0-9]+$/.test(this.value)? delete_err($(this)):add_err($(this),'Ce champ doit être en arabe')"
                                           -->
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="codeice_input"
                                       class="col-md-3 col-sm-3 col-form-label">Code ICE</label>
                                <div class="col-md-3 col-sm-9">
                                    <input class="form-control form-control-sm  mr-1" type="text" value=""
                                           id="codeice_input" name="codeice_input">
                                </div>
                                <label for="codeif_input"
                                       class="col-md-3 col-sm-3 col-form-label">Code IF</label>
                                <div class="col-md-3 col-sm-9">
                                    <input class="form-control form-control-sm  mr-1" type="text" value=""
                                           id="codeif_input" name="codeif_input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="adresse_input"
                                       class="col-md-3 col-sm-3 col-form-label">Adresse</label>
                                <div class="col-md-3 col-sm-9">
                                    <input class="form-control form-control-sm  mr-1" type="text" value=""
                                           id="adresse_input" name="adresse_input">
                                </div>
                                <label for="ville_input"
                                       class="col-md-3 col-sm-3 col-form-label">Ville</label>
                                <div class="col-md-3 col-sm-9">
                                    <input class="form-control form-control-sm  mr-1" type="text" value=""
                                           id="ville_input" name="ville_input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="telephone_input"
                                       class="col-sm-3 col-form-label">Telephone</label>
                                <div class="col-sm-3">
                                    <input class="form-control form-control-sm  mr-1" type="tel" value="" pattern="(\+212|0)([ \-_/]*)(\d[ \-_/]*){9}" id="telephone_input" name="telephone_input"
                                           onchange="this.value =='' ? delete_err($(this)) : /(\+212|0)([ \-_/]*)(\d[ \-_/]*){9}$/.test(this.value)? delete_err($(this)):add_err($(this),'Ce champ doit être un numero de telephone')">
                                </div>
                                <label for="remise_input"
                                       class="col-sm-3 col-form-label">Remise Maximal (en %)</label>
                                <div class="col-sm-3">
                                    <input class="form-control form-control-sm  mr-1" type="number"  min="0" max="100" step="0.1" value="" id="remise_input" name="remise_input">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="fax_input"
                                       class="col-sm-3 col-form-label">Fax</label>
                                <div class="col-sm-3">
                                    <input class="form-control form-control-sm  mr-1" type="tel" value="" pattern="(\+212|0)([ \-_/]*)(\d[ \-_/]*){9}" id="fax_input" name="fax_input"
                                           onchange="this.value =='' ? delete_err($(this)) : /(\+212|0)([ \-_/]*)(\d[ \-_/]*){9}$/.test(this.value)? delete_err($(this)):add_err($(this),'Ce champ doit être un numero fax')">
                                </div>
                            </div>
                            <div class="">
                                <button id="enregistrer_btn" class="btn btn-primary btn-sm ml-2 float-right"><i class="mdi mdi-content-save"></i>Enregistrer</button>
                                <button  class="btn btn-warning btn-sm float-right" onclick="getData()"><iclass="mdi mdi-close"></i>Annuler</button>
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