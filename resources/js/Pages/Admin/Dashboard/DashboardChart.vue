<template>
  <div>
    <canvas id="myChart" class="max-w-full overflow-auto" ref="ctx"></canvas>
  </div>
</template>

<script>
import Chart from "chart.js/auto";

export default {
  props: ["visits"],

  methods: {
    formatMonth(monthNumber) {
      const months = [
        "January",
        "February",
        "March",
        "April",
        "May",
        "June",
        "July",
        "August",
        "September",
        "October",
        "November",
        "December",
      ];
      return months[monthNumber - 1];
    }, //end of formatMonth

    buildChart() {
      let data = [];
      let labels = [];
      for (let index in this.visits) {
        labels.push(this.formatMonth(this.visits[index].month) + " " + this.visits[index].year);
        data.push(this.visits[index].count);
      }
      const ctx = this.$refs.ctx;
      new Chart(ctx, {
        type: "line",
        data: {
          labels: labels,
          datasets: [
            {
              label: "visits",
              data: data,
              fill: false,
              borderColor: "#FCA311",
              tension: 0.1,
            },
          ],
        },
      });
    }, //end of buildChart
  }, //end of methods

  mounted() {
    this.buildChart();
  }, //end of created
};
</script>