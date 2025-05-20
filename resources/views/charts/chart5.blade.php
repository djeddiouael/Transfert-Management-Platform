<div>
  <canvas id="f5" style="height:200px;"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  const ctx5 = document.getElementById('f5').getContext('2d');

  // Récupération des valeurs PHP et calcul du total
  const pendingTransfers = {{ $pendingTransfers + 12 }};
  const acceptedTransfers = {{ $acceptedTransfers + 12 }};
  const rejectedTransfers = {{ $rejectedTransfers + 12 }};
  const totalTransfers = pendingTransfers + acceptedTransfers + rejectedTransfers;

  console.log("Total Transfers: ", totalTransfers);  // Affichage du total dans la console

  const data5 = {
    datasets: [{
      label: 'Transfer Statuses',
      data: [
        { x: 1, y: pendingTransfers },
        { x: 2, y: acceptedTransfers },
        { x: 3, y: rejectedTransfers }
      ],
      backgroundColor: 'rgb(75, 192, 192)'
    }]
  };

  const config5 = {
    type: 'scatter',
    data: data5,
    options: {
      scales: {
        x: {
          title: {
            display: true,
            text: 'Transfer Type (1:Pending, 2:Accepted, 3:Rejected)'
          }
        },
        y: {
          beginAtZero: true,
          title: {
            display: true,
            text: 'Number of Transfers'
          }
        }
      }
    }
  };

  // Créer le graphique
  new Chart(ctx5, config5);
</script>
