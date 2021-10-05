<template>
  <loading v-if="loading"></loading>
  <div v-else>
    <dashboard-card :cards="cards"></dashboard-card>
    <dashboard-chart :visits="visits"></dashboard-chart>
  </div>
</template>

<script>
import DashboardCard from "./DashboardCard.vue";
import DashboardChart from "./DashboardChart.vue";

export default {
  components: {
    DashboardCard,
    DashboardChart,
  }, //end of components

  data() {
    return {
      loading: true,
      cards: null,
      visits: null,
    };
  }, //end of data

  methods: {
    getData() {
      axios
        .get(`/api/admin/dashboard`)
        .then((response) => {
          this.cards = response.data.cards;
          this.visits = response.data.visits;
        })
        .then(() => {
          this.loading = false;
        });
    }, //end of getData
  }, //endo of methods

  created() {
    this.getData();
  }, //end of created
};
</script>