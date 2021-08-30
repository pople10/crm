$(document).ready(function () {
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
            $("#nbrfournisseur").html(data.fournisseur);
            $("#nbrdevisfournisseur").html(data.devisChat);
            $("#nbrcmdfournisseur").html(data.cmdAchat);
			data.CountDeliveredPurchases.forEach(function(d){
				$("#nbrcmdsupplierdelivered").html(d.nbr);
			});
			
            //Montant fournisseurs
            var fm = data.findMontantFournisseur;
            var fournisseurs = [];
            var montant = [];
            fm.forEach(function (e) {
                fournisseurs.push(e.nom);
                montant.push(e.montant);
            });


            
            //etat Commande fournisseur
            var cmd = data.etatCommand;
            var etat = [];
            var nbrCmd = [];
            cmd.forEach(function (e) {
                etat.push(e.etat);
                nbrCmd.push(e.nbr);
            });
			
            graphe7(etat, nbrCmd);
            graphe3(fournisseurs, montant);
        },
        error: function (jqXHR, textStatus, errorThrown) {

        }

    });
    function graphe7(labels, dt) {
        if(document.getElementById('cmd') === null)
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
    function graphe3(labels, dt) {
        if(document.getElementById('bar') === null)
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
});