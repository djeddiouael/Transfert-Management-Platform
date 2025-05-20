<div class="card" style="width: 100%; height: 300px;">
  <div class="card-body">
    <canvas id="f2" style="width: 100%; height: 100%;"></canvas>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
  // Fonction pour générer les mois dynamiquement
  function getMonths(count) {
    const months = [];
    const date = new Date();
    for (let i = 0; i < count; i++) {
      months.push(new Date(date.setMonth(date.getMonth() - 1)).toLocaleString('default', { month: 'short' }));
    }
    return months.reverse();
  }

  // Générer les mois dynamiquement (ici 7 derniers mois)
  const labels2 = getMonths(7); 

  // Données pour les 7 derniers mois (remplacer par vos données dynamiques)
  const data2 = {
    labels: labels2,
    datasets: [{
      label: 'Tendance mensuelle',  // Nom de la tendance sur l'axe des ordonnées
      data: [65, 59, 80, 81, 56, 55, 40],  // Exemple de données, à remplacer par des données dynamiques
      fill: false,
      borderColor: 'rgb(75, 192, 192)',  // Couleur de la ligne
      tension: 0.1
    }]
  };

  // Configuration du graphique
  const config2 = {
    type: 'line',
    data: data2,
    options: {
      responsive: true,
      maintainAspectRatio: false,
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  };

  // Initialiser le graphique sur le canvas
  const ctx2 = document.getElementById('f2').getContext('2d');
  new Chart(ctx2, config2);

  // Exemple de données dynamiques avec PHP (à intégrer dans votre code Laravel)
  // Remplacez les données de "labels2" et "data2" par celles venant de votre backend
  // const labels2 = {!! json_encode($monthlyStats->pluck('month')) !!};
  // const data2 = {
  //   labels: labels2,
  //   datasets: [{
  //     label: 'Tendance mensuelle',
  //     data: {!! json_encode($monthlyStats->pluck('count')) !!},
  //     fill: false,
  //     borderColor: 'rgb(75, 192, 192)',
  //     tension: 0.1
  //   }]
  // };
</script>
