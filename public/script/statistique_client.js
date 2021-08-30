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
			$("#nbrclient").html(data.client);
            $("#nbrcmdclient").html(data.cmdVente);
            $("#nbrdevisclient").html(data.devisVente);
			data.CountDeliveredOrders.forEach(function(d){
				$("#nbrcmdclientdelivered").html(d.nbr);
			});
			//etat commande client par payments types
            var etatcp = [];
            var nbrCmdcp = [];
                etatcp.push("Non Payée(s)");
                data.FactureImpayéVente.forEach(function(d){
                nbrCmdcp.push(d.nbr);});
				etatcp.push("Payée(s)");
				data.FacturePayéVente.forEach(function(d){
                nbrCmdcp.push(d.nbr);});
			

            //Classement client
            var cl = data.findMontantClient;
            var clients = [];
            var montantC = [];
            cl.forEach(function (e) {
                clients.push(e.nom);
                montantC.push(e.montant);
            });

            //etat commande client
            var cmdc = data.etatCommandc;
            var etatc = [];
            var nbrCmdc = [];
            cmdc.forEach(function (e) {
                etatc.push(e.etat);
                nbrCmdc.push(e.nbr);
            });
            
            graphe1(etatcp, nbrCmdcp);
            graphe8(etatc, nbrCmdc);
			graphe5(clients, montantC);
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