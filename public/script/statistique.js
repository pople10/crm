$(document).ready(function () {
	function getController(parm){
		var datas=$.ajax({
        url: "../../../controller/"+parm+"Controller.php",
		async: false}).responseText;
		var cmpUnpaidInvoiceSoldFund=0;
		var cmpUnpaidInvoiceSold=0;
		var cmpPaidInvoiceSold=0;
		datas=JSON.parse(datas);
		datas.data.forEach(function(d){
			if(d.tablename=="facture")
				if(d.type=="Non réglée")
				{
					cmpUnpaidInvoiceSold++;
					cmpUnpaidInvoiceSoldFund+=parseFloat(d.reste!=null?d.reste:0);
				}
				else
				{
					cmpPaidInvoiceSold++;
				}
		});
		var data_total = [];
		data_total.cmpUnpaidInvoiceSold=cmpUnpaidInvoiceSold;
		data_total.cmpPaidInvoiceSold=cmpPaidInvoiceSold;
		data_total.cmpUnpaidInvoiceSoldFund=cmpUnpaidInvoiceSoldFund;
		return data_total;
	}
	function getChartForEvolution(id,data,array)
	{
		data.forEach(function(d){
			if(d.code==id)
				array[d.month-1]=d.total; 
		});
		return array;
	}
    $(".year").html("En " + new Date().getFullYear());
	
    $.ajax({
        url: "../../../controller/Statistiques.php",
        success: function (data, textStatus, jqXHR) {
            /*$("#depense").html(data.totalDepense + " DH");
			$("#montant").html(data.totalVente + " DH");
			$("#gain").html((data.totalVente - data.totalDepense) + " DH");*/
			$("#nbrclient").html(data.client);
            $("#nbrfournisseur").html(data.fournisseur);
            $("#nbrdevisfournisseur").html(data.devisChat);
            $("#nbrcmdfournisseur").html(data.cmdAchat);
            $("#nbrcmdclient").html(data.cmdVente);
            $("#nbrdevisclient").html(data.devisVente);
			data.CountDeliveredOrders.forEach(function(d){
				$("#nbrcmdclientdelivered").html(d.nbr);
				console.log(d.nbr);
			});
			data.CountDeliveredPurchases.forEach(function(d){
				$("#nbrcmdsupplierdelivered").html(d.nbr);
			});
			var OrdersStatusByPaymentType = getController("ReglementsVente");
			//etat commande client par payments types
            var etatcp = new Array();
            var nbrCmdcp = new Array();
                etatcp.push("Payée(s)");
                nbrCmdcp.push(OrdersStatusByPaymentType.cmpPaidInvoiceSold);
				etatcp.push("Non Payée(s)");
                nbrCmdcp.push(OrdersStatusByPaymentType.cmpUnpaidInvoiceSold);
			
			//gestion top clients
			var clientsByMontant = "<tbody>";
			data.findMontantClient.forEach(function(d){
				clientsByMontant+="<tr><th scope='row'>"+d.id+"</th>"+"<td>"+d.nom+"</td>"+"<td>"+d.montant+"</td></tr>";
			});
			clientsByMontant+="</tbody>";
			$("#table_clients").html(clientsByMontant)
			
			//evolution produits 
			var evolutionproduct = "";
			data.getAllProductsNameAndCodes.forEach(function(d){
				evolutionproduct+="<option value='"+d.code+"' id='"+d.code+"'>"+d.title+"</option>";
			});
			//console.log($("#productevolution"));
		    if(document.getElementById("productevolution") ==! null){
			$("#productevolution").selectize()[0].selectize.destroy();
			$("#productevolution").empty().append(evolutionproduct);
			$("#productevolution").selectize({
                sortField: 'text'
            });}
			
			//gestion evolution chiffre d'affaires
            var labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October","November", "December"];
			var nameProd="";
			$("#productevolution").change(function(){
			if($("#productevolution").val()!='0'){
			var dt = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var dvt = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
			var id=$("#productevolution").val();
            var d = data.ProductsSoldFundsByMonthThisYear;
            dt = getChartForEvolution(id,d,dt);
			nameProd = $("#"+id).html();
            var v = data.ProductsSoldFundsByMonthLastYear;
            dvt = getChartForEvolution(id,v,dvt);
			$("#evolutionproductchart").remove();
			$("#graphevolutioncenter").append("<canvas id='evolutionproductchart' height='426' width='512' style='width: 512px!important; height: 426px!important;'></canvas>");
			graphe13(labels, dt, dvt,nameProd);
			}
			});
			if($("#productevolution").val()!='0'){
			var dt = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
            var dvt = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
			var id=$("#productevolution").val();
            var d = data.ProductsSoldFundsByMonthThisYear;
            dt = getChartForEvolution(id,d,dt);
			nameProd = $("#"+id).html();
            var v = data.ProductsSoldFundsByMonthLastYear;
            dvt = getChartForEvolution(id,v,dvt);
			$("#evolutionproductchart").remove();
			$("#graphevolutioncenter").append("<canvas id='evolutionproductchart' height='426' width='512' style='width: 512px!important; height: 426px!important;'></canvas>");
			graphe13(labels, dt, dvt,nameProd);}
			
			
			//gestion chiffre d'affaires
			var chiffreAffaires ="<tbody>";
			data.totalVenteByYear.forEach(function(d){
				chiffreAffaires+="<tr><td>"+labels[d.month-1]+" "+d.year+"</td><td>"+d.total+"</td></tr>";
			});
			chiffreAffaires+="</tbody>";
			$("#table_chiffre_affaires").html(chiffreAffaires);
			
			//gestion documents 
			var docs_table="<thead><tr><th style='background:#e1e1e1;' colspan='3'>Clients</th></tr></thead>"; 
			docs_table+="<tbody>";
			data.CountUndeliveredOrders.forEach(function(d){
			docs_table+="<tr><td>("+d.nbr+")</td><td colspan='2'>Commande(s) non livrée(s)</td></tr>";
			});
			data.findNonFacture.forEach(function(d){
			docs_table+="<tr><td>("+d.totalnonfacture+")</td><td>Livraison(s) non facturé(s)</td><td>"+d.total+"</td></tr>";
			});
			var clientInvoices = getController("ReglementsVente");
			docs_table+="<tr><td>("+clientInvoices.cmpUnpaidInvoiceSold+")</td><td>Livraison(s) non facturé(s)</td><td>"
							+clientInvoices.cmpUnpaidInvoiceSoldFund+"</td></tr>";
			docs_table+="</tbody>";
			docs_table+="<thead><tr><th style='background:#e1e1e1;' colspan='3'>Fournisseurs</th></tr></thead>"; 
			docs_table+="<tbody>";
			var totalFunds=0;
			data.CountFundsUndeliveredPurchases.forEach(function(d){totalFunds=d.total;});
			data.CountUndeliveredPurchases.forEach(function(d){
			docs_table+="<tr><td>("+d.nbr+")</td><td>Commande(s) non livrée(s)</td><td>"+totalFunds+"</td></tr>";
			});
			docs_table+="<tr><td>("+data.UninvoicedPurchasesCount.total+")</td><td>Réception(s) non facturé(s)</td><td>"+data.totalDepense+"</td></tr>";
			var supplierInvoices = getController("Reglements");
			docs_table+="<tr><td>("+supplierInvoices.cmpUnpaidInvoiceSold+")</td><td>Livraison(s) non facturé(s)</td><td>"
							+supplierInvoices.cmpUnpaidInvoiceSoldFund+"</td></tr>";
			docs_table+="</tbody>";
			$("#tables_docs").html(docs_table);
	
			//gestion top products
			var table_products="<tbody>";
			data.findTop10SoldProducts.forEach(function(d){
				table_products+="<tr><td>"+d.reference+"</td><td>"+d.designation_vente+"</td><td>"+d.total+"</td></tr>";
			});
			table_products+="</tbody>";
			$("#table_products").html(table_products);
            //nbr de produit par catégorie
            var cat = data.findCountProductByCategory;
            var categories = new Array();
            var nbrCat = new Array();
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
			//retour des commande ventes
			var rvente = data.getReturnedProductsOrders;
			var rvprd = new Array();
			var rvprdnmr = new Array();
			rvente.forEach(function(d){
				rvprd.push(d.produit);
				rvprdnmr.push(d.total);
			});
			
			//retour des commande achats
			var rachat = data.getReturnedProductsPurchases;
			var raprd = new Array();
			var raprdnmr = new Array();
			rachat.forEach(function(d){
				raprd.push(d.produit);
				raprdnmr.push(d.total);
			});
			
			
            graphe7(etat, nbrCmd);
            graphe8(etatc, nbrCmdc);
			graphe1(etatcp, nbrCmdcp);


            graphe12(ps, np,"produits");
            graphe5(clients, montantC);
            graphe4(p, n);
            graphe3(fournisseurs, montant);
            graphe12(categories, nbrCat,"doughnut");
			graphe12(rvprd, rvprdnmr,"rvprd");
			graphe12(raprd, raprdnmr,"raprd");
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }

    });
	function graphe8(labels, dt) {
        if(document.getElementById('cmdc') == null)
            return null;
        var ctx = document.getElementById('cmdc').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [
                    {
                        data: dt,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)'
                        ],
                        hoverBackgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        hoverBorderColor: "#fff"
                    }]
            }
        });

    }
	function graphe1(labels, dt) {
        if(document.getElementById('cmdcp') == null)
            return null;
        var ctx = document.getElementById('cmdcp').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [
                    {
                        data: dt,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)'
                        ],
                        hoverBackgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        hoverBorderColor: "#fff"
                    }]
            }
        });

    }

    function graphe2(labels, dt) {
        if(document.getElementById('doughnut') == null)
            return null;
        var ctx = document.getElementById('doughnut').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [
                    {
                        data: dt,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)'
                        ],
                        hoverBackgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        hoverBorderColor: "#fff"
                    }]
            }
        });
    }
    function graphe7(labels, dt) {
        if(document.getElementById('cmd') == null)
            return null;
        var ctx = document.getElementById('cmd').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [
                    {
                        data: dt,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)'
                        ],
                        hoverBackgroundColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        hoverBorderColor: "#fff"
                    }]
            }
        });

    }


    function graphe5(labels, dt) {
        if(document.getElementById('clients') == null)
            return null;
        var ctx = document.getElementById('clients').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, //,
                datasets: [
                    {
                        fill: true,
                        lineTension: 0.5,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#283179",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#283179",
                        pointHoverBorderColor: "#3bc9f1",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: dt
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Montant en DH'
                            }
                        }],
                    xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Clients'
                            }
                        }]
                }
            }
        });
    }

    function graphe3(labels, dt) {
        if(document.getElementById('bar') == null)
            return null;
        var ctx = document.getElementById('bar').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, //,
                datasets: [
                    {
                        fill: true,
                        lineTension: 0.5,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#283179",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#283179",
                        pointHoverBorderColor: "#3bc9f1",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: dt
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Montant en DH'
                            }
                        }],
                    xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Fournisseurs'
                            }
                        }]
                }
            }
        });
    }

    function graphe6(labels, dt) {
        if(document.getElementById('produits') == null)
            return null;
        var ctx = document.getElementById('produits').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, //,
                datasets: [
                    {
                        fill: true,
                        lineTension: 0.5,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#283179",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#283179",
                        pointHoverBorderColor: "#3bc9f1",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: dt
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Quantité'
                            }
                        }],
                    xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Produit'
                            }
                        }]
                }
            }
        });
    }
	
	function graphe12(labels, dt,id) {
        if(document.getElementById(id) == null)
            return null;
        var ctx = document.getElementById(id).getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, //,
                datasets: [
                    {
                        fill: true,
                        lineTension: 0.5,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)',
                            'rgba(181, 159, 40, 1)',
                            'rgba(74, 71, 64, 1)',
                            'rgba(42, 74, 47, 1)',
                            'rgba(74, 78, 64, 1)',
                            'rgba(255, 255, 64, 1)',
                            'rgba(255, 7, 240, 1)',
                            'rgba(255, 0, 64, 1)',
                            'rgba(170, 74, 64, 1)',
                            'rgba(74, 255, 20, 1)',
                            'rgba(40, 71, 64, 1)',
                            'rgba(190, 190, 190, 1)',
                            'rgba(72, 72, 255, 1)',
                            'rgba(0, 40, 255, 1)',
                            'rgba(255, 71, 255, 1)',
                            'rgba(0, 255, 25, 1)',
                            'rgba(40, 42, 71, 1)',
                            'rgba(24, 178, 190, 1)',
                            'rgba(190, 190, 190, 1)',
                            'rgba(175, 159, 175, 1)',
                            'rgba(71, 0, 240, 1)',
                            'rgba(255, 42, 71, 1)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(181, 159, 40, 1)',
                            'rgba(74, 71, 64, 1)',
                            'rgba(42, 74, 47, 1)',
                            'rgba(74, 78, 64, 1)',
                            'rgba(255, 255, 64, 1)',
                            'rgba(255, 7, 240, 1)',
                            'rgba(255, 0, 64, 1)',
                            'rgba(170, 74, 64, 1)',
                            'rgba(74, 255, 20, 1)',
                            'rgba(40, 71, 64, 1)',
                            'rgba(190, 190, 190, 1)',
                            'rgba(72, 72, 255, 1)',
                            'rgba(0, 40, 255, 1)',
                            'rgba(255, 71, 255, 1)',
                            'rgba(0, 255, 25, 1)',
                            'rgba(40, 42, 71, 1)',
                            'rgba(24, 178, 190, 1)',
                            'rgba(190, 190, 190, 1)',
                            'rgba(175, 159, 175, 1)',
                            'rgba(71, 0, 240, 1)',
                            'rgba(255, 42, 71, 1)'
                        ],
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#283179",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#283179",
                        pointHoverBorderColor: "#3bc9f1",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: dt
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Quantité'
                            }
                        }],
                    xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Produit'
                            }
                        }]
                }
            }
        });
    }

    function graphe4(labels, dt) {
        if(document.getElementById('produit') == null)
            return null;
        var ctx = document.getElementById('produit').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels, //,
                datasets: [
                    {
                        fill: true,
                        lineTension: 0.5,
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.4)',
                            'rgba(54, 162, 235, 0.4)',
                            'rgba(255, 206, 86, 0.4)',
                            'rgba(75, 192, 192, 0.4)',
                            'rgba(153, 102, 255, 0.4)',
                            'rgba(255, 159, 64, 0.4)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(75, 192, 192, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#283179",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#283179",
                        pointHoverBorderColor: "#3bc9f1",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: dt
                    }
                ]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Quantité'
                            }
                        }],
                    xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Produit'
                            }
                        }]
                }
            }
        });
    }
	function graphe13(labels, dt, dvt,name) {
        if(document.getElementById('evolutionproductchart') == null)
            return null;
        var ctx = document.getElementById('evolutionproductchart').getContext('2d');
		var thisYear = new Date().getFullYear();
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, //,
				datasets: [
                    {
                        label: "Vente en " + parseFloat(thisYear),
                        fill: true,
                        lineTension: 0.5,
                        backgroundColor: "rgba(40, 49, 121, 0.4)",
                        borderColor: "#283179",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#283179",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#283179",
                        pointHoverBorderColor: "#3bc9f1",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: dt
                    },
                    {
                        label: "Vente en " + (parseFloat(thisYear)-1) ,
                        fill: true,
                        lineTension: 0.5,
                        backgroundColor: "rgba(255, 99, 132, 0.4)",
                        borderColor: "rgba(255, 99, 132, 1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        pointBorderColor: "#ebeff2",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "#ebeff2",
                        pointHoverBorderColor: "#eef0f2",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: dvt
                    }
                ]
            },
            options: {
                scales: {
                    yAxes: [{
                            ticks: {
                                beginAtZero: true
                            },
                            scaleLabel: {
                                display: true,
                                labelString: 'Montant en DH'
                            }
                        }],
                    xAxes: [{
                            scaleLabel: {
                                display: true,
                                labelString: 'Mois'
                            }
                        }]
                }
            }
        });
    }

});