<div>
  <canvas id="f4" style="height:200px;"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx4 = document.getElementById('f4').getContext('2d');

const data4 = {
  datasets: [
    {
      label: 'Pending Transfers',
      data: [{
        x: 10,
        y: 20,
        r: {{ $pendingTransfers + 12 }}
      }],
      backgroundColor: 'rgb(255, 99, 132)'
    },
    {
      label: 'Accepted Transfers',
      data: [{
        x: 20,
        y: 10,
        r: {{ $acceptedTransfers + 12 }}
      }],
      backgroundColor: 'rgb(54, 162, 235)'
    },
    {
      label: 'Rejected Transfers',
      data: [{
        x: 15,
        y: 25,
        r: {{ $rejectedTransfers + 12 }}
      }],
      backgroundColor: 'rgb(255, 205, 86)'
    }
  ]
};

// ✅ Renommé pour éviter les conflits avec d'autres scripts
const totalTransfersBubbleChart = data4.datasets.reduce((sum, dataset) => {
  return sum + dataset.data.reduce((innerSum, item) => innerSum + item.r, 0);
}, 0);

console.log("Total Transfers: " + totalTransfersBubbleChart);

const config4 = {
  type: 'bubble',
  data: data4,
  options: {
    plugins: {
      tooltip: {
        callbacks: {
          label: function(context) {
            return context.dataset.label + ': ' + context.raw.r;
          }
        }
      }
    },
    scales: {
      x: {
        title: {
          display: true,
          text: 'X Axis'
        }
      },
      y: {
        title: {
          display: true,
          text: 'Y Axis'
        }
      }
    }
  }
};

new Chart(ctx4, config4);
</script>
