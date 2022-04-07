<template>
  <div class="candidate_wishlist">
    <h1>My Project Team</h1>

    <h5 v-if="isCandidates">
      Add to my team !
      <a :href="baseUrl + '/search-results?type=freelancer'"> Start here </a>
    </h5>
    <h5 v-else>
      You haven't selected any candidate yet !
      <a :href="baseUrl + '/search-results?type=freelancer'"> Start here </a>
    </h5>

    <div v-if="isCandidates" class="candidate_wishlist_data container">
      <!-- <ul>
          <li v-for="(ca, index) in selectedCandidate" :key="`ca-${index}`">{{ca}}</li>
        </ul> -->
      <div class="row find-talent-freelancers">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <div class="find-talent">
            <div class="find-talent-candidate">
              <div
                v-for="(ca, index) in selectedCandidate"
                class="row samemargin verticlealign"
                :key="`candidate-${index}`"
              >
                <div class="removeCandidate">
                  <button
                    v-if="isHidden"
                    @click="getCandidateId(index)"
                    class="e-button e-button-primary"
                  >
                    X
                  </button>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 removepaddingleft">
                  <figure class="wt-userlistingimg">
                    <img :src="ca.avater_imagePath" alt="candidate img" />
                  </figure>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 removepadding">
                  <div class="find-talent-info">
                    <div class="wt-title">
                      <a :href="baseUrl + '/profile/' + ca.slug">
                        <i class="fa fa-check-circle"></i>
                        {{ ca.first_name }} {{ ca.last_name }}
                      </a>
                    </div>
                    <div class="wt-talent-skill">
                      <a href="#">{{ ca.skill }}</a>
                    </div>
                    <div class="wt-talent-location">
                      <span class="wt-locationarea" v-if="ca.location_title">
                        <img :src="ca.location_imagePath" alt="US" />
                        {{ ca.location_title }}
                      </span>
                    </div>
                  </div>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 removepadding">
                  <a
                    href="#"
                    class="instructor-badge"
                    v-if="ca.instructor == 1"
                  >
                    <img
                      class="fix-blury-image-issue"
                      :src="`${baseUrl}/images/instructor/instructor_logo.png`"
                    />
                  </a>

                  <a
                    href="#"
                    class="certified-badge"
                    v-if="ca.is_certified == 1"
                  >
                    <img
                      :src="`${baseUrl}/images/certified/Certified_Icon.svg`"
                    />
                  </a>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 removepadding">
                  <span class="wt-hourlyrate">
                    <span> ${{ ca.hourly_rates }} / hr </span>
                  </span>
                </div>
                <div class="col-lg-2 col-md-12 col-sm-12 removepadding">
                  <input
                    v-model="selectedCandidate[index].hours"
                    class="esthours"
                    placeholder="est. No of hours"
                  />
                </div>
                <div class="col-lg-1 col-md-12 col-sm-12 removepadding">
                  <div class="equalsign">=</div>
                </div>
                <div class="col-lg-1 col-md-12 col-sm-12 removepadding">
                  <div class="individualresult">
                    $ {{ subTotalAmount(index) }}
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row find-talent-freelancers-total-est-cost">
        <div class="col-lg-2 col-md-12 col-sm-12"></div>
        <div class="col-lg-8 col-md-12 col-sm-12">
          <div class="est-cost-heading">Total Est. Project Cost</div>
        </div>
        <div class="col-lg-2 col-md-12 col-sm-12">
          <div class="est-cost-totle">$ {{ totalAmount }}</div>
        </div>
      </div>
      <div class="row countinue-btn">
        <div class="col-lg-12 col-md-12 col-sm-12">
          <button
            v-if="isHidden"
            @click="speedUpProcessing"
            class="e-button e-button-primary"
          >
            Continue
          </button>
          <div class="postskillcomponent" v-if="isSpeedupProcessing">
            <PostSkill :items="items" />
          </div>
        </div>
      </div>
    </div>
    <div v-else class="candidate_wishlist_no_data">
      <div class="candidate_wishlist_no_data_heading">
        <h5>Cannot find what you are looking for?</h5>
        <a :href="baseUrl">Skip this Step </a>
        <h5>and let us find the right candidates for you</h5>
      </div>
    </div>
  </div>
</template>
<script>
// import index from "../../components/pageBuilder/edit----------/app/index.vue";
// import Vue from "vue";
import PostSkill from "../pages/HomePage/PostSkill.vue";
// import VueCookies from "vue-cookies";
// Vue.use(VueCookies);

export default {
  components: { PostSkill },
  // name: "CandidateWishlist",

  data() {
    return {
      baseUrl: APP_URL,
      // baseURL: APP_URL,
      isCandidates: false,
      isSpeedupProcessing: false,
      isHidden: true,
      selectedCandidate: [],
      // selectedCandidate: [
      //   { name: 'apple', hourly_rates: '255', location: 'USA', skill: 'eCommerce', hours: 0 },
      //   { name: 'orange', hourly_rates: '50', location: 'Pakistan', skill: 'ReactJs', hours: 0 }
      // ]
      items: {
        categories: [],
        skills: [],
      },
    };
  },
  mounted() {
    let self = this;
    var numArray = JSON.parse(this.$cookies.get("candidateIds"));
    if (numArray) {
      console.log("numArray ::: ", numArray);
      self.isCandidates = true;
      axios
        .post(APP_URL + "/get-wishlist-freelancers", {
          ids: numArray,
        })
        .then(function (response) {
          console.log("selected candidate", response);
          if ((response.data.type = "success")) {
            self.selectedCandidate = response.data.data.map((data) => ({
              ...data,
              hours: 40,
              hourly_rates: data.hourly_rates || 0,
            }));
          }
        });
      axios.get(APP_URL + "/get-skills-for-wishlist").then(function (response) {
        if (response.data.type == "success") {
          console.log("skillssss", response);
          self.items.skills = response.data.skills;
        }
      });
      axios
        .get(APP_URL + "/get-categories-for-whishlist")
        .then(function (response) {
          if (response.data.type == "success") {
            console.log("skillssss", response);
            self.items.categories = response.data.categories;
          }
        });
    }
  },
  methods: {
    subTotalAmount(index) {
      var numArray = [];
      this.selectedCandidate.map((person) =>
        numArray.push(parseInt(person.hours))
      );
      this.$cookies.set("candidateIdsHours", JSON.stringify(numArray));
      // console.log("get candidate index", numArray);
      console.log(
        "get candidate index",
        JSON.parse(this.$cookies.get("candidateIdsHours"))
      );
      console.log(
        "get candidate index",
        JSON.parse(this.$cookies.get("candidateIds"))
      );
      // var r = {},
      //   keys = JSON.parse(this.$cookies.get("candidateIds")),
      //   values = JSON.parse(this.$cookies.get("candidateIdsHours"));

      // for (let i = 0; i < keys.length; i++) {
      //   r[keys[i]] = values[i];
      // }

      // console.log("get candidate index rrrrrr", r);

      const hours = parseInt(this.selectedCandidate[index].hours);
      const rate = parseInt(this.selectedCandidate[index].hourly_rates);
      return hours ? hours * rate : 0;
    },
    speedUpProcessing: function (event) {
      (this.isSpeedupProcessing = true), (this.isHidden = false);
    },
    getCandidateId: function (index) {
      const candidateArray = this.selectedCandidate.splice(index, 1);

      var newCandidateArray = this.selectedCandidate.map((person) => person.id);

      if (newCandidateArray.length === 0) {
        console.log("array is empty");
        this.$cookies.remove("candidateIds");
        this.isCandidates = false;
      } else {
        console.log("array not empty");
        this.$cookies.set("candidateIds", JSON.stringify(newCandidateArray));
        console.log("candidateIds arr if ", this.$cookies.get("candidateIds"));
      }
      location.reload();
      this.$bus.$emit("cookie-updated");
      console.log("candidate array ", newCandidateArray.length);
      console.log(
        "candidate cookies ",
        JSON.parse(this.$cookies.get("candidateIds"))
      );
    },
  },
  computed: {
    totalAmount() {
      let sum = 0;

      this.selectedCandidate.map((candidate) => {
        const hours = parseInt(candidate.hours);
        const rate = parseInt(candidate.hourly_rates);

        sum += hours ? hours * rate : 0;
      });

      return sum;
    },
  },
};
</script>
