<?php ?>


<!-- MENU Start -->
<div class="navbar-custom">
    <div class="container-fluid">
        <div id="navigation">
            <!-- Navigation Menu-->
            <ul class="navigation-menu text-center">

                <li class="has-submenu ">
                    <a href="<?php echo __PUBLICFOLDER__; ?>"><i class="mdi mdi-airplay"></i>Accueil</a>
                </li>
                <?php if(sectionAllowed(Priviliges::CONTACTS)){ ?>
                <li class="has-submenu ">
                    <a href="#"><i class="mdi mdi-account-multiple-outline"></i>Contacts</a>
                    <ul class="submenu">
                        <li><a href="<?php echo __CONTACTSFOLDER__; ?>/entreprise.php">Entreprise</a></li>
                        <li><a href="<?php echo __CONTACTSFOLDER__; ?>/clients.php">Clients</a></li>
                        <li><a href="<?php echo __CONTACTSFOLDER__; ?>/fournisseurs.php">Fournisseurs</a></li>
                        <li><a href="<?php echo __CONTACTSFOLDER__; ?>/actions.php">Actions à réaliser</a></li>
                        <li><a href="<?php echo __CONTACTSFOLDER__; ?>/blacklist.php">Liste Noire</a></li>
                    </ul>
                </li>
                <? }
                if(sectionAllowed(Priviliges::VENTES)){ ?>
                <li class="has-submenu">
                    <a href="#"><i class="mdi mdi-cash-usd"></i>Ventes</a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/devis.php">Devis</a></li>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/commandes.php">Commandes</a></li>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/bons.php">Livraisons</a></li>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/factures.php">Factures</a></li>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/retours.php">Retours</a></li>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/avoirs.php">Avoirs</a></li>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/releves.php">Relevés clients</a></li>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/reglements.php">Règlements</a></li>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/comptes.php">Compte Clients</a></li>
                                <li><a href="<?php echo __VENTESFOLDER__; ?>/bilan.php">Bilan Clients</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <? }
                if(sectionAllowed(Priviliges::ACHATS)){ ?>
                <li class="has-submenu">
                    <a href="#"><i class="mdi mdi-cart-plus"></i>Achats</a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="<?php echo __ACHATSFOLDER__; ?>/devis.php">Devis</a></li>
                                <li><a href="<?php echo __ACHATSFOLDER__; ?>/commandes.php">Commandes</a></li>
                                <li><a href="<?php echo __ACHATSFOLDER__; ?>/bons.php">Bons de réception</a></li>
                                <li><a href="<?php echo __ACHATSFOLDER__; ?>/factures.php">Factures</a></li>
                                <li><a href="<?php echo __ACHATSFOLDER__; ?>/retours.php">Retours</a></li>
                                <li><a href="<?php echo __ACHATSFOLDER__; ?>/avoirs.php">Avoirs</a></li>
                                <li><a href="<?php echo __ACHATSFOLDER__; ?>/releves.php">Relevés fournisseurs</a></li>
                                <li><a href="<?php echo __ACHATSFOLDER__; ?>/reglements.php">Règlements</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <? }
                if(sectionAllowed(Priviliges::PRODUITS_ET_SERVICES)){ ?>
                <li class="has-submenu">
                    <a href="#"><i class="mdi mdi-gauge"></i>Produits & Services</a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/marques.php">Marques</a></li>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/famille.php">Famille et sous-famille</a></li>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/categorie.php">Catégorie</a></li>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/emplacement.php">Emplacement</a></li>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/catalogues.php">Catalogue & Tarif</a></li>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/produits.php">Produits & Commandes</a></li>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/stock.php">Stock & Mouvements</a></li>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/alertes.php">Alertes de rupture de stock</a></li>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/alertesretardpaiment.php">Alertes de retard des paiments</a></li>
                                <li><a href="<?php echo __SERVICESFOLDER__; ?>/depots.php">Dépôts</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <? }
                if(sectionAllowed(Priviliges::COMPTABILITE)){ ?>
                <li class="has-submenu">
                    <a href="#"><i class="mdi mdi-calculator"></i>Comptabilité</a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="<?php echo __COMPTAFOLDER__; ?>/charges.php">Charges & Immo</a></li>
                                <li><a href="<?php echo __COMPTAFOLDER__; ?>/journeaux.php">Journaux</a></li>
                                <li><a href="<?php echo __COMPTAFOLDER__; ?>/tresorerie.php">Trésorerie</a></li>
                                <li><a href="<?php echo __COMPTAFOLDER__; ?>/consultation.php">Consultation</a></li>
                                <li><a href="<?php echo __COMPTAFOLDER__; ?>/parametres.php">Paramètres</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <? }
                if(sectionAllowed(Priviliges::ANALYSE)){ ?>
                <li class="has-submenu">
                    <a href="#"><i class="mdi mdi-chart-line"></i>Analyse</a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="<?php echo __ANALYSEFOLDER__; ?>/ventes.php">Analyse des ventes</a></li>
                                <li><a href="<?php echo __ANALYSEFOLDER__; ?>/marges.php">Analyse des marges</a></li>
                                <li><a href="<?php echo __ANALYSEFOLDER__; ?>/flux.php">Analyse des flux</a></li>
                                <li><a href="<?php echo __ANALYSEFOLDER__; ?>/charges.php">Analyse des charges</a></li>
                                <li><a href="<?php echo __ANALYSEFOLDER__; ?>/commerciale.php">Analyse commerciale</a></li>
                                <li><a href="<?php echo __ANALYSEFOLDER__; ?>/stock.php">Analyse des stock</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <? }
                if(sectionAllowed(Priviliges::STATISTIQUE)){ ?>
                <li class="has-submenu">
                    <a href="#"><i class="mdi mdi-chart-line"></i>Statistiques</a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="<?php echo __STATISTIQUEFOLDER__; ?>/clients.php">Clients</a></li>
                                <li><a href="<?php echo __STATISTIQUEFOLDER__; ?>/fournisseurs.php">Fournisseurs</a></li>
                                <li><a href="<?php echo __STATISTIQUEFOLDER__; ?>/produits.php">Produits</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <?}
                if(sectionAllowed(Priviliges::ADMINISTRATION)){ ?>
                <li class="has-submenu">
                    <a href="#"><i class="mdi mdi-google-pages"></i>Administration</a>
                    <ul class="submenu megamenu">
                        <li>
                            <ul>
                                <li><a href="<?php echo __ADMINFOLDER__; ?>/roles.php">Gestion des roles</a></li>
                                <li><a href="<?php echo __ADMINFOLDER__; ?>/privileges.php">Gestion des privilèges</a></li>
                                <li><a href="<?php echo __ADMINFOLDER__; ?>/users.php">Gestion des utilisateurs</a></li>
                                <li><a href="<?php echo __ADMINFOLDER__; ?>/historiques.php">Historiques des actions</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <? } ?>
            </ul>


            <!-- End navigation menu -->
        </div> <!-- end #navigation -->
    </div> <!-- end container -->
</div> <!-- end navbar-custom -->