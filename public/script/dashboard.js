$(document).ready(function () {
	/*function getController(parm){
		var datas=$.ajax({
        url: "../../../controller/"+parm+"Controller.php",
		async: false}).responseText;
		var cmpUnpaidInvoiceSoldFund=0;
		var cmpUnpaidInvoiceSold=0;
		datas=JSON.parse(datas);
		datas.data.forEach(function(d){
			if(d.tablename=="facture")
				if(d.type=="Non réglée")
				{
					cmpUnpaidInvoiceSold++;
					cmpUnpaidInvoiceSoldFund+=parseFloat(d.reste!=null?d.reste:0);
				}
		});
		var data_total = [];
		data_total.cmpUnpaidInvoiceSold=cmpUnpaidInvoiceSold;
		data_total.cmpUnpaidInvoiceSoldFund=cmpUnpaidInvoiceSoldFund;
		return data_total;
	}*/
	function Calculator(data1,data2,i,j)
	{       var valueVente=0;
	        var valueAchat=0;
	        data1.forEach(function(d){
			            if(d.year==i&&d.month==j)
			                valueVente=d.total;
			        });
			data2.forEach(function(d){
			            if(d.year==i&&d.month==j)
			                valueAchat=d.total;
			        });
		    var total=[];
		    total.vente=valueVente;
		    total.achat=valueAchat;
		    return total;
	}
	function Years(data1,data2)
	{
	    var All = [];
	    data1.forEach(function(d){var year = d.year;var month=d.month;
	        All.push([year,month]);
	    });
	    data2.forEach(function(d){var year = d.year;var month=d.month;
	       All.push([year,month]);
	    });
	    var Unique = [];
	    var itemsFound = {};
        for(var i = 0, l = All.length; i < l; i++) {
            var stringified = JSON.stringify(All[i]);
            if(itemsFound[stringified]) { continue; }
            Unique.push(All[i]);
            itemsFound[stringified] = true;
        }
        function sortFunction(a, b) {
            if (a[0] === b[0]) {
                return 0;
            }
            else {
                return (a[0] > b[0]) ? -1 : 1;
            }
        }
        Unique.sort(sortFunction);
	    return Unique;
	}
    $(".year").html("En " + new Date().getFullYear());
    function getChartForEvolution(id,data,array)
	{
		data.forEach(function(d){
			if(d.code==id)
				array[d.month-1]=d.total; 
		});
	}
    $.ajax({
        url: "../../../controller/Statistiques.php",
        success: function (data, textStatus, jqXHR) {
            /*$("#nbrclient").html(data.client);
            $("#nbrfournisseur").html(data.fournisseur);
            $("#nbrdevisfournisseur").html(data.devisChat);
            $("#nbrcmdfournisseur").html(data.cmdAchat);
            $("#nbrcmdclient").html(data.cmdVente);
            $("#nbrdevisclient").html(data.devisVente);
            $("#gain").html((data.totalVente - data.totalDepense) + " DH");*/
            var theSales = parseFloat(data.totalVente);
            var thePurchases = parseFloat(data.totalDepense);
			$("#montant").html(theSales.toFixed(2) + " DH");
            $("#depense").html(thePurchases.toFixed(2) + " DH");
            var theGain = data.totalVente - data.totalDepense; 
			$("#gain").html((theGain.toFixed(2)) + " DH");
			//gestion top clients
			var clientsByMontant = "<tbody>";
			data.findMontantClient.forEach(function(d){
				clientsByMontant+="<tr><th scope='row'>"+d.id+"</th>"+"<td>"+d.nom+"</td>"+"<td>"+parseFloat(d.montant).toFixed(2)+"</td></tr>";
			});
			clientsByMontant+="</tbody>";
			$("#table_clients").html(clientsByMontant)
			
			//gestion evolution chiffre d'affaires
            var labels = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October","November", "December"];
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
			
			//gestion chiffre d'affaires
			var chiffreAffaires ="<tbody>";
			/*var maxTaille = data.totalVenteByYear.length>data.findTotalAchatByYears.length?data.totalVenteByYear.length:data.findTotalAchatByYears.length;
			console.log(maxTaille);*/
			var h=0;
			Years(data.totalVenteByYear,data.findTotalAchatByYears).forEach(function(d){
			        i=d[0];j=d[1];
			        var total = Calculator(data.totalVenteByYear,data.findTotalAchatByYears,i,j)
			        valueVente=total.vente;
			        valueAchat=total.achat;
			        gain = parseFloat(valueVente) - parseFloat(valueAchat);
			        if(gain>0) var color = "green"; else if(gain==0) var color = "black"; else var color = "red";
			        if(h<40)
			            chiffreAffaires+="<tr><td>"+labels[j-1]+" "+i+"</td><td>"+parseFloat(valueVente).toFixed(2)+"</td><td style='color:"+color+";'>"+gain.toFixed(2)+"</td></tr>";
			        else
			            chiffreAffaires+="<tr class='hidden' style='display:none'><td>"+labels[j-1]+" "+i+"</td><td>"+parseFloat(valueVente).toFixed(2)+"</td><td style='color:"+color+";'>"+gain.toFixed(2)+"</td></tr>";
			        h++;
			});
			//Years(data.totalVenteByYear,data.findTotalAchatByYears).forEach(function(d){console.log(d);});
			/*for(var i=MaxYear1;i>=MinYear1;i--)
			{   var valueVente=0;
			    var valueAchat=0;
			    var gain=0;
			    if(i==MinYear1&&i!=MaxYear1){
			        Min=MinMonth1;
			        Max=12;
			    }
			    else if(i==MinYear1&&i==MaxYear1){
			        Min=MinMonth1;
			        Max=MaxMonth1;
			    }
			    else if(i!=MinYear1&&i==MaxYear1){
			        Min=1;
			        Max=MaxMonth1;
			    }
			    else{
			        Min=1;
			        Max=12;
			    }
			    for(var j=Max;j>=Min;j--)
			    {   console.log(i,j);
			        var total = Calculator(data.totalVenteByYear,data.findTotalAchatByYears,i,j)
			        valueVente=total.vente;
			        valueAchat=total.achat;
			        gain = parseFloat(valueVente) - parseFloat(valueAchat);
			        if(gain>0) var color = "green"; else if(gain==0) var color = "black"; else var color = "red";
			        chiffreAffaires+="<tr><td>"+labels[j-1]+" "+i+"</td><td>"+parseFloat(valueVente).toFixed(2)+"</td><td style='color:"+color+";'>"+gain.toFixed(2)+"</td></tr>";
			    }
			}*/
			/*data.totalVenteByYear.forEach(function(d){
			    var gain = parseFloat(d.total);
			    var flag = false;
			    data.findTotalAchatByYears.forEach(function(l)
			    {
			        if(d.month==l.month && d.year==l.year && l.total!=null && l.total!=0)
			        {
			            gain=parseFloat(d.total)-parseFloat(l.total);
			            flag=true;
			        }
			    });
			    
			    if(gain>0) var color = "green"; else if(gain==0) var color = "black"; else var color = "red";
				chiffreAffaires+="<tr><td>"+labels[d.month-1]+" "+d.year+"</td><td>"+d.total+"</td><td style='color:"+color+";'>"+gain+"</td></tr>";
			});*/
			chiffreAffaires+="</tbody>";
			$("#table_chiffre_affaires").html(chiffreAffaires);
            
            //autoscrolling
            var flag=false;
            $(window).scroll(function() {
               if($(window).scrollTop() + $(window).height() == $(document).height() && flag===false) {
                    $("#table_chiffre_affaires").find("tr").filter(".hidden").css("display","table-row").removeClass("hidden");
                    flag=true;
               }
            });

            
			//gestion documents 
			var docs_table="<thead><tr><th style='background:#e1e1e1;' colspan='3'>Clients</th></tr></thead>"; 
			docs_table+="<tbody>";
			data.CountUndeliveredOrders.forEach(function(d){
			docs_table+="<tr><td>("+d.nbr+")</td><td colspan='2'>Commande(s) non livrée(s)</td></tr>";
			});
			data.findNonFacture.forEach(function(d){
			docs_table+="<tr><td>("+d.totalnonfacture+")</td><td>Livraison(s) non facturé(s)</td><td>"+parseFloat(d.total).toFixed(2)+"</td></tr>";
			});
			data.FactureImpayéVente.forEach(function(d){
			docs_table+="<tr><td>("+d.nbr+")</td><td>Facture(s) impayée(s)</td><td>"
							+parseFloat(d.total).toFixed(2)+"</td></tr>";
			});
			docs_table+="</tbody>";
			docs_table+="<thead><tr><th style='background:#e1e1e1;' colspan='3'>Fournisseurs</th></tr></thead>"; 
			docs_table+="<tbody>";
			var totalFunds=0;
			data.CountFundsUndeliveredPurchases.forEach(function(d){totalFunds=d.total;});
			data.CountUndeliveredPurchases.forEach(function(d){
			docs_table+="<tr><td>("+d.nbr+")</td><td>Commande(s) non livrée(s)</td><td>"+parseFloat(totalFunds).toFixed(2)+"</td></tr>";
			});
			docs_table+="<tr><td>("+data.UninvoicedPurchasesCount.total+")</td><td>Réception(s) non facturé(s)</td><td>"+parseFloat(data.totalDepense).toFixed(2)+"</td></tr>";
			data.FactureImpayéAchat.forEach(function(d){
			docs_table+="<tr><td>("+d.nbr+")</td><td>Facture(s) impayée(s)</td><td>"
							+parseFloat(d.total).toFixed(2)+"</td></tr>";
			});
			docs_table+="</tbody>";
			$("#tables_docs").html(docs_table);
	
			//gestion top products
			var table_products="<tbody>";
			data.findTop10SoldProducts.forEach(function(d){
				table_products+="<tr><td id='"+d.reference.replace(/\s+/g, '')+"'><span class='d-inline-block' tabindex='0' data-toggle='tooltip"+d.reference.replace(/\s+/g, '')+"' data-placement='right' title='Cliquer pour consulter les vente'>"+d.reference+"</span></td><td>"+d.designation_vente+"</td><td>"+parseFloat(d.total).toFixed(2)+"</td></tr>";
			});
			table_products+="</tbody>";
			$("#table_products").html(table_products);
			
			//evolution par popup 
			data.findTop10SoldProducts.forEach(function(d){
				$("#"+d.reference.replace(/\s+/g, '')).click(function(){
				    var dts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
                    var dvts = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
				    var id=d.reference;
				    var nameProd="";
				    var ds = data.ProductsSoldFundsByMonthThisYear;
                    getChartForEvolution(id,ds,dts);
                    var vs = data.ProductsSoldFundsByMonthLastYear;
                    getChartForEvolution(id,vs,dvts);
                    $("#evolutionproductchart").remove();
        			$("#graphevolutioncenter").append("<canvas id='evolutionproductchart' height='426' width='512' style='width: 512px!important; height: 426px!important;'></canvas>");
        			graphe13(labels, dts, dvts,nameProd);
        			$("#reference").html(d.reference);
        			$('#ModalEvolution').modal("show");
        			
				});
				 $("#"+d.reference.replace(/\s+/g, '')).hover(
                  function() {
                    $("[data-toggle='tooltip"+d.reference.replace(/\s+/g, '')+"']").tooltip("show");
                  }, function() {
                    $("[data-toggle='tooltip"+d.reference.replace(/\s+/g, '')+"']").tooltip("hide");
                  }
                );
			});
			
            /*//nbr de produit par catégorie
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
            graphe2(categories, nbrCat);*/
			graphe1(labels, dvt);
			graphe2(labels, dt, dvt);
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }

    });
	function graphe1(labels, dvt) {
        if(document.getElementById('lineChart') == null)
            return null;
        var ctx = document.getElementById('lineChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, //,
                datasets: [
                    {
                        label: "Chiffre d'affaires",
                        fill: false,
                        lineTension: 0.5,
                        backgroundColor: "rgb(255,255,255)",
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
	function graphe2(labels, dt, dvt) {
        if(document.getElementById('lineChart2') == null)
            return null;
        var ctx = document.getElementById('lineChart2').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels, //,
                datasets: [
                    {
                        label: "Achats",
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
                        label: "Ventes",
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
    
    function graphe13(labels, dts, dvts,name) {
        if(document.getElementById('evolutionproductchart') === null)
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
                        data: dts
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
                        data: dvts
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