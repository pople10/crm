<?php 
chdir('..');
chdir('..');
include_once './template/header.php';

?>


<div class="wrapper">
    <div class="container-fluid">

        <!-- Page-Title -->
        <div class="row">
            <div class="col-sm-12">
                <div class="page-title-box">
                    <div class="btn-group pull-right">
                        <ol class="breadcrumb hide-phone p-0 m-0">
                            <li class="breadcrumb-item"><a href="<?php echo __CONTACTSFOLDER__; ?>">Contacts</a></li>
                            <li class="breadcrumb-item active">Clients</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Clients</h4>
                </div>
            </div>
        </div>
        <!-- end page title end breadcrumb -->
        <div class="row section1">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <button id="nouveau_btn" class="btn btn-success btn-sm" role="button"><i
                                class="mdi mdi-account-plus"></i> Nouveau</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row section2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <form>
                            <div class="form-row">
                                <div class="col-md-8">
                                    <div class="form-group row">
                                        <label class="col-md-3 my-1 control-label">Type</label>
                                        <div class="col-md-9">
                                            <div class="form-check-inline my-1">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="societe_radio" name="customRadio"
                                                        class="custom-control-input" value="Société" checked>
                                                    <label class="custom-control-label"
                                                        for="societe_radio">Société</label>
                                                </div>
                                            </div>
                                            <div class="form-check-inline my-1">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" id="particulier_radio" name="customRadio"
                                                        class="custom-control-input" value="Particulier">
                                                    <label class="custom-control-label"
                                                        for="particulier_radio">Particulier</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group row" id="societe_section">
                                        <label for="noms_input" class="col-sm-2 col-form-label">Nom</label>
                                        <div class="col-sm-10">
                                            <input class="form-control form-control-sm" type="text" value=""
                                                id="noms_input" name="noms_input">
                                        </div>
                                    </div>
                                    <div class="form-group row" id="personne_section" style="display:none;">
                                        <label for="civilite_input" class="col-sm-2 col-form-label">Civilité</label>
                                        <div class="col-sm-2">
                                            <select id="civilite_select" name="civilite_select"
                                                class="form-control form-control-sm custom-select">
                                                <option hidden>Choisir</option>
                                                <option value="1">M.</option>
                                                <option value="2">Mlle</option>
                                                <option value="3">Mme</option>
                                            </select>
                                        </div>
                                        <label for="prenom_input" class="col-sm-2 col-form-label">Prénom</label>
                                        <div class="col-sm-2">
                                            <input class="form-control form-control-sm" type="text" value=""
                                                id="prenom_input" name="prenom_input">
                                        </div>
                                        <label for="nom_input" class="col-sm-2 col-form-label">Nom</label>
                                        <div class="col-sm-2">
                                            <input class="form-control form-control-sm" type="text" value=""
                                                id="nom_input" name="nom_input">
                                        </div>
                                    </div>
                                    <div class="form-row">
                                        <div class="col-md-6">
                                            <h6>Adresse de facturation</h6>
                                            <div class="form-group row">
                                                <label for="adresse1_input"
                                                    class="col-sm-4 col-form-label">Adresse</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm mb-2" type="text"
                                                        value="" id="adresse1_input" name="adresse1_input">
                                                    <input class="form-control form-control-sm" type="text" value=""
                                                        id="adresse2_input" name="adresse2_input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="cp_input" class="col-sm-4 col-form-label">CP -
                                                    Ville</label>
                                                <div class="col-sm-8 d-flex">
                                                    <input class="form-control form-control-sm  mr-1" type="number"
                                                        value="" id="cp_input" name="cp_input">
                                                    <input class="form-control form-control-sm  mr-1" type="text"
                                                        value="" id="ville_input" name="ville_input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="pays_select" class="col-sm-4 col-form-label">Pays</label>
                                                <div class="col-sm-8">
                                                    <select id="pays_select" name="pays_select"
                                                        class="form-control form-control-sm custom-select">
                                                        <option hidden>Choisir</option>
                                                        <optgroup label="A">
                                                            <option value="AF">Afghanistan</option>
                                                            <option value="AX">Åland Islands</option>
                                                            <option value="AL">Albania</option>
                                                            <option value="DZ">Algeria</option>
                                                            <option value="AS">American Samoa</option>
                                                            <option value="AD">Andorra</option>
                                                            <option value="AO">Angola</option>
                                                            <option value="AI">Anguilla</option>
                                                            <option value="AQ">Antarctica</option>
                                                            <option value="AG">Antigua and Barbuda</option>
                                                            <option value="AR">Argentina</option>
                                                            <option value="AM">Armenia</option>
                                                            <option value="AW">Aruba</option>
                                                            <option value="AU">Australia</option>
                                                            <option value="AT">Austria</option>
                                                            <option value="AZ">Azerbaijan</option>
                                                        </optgroup>
                                                        <optgroup label="B">
                                                            <option value="BS">Bahamas</option>
                                                            <option value="BH">Bahrain</option>
                                                            <option value="BD">Bangladesh</option>
                                                            <option value="BB">Barbados</option>
                                                            <option value="BY">Belarus</option>
                                                            <option value="BE">Belgium</option>
                                                            <option value="BZ">Belize</option>
                                                            <option value="BJ">Benin</option>
                                                            <option value="BM">Bermuda</option>
                                                            <option value="BT">Bhutan</option>
                                                            <option value="BO">Bolivia, Plurinational State of
                                                            </option>
                                                            <option value="BQ">Bonaire, Sint Eustatius and Saba
                                                            </option>
                                                            <option value="BA">Bosnia and Herzegovina</option>
                                                            <option value="BW">Botswana</option>
                                                            <option value="BV">Bouvet Island</option>
                                                            <option value="BR">Brazil</option>
                                                            <option value="IO">British Indian Ocean Territory
                                                            </option>
                                                            <option value="BN">Brunei Darussalam</option>
                                                            <option value="BG">Bulgaria</option>
                                                            <option value="BF">Burkina Faso</option>
                                                            <option value="BI">Burundi</option>
                                                        </optgroup>
                                                        <optgroup label="C">
                                                            <option value="KH">Cambodia</option>
                                                            <option value="CM">Cameroon</option>
                                                            <option value="CA">Canada</option>
                                                            <option value="CV">Cape Verde</option>
                                                            <option value="KY">Cayman Islands</option>
                                                            <option value="CF">Central African Republic</option>
                                                            <option value="TD">Chad</option>
                                                            <option value="CL">Chile</option>
                                                            <option value="CN">China</option>
                                                            <option value="CX">Christmas Island</option>
                                                            <option value="CC">Cocos (Keeling) Islands</option>
                                                            <option value="CO">Colombia</option>
                                                            <option value="KM">Comoros</option>
                                                            <option value="CG">Congo</option>
                                                            <option value="CD">Congo, the Democratic Republic of
                                                                the
                                                            </option>
                                                            <option value="CK">Cook Islands</option>
                                                            <option value="CR">Costa Rica</option>
                                                            <option value="CI">Côte d'Ivoire</option>
                                                            <option value="HR">Croatia</option>
                                                            <option value="CU">Cuba</option>
                                                            <option value="CW">Curaçao</option>
                                                            <option value="CY">Cyprus</option>
                                                            <option value="CZ">Czech Republic</option>
                                                        </optgroup>
                                                        <optgroup label="D">
                                                            <option value="DK">Denmark</option>
                                                            <option value="DJ">Djibouti</option>
                                                            <option value="DM">Dominica</option>
                                                            <option value="DO">Dominican Republic</option>
                                                        </optgroup>
                                                        <optgroup label="E">
                                                            <option value="EC">Ecuador</option>
                                                            <option value="EG">Egypt</option>
                                                            <option value="SV">El Salvador</option>
                                                            <option value="GQ">Equatorial Guinea</option>
                                                            <option value="ER">Eritrea</option>
                                                            <option value="EE">Estonia</option>
                                                            <option value="ET">Ethiopia</option>
                                                        </optgroup>
                                                        <optgroup label="F">
                                                            <option value="FK">Falkland Islands (Malvinas)
                                                            </option>
                                                            <option value="FO">Faroe Islands</option>
                                                            <option value="FJ">Fiji</option>
                                                            <option value="FI">Finland</option>
                                                            <option value="FR">France</option>
                                                            <option value="GF">French Guiana</option>
                                                            <option value="PF">French Polynesia</option>
                                                            <option value="TF">French Southern Territories
                                                            </option>
                                                        </optgroup>
                                                        <optgroup label="G">
                                                            <option value="GA">Gabon</option>
                                                            <option value="GM">Gambia</option>
                                                            <option value="GE">Georgia</option>
                                                            <option value="DE">Germany</option>
                                                            <option value="GH">Ghana</option>
                                                            <option value="GI">Gibraltar</option>
                                                            <option value="GR">Greece</option>
                                                            <option value="GL">Greenland</option>
                                                            <option value="GD">Grenada</option>
                                                            <option value="GP">Guadeloupe</option>
                                                            <option value="GU">Guam</option>
                                                            <option value="GT">Guatemala</option>
                                                            <option value="GG">Guernsey</option>
                                                            <option value="GN">Guinea</option>
                                                            <option value="GW">Guinea-Bissau</option>
                                                            <option value="GY">Guyana</option>
                                                        </optgroup>
                                                        <optgroup label="H">
                                                            <option value="HT">Haiti</option>
                                                            <option value="HM">Heard Island and McDonald Islands
                                                            </option>
                                                            <option value="VA">Holy See (Vatican City State)
                                                            </option>
                                                            <option value="HN">Honduras</option>
                                                            <option value="HK">Hong Kong</option>
                                                            <option value="HU">Hungary</option>
                                                        </optgroup>
                                                        <optgroup label="I">
                                                            <option value="IS">Iceland</option>
                                                            <option value="IN">India</option>
                                                            <option value="ID">Indonesia</option>
                                                            <option value="IR">Iran, Islamic Republic of
                                                            </option>
                                                            <option value="IQ">Iraq</option>
                                                            <option value="IE">Ireland</option>
                                                            <option value="IM">Isle of Man</option>
                                                            <option value="IL">Israel</option>
                                                            <option value="IT">Italy</option>
                                                        </optgroup>
                                                        <optgroup label="J">
                                                            <option value="JM">Jamaica</option>
                                                            <option value="JP">Japan</option>
                                                            <option value="JE">Jersey</option>
                                                            <option value="JO">Jordan</option>
                                                        </optgroup>
                                                        <optgroup label="K">
                                                            <option value="KZ">Kazakhstan</option>
                                                            <option value="KE">Kenya</option>
                                                            <option value="KI">Kiribati</option>
                                                            <option value="KP">Korea, Democratic People's
                                                                Republic
                                                                of
                                                            </option>
                                                            <option value="KR">Korea, Republic of</option>
                                                            <option value="KW">Kuwait</option>
                                                            <option value="KG">Kyrgyzstan</option>
                                                        </optgroup>
                                                        <optgroup label="L">
                                                            <option value="LA">Lao People's Democratic Republic
                                                            </option>
                                                            <option value="LV">Latvia</option>
                                                            <option value="LB">Lebanon</option>
                                                            <option value="LS">Lesotho</option>
                                                            <option value="LR">Liberia</option>
                                                            <option value="LY">Libya</option>
                                                            <option value="LI">Liechtenstein</option>
                                                            <option value="LT">Lithuania</option>
                                                            <option value="LU">Luxembourg</option>
                                                        </optgroup>
                                                        <optgroup label="M">
                                                            <option value="MO">Macao</option>
                                                            <option value="MK">Macedonia, the former Yugoslav
                                                                Republic
                                                                of</option>
                                                            <option value="MG">Madagascar</option>
                                                            <option value="MW">Malawi</option>
                                                            <option value="MY">Malaysia</option>
                                                            <option value="MV">Maldives</option>
                                                            <option value="ML">Mali</option>
                                                            <option value="MT">Malta</option>
                                                            <option value="MH">Marshall Islands</option>
                                                            <option value="MQ">Martinique</option>
                                                            <option value="MR">Mauritania</option>
                                                            <option value="MU">Mauritius</option>
                                                            <option value="YT">Mayotte</option>
                                                            <option value="MX">Mexico</option>
                                                            <option value="FM">Micronesia, Federated States of
                                                            </option>
                                                            <option value="MD">Moldova, Republic of</option>
                                                            <option value="MC">Monaco</option>
                                                            <option value="MN">Mongolia</option>
                                                            <option value="ME">Montenegro</option>
                                                            <option value="MS">Montserrat</option>
                                                            <option value="MA">Morocco</option>
                                                            <option value="MZ">Mozambique</option>
                                                            <option value="MM">Myanmar</option>
                                                        </optgroup>
                                                        <optgroup label="N">
                                                            <option value="NA">Namibia</option>
                                                            <option value="NR">Nauru</option>
                                                            <option value="NP">Nepal</option>
                                                            <option value="NL">Netherlands</option>
                                                            <option value="NC">New Caledonia</option>
                                                            <option value="NZ">New Zealand</option>
                                                            <option value="NI">Nicaragua</option>
                                                            <option value="NE">Niger</option>
                                                            <option value="NG">Nigeria</option>
                                                            <option value="NU">Niue</option>
                                                            <option value="NF">Norfolk Island</option>
                                                            <option value="MP">Northern Mariana Islands</option>
                                                            <option value="NO">Norway</option>
                                                        </optgroup>
                                                        <optgroup label="O">
                                                            <option value="OM">Oman</option>
                                                        </optgroup>
                                                        <optgroup label="P">
                                                            <option value="PK">Pakistan</option>
                                                            <option value="PW">Palau</option>
                                                            <option value="PS">Palestinian Territory, Occupied
                                                            </option>
                                                            <option value="PA">Panama</option>
                                                            <option value="PG">Papua New Guinea</option>
                                                            <option value="PY">Paraguay</option>
                                                            <option value="PE">Peru</option>
                                                            <option value="PH">Philippines</option>
                                                            <option value="PN">Pitcairn</option>
                                                            <option value="PL">Poland</option>
                                                            <option value="PT">Portugal</option>
                                                            <option value="PR">Puerto Rico</option>
                                                        </optgroup>
                                                        <optgroup label="Q">
                                                            <option value="QA">Qatar</option>
                                                        </optgroup>
                                                        <optgroup label="R">
                                                            <option value="RE">Réunion</option>
                                                            <option value="RO">Romania</option>
                                                            <option value="RU">Russian Federation</option>
                                                            <option value="RW">Rwanda</option>
                                                        </optgroup>
                                                        <optgroup label="S">
                                                            <option value="BL">Saint Barthélemy</option>
                                                            <option value="SH">Saint Helena, Ascension and
                                                                Tristan
                                                                da
                                                                Cunha</option>
                                                            <option value="KN">Saint Kitts and Nevis</option>
                                                            <option value="LC">Saint Lucia</option>
                                                            <option value="MF">Saint Martin (French part)
                                                            </option>
                                                            <option value="PM">Saint Pierre and Miquelon
                                                            </option>
                                                            <option value="VC">Saint Vincent and the Grenadines
                                                            </option>
                                                            <option value="WS">Samoa</option>
                                                            <option value="SM">San Marino</option>
                                                            <option value="ST">Sao Tome and Principe</option>
                                                            <option value="SA">Saudi Arabia</option>
                                                            <option value="SN">Senegal</option>
                                                            <option value="RS">Serbia</option>
                                                            <option value="SC">Seychelles</option>
                                                            <option value="SL">Sierra Leone</option>
                                                            <option value="SG">Singapore</option>
                                                            <option value="SX">Sint Maarten (Dutch part)
                                                            </option>
                                                            <option value="SK">Slovakia</option>
                                                            <option value="SI">Slovenia</option>
                                                            <option value="SB">Solomon Islands</option>
                                                            <option value="SO">Somalia</option>
                                                            <option value="ZA">South Africa</option>
                                                            <option value="GS">South Georgia and the South
                                                                Sandwich
                                                                Islands</option>
                                                            <option value="SS">South Sudan</option>
                                                            <option value="ES">Spain</option>
                                                            <option value="LK">Sri Lanka</option>
                                                            <option value="SD">Sudan</option>
                                                            <option value="SR">Suriname</option>
                                                            <option value="SJ">Svalbard and Jan Mayen</option>
                                                            <option value="SZ">Swaziland</option>
                                                            <option value="SE">Sweden</option>
                                                            <option value="CH">Switzerland</option>
                                                            <option value="SY">Syrian Arab Republic</option>
                                                        </optgroup>
                                                        <optgroup label="T">
                                                            <option value="TW">Taiwan, Province of China
                                                            </option>
                                                            <option value="TJ">Tajikistan</option>
                                                            <option value="TZ">Tanzania, United Republic of
                                                            </option>
                                                            <option value="TH">Thailand</option>
                                                            <option value="TL">Timor-Leste</option>
                                                            <option value="TG">Togo</option>
                                                            <option value="TK">Tokelau</option>
                                                            <option value="TO">Tonga</option>
                                                            <option value="TT">Trinidad and Tobago</option>
                                                            <option value="TN">Tunisia</option>
                                                            <option value="TR">Turkey</option>
                                                            <option value="TM">Turkmenistan</option>
                                                            <option value="TC">Turks and Caicos Islands</option>
                                                            <option value="TV">Tuvalu</option>
                                                        </optgroup>
                                                        <optgroup label="U">
                                                            <option value="UG">Uganda</option>
                                                            <option value="UA">Ukraine</option>
                                                            <option value="AE">United Arab Emirates</option>
                                                            <option value="GB">United Kingdom</option>
                                                            <option value="US">United States</option>
                                                            <option value="UM">United States Minor Outlying
                                                                Islands
                                                            </option>
                                                            <option value="UY">Uruguay</option>
                                                            <option value="UZ">Uzbekistan</option>
                                                        </optgroup>
                                                        <optgroup label="V">
                                                            <option value="VU">Vanuatu</option>
                                                            <option value="VE">Venezuela, Bolivarian Republic of
                                                            </option>
                                                            <option value="VN">Viet Nam</option>
                                                            <option value="VG">Virgin Islands, British</option>
                                                            <option value="VI">Virgin Islands, U.S.</option>
                                                        </optgroup>
                                                        <optgroup label="W">
                                                            <option value="WF">Wallis and Futuna</option>
                                                            <option value="EH">Western Sahara</option>
                                                        </optgroup>
                                                        <optgroup label="Y">
                                                            <option value="YE">Yemen</option>
                                                        </optgroup>
                                                        <optgroup label="Z">
                                                            <option value="ZM">Zambia</option>
                                                            <option value="ZW">Zimbabwe</option>
                                                        </optgroup>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="codeice_input" class="col-sm-4 col-form-label">Code
                                                    ICE</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm mb-2" type="text"
                                                        value="" id="codeice_input" name="codeice_input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="codeif_input" class="col-sm-4 col-form-label">Code
                                                    IF</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm mb-2" type="text"
                                                        value="" id="codeif_input" name="codeif_input">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <h6>Contact</h6>

                                            <div class="form-group row">
                                                <label for="telephone_input"
                                                    class="col-sm-4 col-form-label">Téléphone</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm" type="tel" value=""
                                                        id="telephone_input" name="telephone_input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="gsm_input" class="col-sm-4 col-form-label">GSM
                                                </label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm" type="tel" value=""
                                                        id="gsm_input" name="gsm_input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="fax_input" class="col-sm-4 col-form-label">Fax
                                                </label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm" type="tel" value=""
                                                        id="fax_input" name="fax_input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="email_input" class="col-sm-4 col-form-label">Email</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm" type="email" value=""
                                                        id="email_input" name="email_input">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="siteweb_input" class="col-sm-4 col-form-label">Taux de remise (%)</label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm" type="number" value="" id="siteweb_input" name="siteweb_input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="form-row">
                                        <div class="col-12">
                                            <div class="form-group row">
                                                <label for="conditions_select"
                                                    class="col-sm-4 col-form-label">Conditions de règlement
                                                </label>
                                                <div class="col-sm-8">
                                                    <select id="conditions_select" name="conditions_select"
                                                        class="form-control form-control-sm custom-select">
                                                        <option hidden>Choisir</option>
                                                        <option value="1">A réception de la facture</option>
                                                        <option value="2">Acompte de 30% à la commande, solde à
                                                            la
                                                            livraison</option>
                                                        <option value="3">30 jours</option>
                                                        <option value="4">30 jours fin de mois</option>
                                                        <option value="5">60 jours</option>
                                                        <option value="6">Autre</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="mode_select"
                                                    class="col-sm-4 col-form-label">Modes de règlement
                                                </label>
                                                <div class="col-sm-8">
                                                    <select id="mode_select" name="mode_select"
                                                        class="form-control form-control-sm custom-select">
                                                        <option hidden>Choisir</option>
                                                        <option value="espèce">Espèce</option>
                                                        <option value="chèque">Chèque</option>
                                                        <option value="effet">Effet</option>
                                                        <option value="avoir">Avoir</option>
                                                        <option value="virement">Virement</option>
                                                        <option value="solde">Solde excel</option>
                                                        <option value="bon">Bon de livraison</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label for="radio_limit"
                                                    class="col-sm-4 col-form-label">Date limite?
                                                </label>
                                                <div class="col-sm-8">
                                                    <div class="form-check-inline my-1">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="radio_limit" name="LimitRadio" class="custom-control-input" value="oui">
                                                            <label class="custom-control-label" for="radio_limit">Oui</label>
                                                        </div>
                                                    </div> 
                                                    <div class="form-check-inline my-1">
                                                        <div class="custom-control custom-radio">
                                                            <input type="radio" id="radio_limit2" name="LimitRadio" class="custom-control-input" value="non" checked="">
                                                            <label class="custom-control-label" for="radio_limit2">Non</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row" id="dateLimitSection" style="display:none;">
                                                <label for="dataLimit"
                                                    class="col-sm-4 col-form-label">Date de limite
                                                </label>
                                                <div class="col-sm-8">
                                                    <input type="date" id="dataLimit" name="dataLimit" class="form-control form-control-sm">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <div class="col-12">
                                            <h6>Classement</h6>
                                            <div class="card bg-gray">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <label for="datecreation_input"
                                                            class="col-sm-4 col-form-label">Date
                                                            Création</label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm" type="date"
                                                                value="" id="datecreation_input"
                                                                name="datecreation_input">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="categorie_select"
                                                            class="col-sm-4 col-form-label">Catégorie
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <select id="categorie_select" name="categorie_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option value="" hidden>Choisir</option>
                                                                <option value="1">Niveau 1</option>
                                                                <option value="2">Niveau 2</option>
                                                                <option value="3">Niveau 3
                                                                <option>
                                                                <option value="4">Niveau 4</option>
                                                                <option value="6">Remise maximale</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="suivipar_select"
                                                            class="col-sm-4 col-form-label">Suivi par
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <select id="suivipar_select" name="suivipar_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option hidden>Choisir</option>
                                                                <option value="1">exemple@exemple.me</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="recouvreur_input"
                                                            class="col-sm-4 col-form-label">Recouvreur
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm" type="text"
                                                                value="" id="recouvreur_input" name="recouvreur_input">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="activite_select"
                                                            class="col-sm-4 col-form-label">Activité
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <select id="activite_select" name="activite_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option data-text="" value="" hidden>Choisir</option>
                                                                <option data-text="" value="addNewItem">Gérer la liste
                                                                </option>
                                                                <option data-text="Agriculture" value="316811">
                                                                    Agriculture
                                                                </option>
                                                                <option data-text="Agro-alimentaire" value="316812">
                                                                    Agro-alimentaire</option>
                                                                <option data-text="Armée, sécurité" value="316814">
                                                                    Armée,
                                                                    sécurité</option>
                                                                <option data-text="Art, design" value="316813">
                                                                    Art,
                                                                    design
                                                                </option>
                                                                <option data-text="Audiovisuel, spectacle"
                                                                    value="316815">
                                                                    Audiovisuel, spectacle</option>
                                                                <option data-text="Audit, conseil, RH" value="316816">
                                                                    Audit,
                                                                    conseil, RH</option>
                                                                <option data-text="Automobile" value="316817">
                                                                    Automobile
                                                                </option>
                                                                <option data-text="Banque, assurances, immobilier"
                                                                    value="316818">Banque, assurances,
                                                                    immobilier
                                                                </option>
                                                                <option data-text="Bois, meubles" value="316819">
                                                                    Bois,
                                                                    meubles
                                                                </option>
                                                                <option data-text="BTP, architecture" value="316820">
                                                                    BTP,
                                                                    architecture</option>
                                                                <option data-text="Chimie, pharmacie" value="316821">
                                                                    Chimie,
                                                                    pharmacie</option>
                                                                <option data-text="Commerce, distribution"
                                                                    value="316822">
                                                                    Commerce, distribution</option>
                                                                <option data-text="Communication, Marketing, Pub"
                                                                    value="316823">Communication, Marketing, Pub
                                                                </option>
                                                                <option data-text="Construction navale" value="316824">
                                                                    Construction navale</option>
                                                                <option data-text="Culture, artisanat d'art"
                                                                    value="316825">
                                                                    Culture, artisanat d'art</option>
                                                                <option data-text="Droit, justice" value="316826">
                                                                    Droit,
                                                                    justice
                                                                </option>
                                                                <option data-text="Edition, journalisme" value="316827">
                                                                    Edition,
                                                                    journalisme</option>
                                                                <option data-text="Electronique" value="316828">
                                                                    Electronique
                                                                </option>
                                                                <option data-text="Energies" value="316829">
                                                                    Energies
                                                                </option>
                                                                <option data-text="Enseignement, formations"
                                                                    value="316830">
                                                                    Enseignement, formations</option>
                                                                <option data-text="Environnement" value="316831">
                                                                    Environnement
                                                                </option>
                                                                <option data-text="Fonction publique" value="316832">
                                                                    Fonction
                                                                    publique</option>
                                                                <option data-text="Hôtellerie, restauration"
                                                                    value="316833">
                                                                    Hôtellerie, restauration</option>
                                                                <option data-text="Informatique, internet et télécom"
                                                                    value="316834">Informatique, internet et
                                                                    télécom
                                                                </option>
                                                                <option data-text="Logistique, transport"
                                                                    value="316835">
                                                                    Logistique, transport</option>
                                                                <option data-text="Maintenance, entretien"
                                                                    value="316836">
                                                                    Maintenance, entretien</option>
                                                                <option data-text="Mécanique" value="316837">
                                                                    Mécanique
                                                                </option>
                                                                <option data-text="Mode et industrie textile"
                                                                    value="316838">
                                                                    Mode et industrie textile</option>
                                                                <option data-text="Recherche" value="316839">
                                                                    Recherche
                                                                </option>
                                                                <option data-text="Santé" value="316840">Santé
                                                                </option>
                                                                <option data-text="Social" value="316841">Social
                                                                </option>
                                                                <option data-text="Sport, loisirs et tourisme"
                                                                    value="316842">
                                                                    Sport, loisirs et tourisme</option>
                                                                <option data-text="Traduction, interprétariat"
                                                                    value="316843">
                                                                    Traduction, interprétariat</option>
                                                                <option data-text="Verre, béton et céramique"
                                                                    value="316844">
                                                                    Verre, béton et céramique</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="region_select"
                                                            class="col-sm-4 col-form-label">Région
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <select id="region_select" name="region_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option hidden data-text="" value="">Choisir</option>
                                                                <option data-text="" value="addNewItem">Gérer la liste
                                                                </option>
                                                                <option data-text="Chaouia-Ouardigha" value="165625">
                                                                    Chaouia-Ouardigha</option>
                                                                <option data-text="Doukkala-Abda" value="165626">
                                                                    Doukkala-Abda
                                                                </option>
                                                                <option data-text="Fès-Boulemane" value="165627">
                                                                    Fès-Boulemane
                                                                </option>
                                                                <option data-text="Gharb-Chrarda-Beni Hssen"
                                                                    value="165628">
                                                                    Gharb-Chrarda-Beni Hssen</option>
                                                                <option data-text="Grand Casablanca" value="165629">
                                                                    Grand
                                                                    Casablanca</option>
                                                                <option data-text="Guelmim-Es Smara" value="165630">
                                                                    Guelmim-Es
                                                                    Smara</option>
                                                                <option data-text="Laâyoune-Boujdour-Sakia el Hamra"
                                                                    value="165631">Laâyoune-Boujdour-Sakia el
                                                                    Hamra
                                                                </option>
                                                                <option data-text="Marrakech-Tensift-Al Haouz"
                                                                    value="165632">
                                                                    Marrakech-Tensift-Al Haouz</option>
                                                                <option data-text="Meknès-Tafilalet" value="165633">
                                                                    Meknès-Tafilalet</option>
                                                                <option data-text="Oriental Maroc" value="165634">
                                                                    Oriental Maroc
                                                                </option>
                                                                <option data-text="Oued Ed-Dahab-Lagouira"
                                                                    value="165635">Oued
                                                                    Ed-Dahab-Lagouira</option>
                                                                <option data-text="Rabat-Salé-Zemmour-Zaër"
                                                                    value="165636">
                                                                    Rabat-Salé-Zemmour-Zaër</option>
                                                                <option data-text="Souss-Massa-Drâa" value="165637">
                                                                    Souss-Massa-Drâa</option>
                                                                <option data-text="Tadla-Azilal" value="165638">
                                                                    Tadla-Azilal
                                                                </option>
                                                                <option data-text="Tanger-Tétouan" value="165639">
                                                                    Tanger-Tétouan
                                                                </option>
                                                                <option data-text="Taza-Al Hoceima-Taounate"
                                                                    value="165640">
                                                                    Taza-Al Hoceima-Taounate</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="origine_select"
                                                            class="col-sm-4 col-form-label">Origine
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <select id="origine_select" name="origine_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option hidden>Choisir</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <h6>Informations comptables</h6>
                                            <div class="card bg-gray">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <label for="devise_select"
                                                            class="col-sm-4 col-form-label">Devise
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <select id="devise_select" name="devise_select"
                                                                class="form-control form-control-sm custom-select">
                                                                <option value="EUR">EUR</option>
                                                                <option value="USD">USD</option>
                                                                <option value="GBR">GBR</option>
                                                                <option value="DH" selected="selected">DH
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="comptetiers_input"
                                                            class="col-sm-4 col-form-label">Compte tiers
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm" type="text"
                                                                value="" id="comptetiers_input"
                                                                name="comptetiers_input">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="comptecomptable_input"
                                                            class="col-sm-4 col-form-label">Compte comptable
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm" type="text"
                                                                value="" id="comptecomptable_input"
                                                                name="comptecomptable_input" disabled>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <h6>Autorisation</h6>
                                            <div class="card bg-gray">
                                                <div class="card-body">
                                                    <div class="form-group row">
                                                        <label for="plafond_input"
                                                            class="col-sm-4 col-form-label">Plafond
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm"
                                                                id="plafond_input" name="plafond_input"
                                                                name="plafondimpayé_input" type="number"
                                                                placeholder="0.00" name="price" min="0" value="0"
                                                                step="0.01" pattern="^\d+(?:\.\d{1,2})?$"
                                                                onblur="this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row">
                                                        <label for="plafondimpayé_input"
                                                            class="col-sm-4 col-form-label">Plafond impayé
                                                        </label>
                                                        <div class="col-sm-8">
                                                            <input class="form-control form-control-sm"
                                                                id="plafondimpayé_input" name="plafondimpayé_input"
                                                                type="number" placeholder="0.00" name="price" min="0"
                                                                value="0" step="0.01" pattern="^\d+(?:\.\d{1,2})?$"
                                                                onblur="this.parentNode.parentNode.style.backgroundColor=/^\d+(?:\.\d{1,2})?$/.test(this.value)?'inherit':'red'">
                                                        </div>
                                                    </div>
                                                    <div class="form-group row checkbox">
                                                        <div class="custom-control custom-checkbox mr-auto ml-auto">
                                                            <input type="checkbox" name="clientdouteux_check" class="custom-control-input"
                                                                id="clientdouteux_check">
                                                            <label class="custom-control-label"
                                                                for="clientdouteux_check">Client douteux</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                    <!--end card-body-->
                </div>
                <!--end card-->
            </div>
            <!--end col-->
        </div>
        <div class="row section2">
            <div class="col-12">
                <div class="card">
                    <div class="card-body p-2">
                        <button id="enregistrer_btn" class="btn btn-primary btn-sm ml-2 mr-2 float-right" role="button"><i
                                class="mdi mdi-content-save"></i>
                            Enregistrer</button>
                        <button id="annuler_btn" class="btn btn-warning btn-sm float-right" role="button"><i
                                class="mdi mdi-close"></i>
                            Annuler</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                         <div class="row">
                            <div class="col-12 datatable-btns mb-2"></div>
                        </div>
                        <table id="datatable-clients" class="table table-striped table-bordered w-100">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Téléphone</th>
                                    <!--<th>Solde</th>
                                    <!--<th>Catégorie</th>
                                    <th>TVA Intracom</th>
                                    <th>Type Société</th>
                                    <th>Téléphone</th>
                                    <th>GSM</th>
                                    <th>Fax</th>
                                    <th>Adresse</th>
                                    <th>CP</th>
                                    <th>Pays</th>
                                    <th>Site Web</th>
                                    <th>Activité</th>
                                    <th>Région</th>
                                    <th>Origine</th>
                                    <th>Adresse Livraison</th>
                                    <th>Date Création</th>
                                    <th>Compte comptable</th>
                                    <th>Suivi par</th>
                                    
                                    <th>Code IF</th>
                                    <th>Code ICE</th>
                                    <th>Devise</th>
                                    <th>Recouvreur</th>-->
                                    <th>Plafond</th>
                                    <th>Plafond impayé</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>

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

<script>
$(document).ready(function() {
    $(".section2").hide();
    $("#nouveau_btn").click(function () {
        $(".section1").hide();
        $(".section2").show();
        op = "add";
        $("input[type='text'").val("");
    });
    $("#annuler_btn").click(function () {
        $(".section2").hide();
        $(".section1").show();
        op = "add";
        $("input[type='text'").val("");
    });
    $("#societe_radio").change(function() {
        if ($(this).is(":checked")) {
            $("#personne_section").hide();
            $("#societe_section").show();
        }
    });
    $("#particulier_radio").change(function() {
        if ($(this).is(":checked")) {
            $("#societe_section").hide();
            $("#personne_section").show();
        }
    });

});
</script>

<!-- Footer -->
<?php 
    include_once './template/footer.php';
?>

<script src="../../script/client.js?r=<?php echo rand();?>" type="text/javascript"></script>