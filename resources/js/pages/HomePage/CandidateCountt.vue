<template>
  <div id="candidate_count">
    <div class="candidate_count">
      <a :href="baseUrl + '/wishlist'">
        <img :src="`${baseUrl}/uploads/candidates.png`" alt="candidate count" />
      </a>
    </div>
    <div class="count">
      <h5>{{ countValue }}</h5>
    </div>
  </div>
</template>
<script>
// import index from "../../components/pageBuilder/edit----------/app/index.vue";
import Vue from "vue";
import VueCookies from "vue-cookies";
Vue.use(VueCookies);

export default {
  name: "CandidateCountt",
  data() {
    return {
      baseUrl: APP_URL,
      countValue: "0",
    };
  },
  mounted() {
    let self = this;
    console.log("count length home page  ::: ");
    if (this.$cookies.get("candidateIds")) {
      const numArray = JSON.parse(this.$cookies.get("candidateIds")).length;
      console.log("count length home page  ::: ", JSON.stringify(numArray));
      self.countValue = JSON.stringify(numArray);
    }
  },
};
</script>
