import VueApexCharts from "vue3-apexcharts";
import VPdf from "@whykhamist/vpdf";

import "@whykhamist/vpdf/style.css";

export default defineNuxtPlugin(({ vueApp }) => {
  vueApp.use(VueApexCharts);
  vueApp.use(VPdf);
});
