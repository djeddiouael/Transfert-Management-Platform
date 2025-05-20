<div>
  <canvas id="transferTimelineChart" style="height:200px;"></canvas>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<!-- Script Chart.js -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const chartElement = document.getElementById('transferTimelineChart');
    if (!chartElement) {
      console.warn('Canvas with id "transferTimelineChart" not found.');
      return;
    }

    const timelineCtx = chartElement.getContext('2d');

    new Chart(timelineCtx, {
      type: 'line',
      data: {
        labels: {!! json_encode(($monthlyStats ?? collect())->pluck('month')) !!},
        datasets: [
          {
            label: '@lang("transfer.status.pending")',
            data: {!! json_encode(($monthlyStats ?? collect())->pluck('pending_count')) !!},
            borderColor: 'rgba(255, 159, 64, 1)',
            backgroundColor: 'rgba(255, 159, 64, 0.2)',
            fill: true
          },
          {
            label: '@lang("transfer.status.accepted")',
            data: {!! json_encode(($monthlyStats ?? collect())->pluck('accepted_count')) !!},
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            fill: true
          },
          {
            label: '@lang("transfer.status.rejected")',
            data: {!! json_encode(($monthlyStats ?? collect())->pluck('rejected_count')) !!},
            borderColor: 'rgba(255, 99, 132, 1)',
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            fill: true
          }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: {
          intersect: false,
          mode: 'index'
        },
        scales: {
          y: {
            beginAtZero: true,
            stacked: true
          }
        }
      }
    });
  });
</script>
