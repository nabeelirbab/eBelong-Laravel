<template>
  <div v-if="isShow">
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
export default {
  data() {
    return {
      baseUrl: APP_URL,
      countValue: 0,
      isShow: true,
    };
  },
  created() {
    this.$bus.$on("cookie-updated", this.init);
    this.init();
  },
  methods: {
    init() {
      if (this.$cookies.get("candidateIds")) {
        this.countValue = JSON.parse(this.$cookies.get("candidateIds")).length;
      } else {
        this.countValue = 0;
      }
    },
  },
};
</script>
