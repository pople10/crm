$(document).ready(function () {

    $(".year").html("En " + new Date().getFullYear());

    $.ajax({
        url: "../../../controller/Dashbord.php",
        success: function (data, textStatus, jqXHR) {
            /*$("#nbrclient").html(data.client);
            $("#nbrfournisseur").html(data.fournisseur);
            $("#nbrdevisfournisseur").html(data.devisChat);
            $("#nbrcmdfournisseur").html(data.cmdAchat);
            $("#nbrcmdclient").html(data.cmdVente);
            $("#montant").html(data.totalVente + " DH");
            $("#depense").html(data.totalDepense + " DH");
            $("#nbrdevisclient").html(data.devisVente);
            $("#gain").html((data.totalVente - data.totalDepense) + " DH");*/
			var clientsByMontant = "<tbody>";
			data.findMontantClient.forEach(function(d){
				clientsByMontant+="<tr><th scope='row'>1</th>"+"<td>"+d.nom+"</td>"+"<td>"+d.montant+"</td></tr>";
			});
			clientsByMontant+="</tbody>";
			$("#table_clients").html(clientsByMontant)

            /*var labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "December"];
            var dt = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var dvt = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

            var d = data.totalbymonth;
            d.forEach(function (e) {
                dt[e.mois - 1] = e.total;
            });

            var v = data.totalventebymonth;
            v.forEach(function (e) {
                dvt[e.mois - 1] = e.total;
            });

            //nbr de produit par catégorie
            var cat = data.findCountProductByCategory;
            var categories = new Array();
            var nbrCat = new Array();
            console.log(JSON.stringify(cat));
            cat.forEach(function (e) {
                categories.push(e.categorie);
                nbrCat.push(e.nbr);
            });

            //Montant fournisseurs
            var fm = data.findMontantFournisseur;
            var fournisseurs = new Array();
            var montant = new Array();
            fm.forEach(function (e) {
                fournisseurs.push(e.nom);
                montant.push(e.montant);
            });


            //Classement client
            var cl = data.findMontantClient;
            var clients = new Array();
            var montantC = new Array();
            cl.forEach(function (e) {
                clients.push(e.nom);
                montantC.push(e.montant);
            });

            //Produits les plus commandées
            var pc = data.findPurchasedProduct;
            var p = new Array();
            var n = new Array();
            pc.forEach(function (e) {
                p.push(e.reference);
                n.push(e.quantite);
            });

            //Produits les plus vendus
            var pv = data.findSoldProduct;
            var ps = new Array();
            var np = new Array();
            pv.forEach(function (e) {
                ps.push(e.reference);
                np.push(e.quantite);
            });


            //etat commande client
            var cmdc = data.etatCommandc;
            var etatc = new Array();
            var nbrCmdc = new Array();
            cmdc.forEach(function (e) {
                etatc.push(e.etat);
                nbrCmdc.push(e.nbr);
            });
            //etat Commande fournisseur
            var cmd = data.etatCommand;
            var etat = new Array();
            var nbrCmd = new Array();
            cmd.forEach(function (e) {
                etat.push(e.etat);
                nbrCmd.push(e.nbr);
            });

            graphe7(etat, nbrCmd);
            graphe8(etatc, nbrCmdc);


            graphe6(ps, np);
            graphe5(clients, montantC);
            graphe4(p, n);
            graphe3(fournisseurs, montant);
            graphe2(categories, nbrCat);
            graphe1(labels, dt, dvt);*/
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }

    });

});