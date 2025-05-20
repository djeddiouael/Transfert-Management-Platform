<div>
  <canvas id="f3" style="height: 400px;"></canvas>
  <p id="totalTransfers">Total des transferts: 0</p>
</div>

<script>
  (function() {
    // Récupération du contexte du canvas
    const ctx3 = document.getElementById('f3').getContext('2d');

    // Données récupérées depuis le backend (Laravel Blade)
    const pendingTransfers = {{ $pendingTransfers + 12 }};
    const acceptedTransfers = {{ $acceptedTransfers + 12 }};
    const rejectedTransfers = {{ $rejectedTransfers + 12 }};

    // Calcul du total des transferts
    const total = pendingTransfers + acceptedTransfers + rejectedTransfers;

    // Affichage du total dans le paragraphe HTML
    document.getElementById('totalTransfers').textContent = `Total des transferts: ${total}`;

    // Données pour le graphique Doughnut
    const data = {
      labels: ['Transferts en attente', 'Transferts acceptés', 'Transferts rejetés'],
      datasets: [{
        data: [pendingTransfers, acceptedTransfers, rejectedTransfers],
        backgroundColor: ['rgb(255, 99, 132)', 'rgb(54, 162, 235)', 'rgb(255, 205, 86)'],
        hoverOffset: 4
      }]
    };

    // Création du graphique Doughnut
    new Chart(ctx3, {
      type: 'doughnut',
      data: data,
    });
  })();
</script>
