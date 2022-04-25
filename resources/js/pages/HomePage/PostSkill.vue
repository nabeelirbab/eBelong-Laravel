<template>
  <div class="container">
    <div class="e-postskill" id="scroll-id">
      <div class="e-postskill__header">
        <div class="e-postskill__header_title">
          Speed up your hiring process
        </div>
        <div class="e-postskill__header_description">
          Share your requirements with our CTO instantly
        </div>
        <div class="e-postskill__header_description1">
          <span>-- Get 100 hours of FREE project work --</span>
        </div>
      </div>
      <notifications group="success_message" position="top right" />
      <div class="e-postskill__content">
        <step-1
          :categories="items.categories"
          :selectedCategories="selectedCategories"
          :step="step"
          @updateData="updateData"
          v-if="step == 1"
        ></step-1>
        <step-2
          :skills="items.skills"
          :selectedSkills="selectedSkills"
          :wantedPositions="wantedPositions"
          :selectedCategories="selectedCategories"
          :step="step"
          v-if="step == 1"
          @updateData="updateData"
        ></step-2>
        <step-3
          :range_data="range_data"
          :step="step"
          v-if="step == 3"
          @updateData="updateData"
        ></step-3>
        <step-4
          :range_data="range_data"
          :selectedCategories="selectedCategories"
          :selectedSkills="selectedSkills"
          :wantedPositions="wantedPositions"
          :accountDetails="accountDetails"
          :step="step"
          v-if="step == 4"
          @updateData="updateData"
        ></step-4>
      </div>
    </div>

    <div class="e-postskill-modal" v-if="show_modal">
      <div class="modal-background">
        <div class="custom-modal-container">
          <div class="modal-title">
            <h6>
              Awesome, difficult part is over
              <span class="displayFormName">{{
                this.$cookies.get("storedUserName")
              }}</span
              >, Next step is to connect you with our team of experts who will
              help you through out your project, Free of cost.
            </h6>
            <h6 class="modal-title-2">
              Stay tuned, someone will reach you shortly!
            </h6>
          </div>

          <div class="mob-slider">
            <carousel :autoplay="true" :nav="false" :items="1">
              <img :src="`${baseUrl}/images/ebelong-Interim-CTO.png`" />
              <img :src="`${baseUrl}/images/eBelong-Product-Lead.jpeg`" />
              <img :src="`${baseUrl}/images/ebelong-chief-marketing.jpg`" />
            </carousel>
          </div>

          <div class="desktop-images">
            <div class="row">
              <div class="col-lg-4">
                <img :src="`${baseUrl}/images/ebelong-Interim-CTO.png`" />
              </div>
              <div class="col-lg-4">
                <img :src="`${baseUrl}/images/eBelong-Product-Lead.jpeg`" />
              </div>
              <div class="col-lg-4">
                <img :src="`${baseUrl}/images/ebelong-chief-marketing.jpg`" />
              </div>
            </div>
          </div>

          <div class="modal-footer">
            <button class="e-button e-button-primary" @click="onClickFunction">
              OK
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Step1 from "./PostSkill/Step1.vue";
import Step2 from "./PostSkill/Step2.vue";
import Step3 from "./PostSkill/Step3.vue";
import Step4 from "./PostSkill/Step4.vue";
import Vue from "vue";
import VueCookies from "vue-cookies";
Vue.use(VueCookies);

import carousel from "vue-owl-carousel2";
// import sourceimage from '../../../../public/404-img.jpg';
const initalData = {
  step: 1,
  selectedCategories: [],
  selectedSkills: [],
  accountDetails: {
    fullName: "",
    phoneNumber: "",
    email: "",
  },
  percentangeDetails: {},
  range_data: {},
  wantedPositions: null,
};

export default {
  name: "PostSkill",
  components: {
    Step1,
    Step2,
    Step3,
    Step4,
    carousel,
  },
  props: ["items"],
  data() {
    return {
      baseUrl: window.APP_URL,
      ...initalData,
      show_modal: false,
      // cookieValue:
    };
  },
  mounted() {
    window.postskill = this.$refs.postskill;
  },
  methods: {
    updateData(key, value) {
      this[key] = value;
    },

    onClickFunction: function (event) {
      this.show_modal = false;
      window.location.href = this.baseUrl;
    },
  },
  watch: {
    step: function (value) {
      if (value == 5) {
        //     this.$notify({
        //     group:'success_message',
        //     type:'success',
        //     duration:5000,
        //     text:'Your request submitted successfully, We will get back to please stay tuned'

        // })
        this.show_modal = true;
        Object.keys(initalData).map((key) => {
          this[key] = initalData[key];
        });
      }
    },
  },
};
</script>

<style scoped>
.e-postskill-modal {
  position: fixed;
  z-index: 21474836455;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}
.e-postskill-modal .modal-background {
  position: relative;
  width: 100%;
  padding-top: 60px;
}
.e-postskill-modal .custom-modal-container {
  width: 85%;
  text-align: center;
  margin: 0px auto;
  background-color: white;
  padding: 20px;
  right: 0;
  left: 0;
  position: absolute;
}
.e-postskill-modal .modal-footer {
  padding-top: 0.75rem;
}
.e-postskill-modal .mob-slider {
  margin: 1rem 0px;
}
.e-postskill-modal .desktop-images {
  margin: 1rem 0px;
}
.e-postskill-modal .mob-slider {
  display: none;
}
.e-postskill-modal .desktop-images {
  display: block;
}
.e-postskill-modal .desktop-images img {
  box-shadow: 0px 0px 12px 5px rgba(0, 0, 0, 0.21);
  -webkit-box-shadow: 0px 0px 12px 5px rgba(0, 0, 0, 0.21);
  -moz-box-shadow: 0px 0px 12px 5px rgba(0, 0, 0, 0.21);
}
.e-postskill-modal .mob-slider {
  box-shadow: 0px 0px 12px 5px rgba(0, 0, 0, 0.21);
  -webkit-box-shadow: 0px 0px 12px 5px rgba(0, 0, 0, 0.21);
  -moz-box-shadow: 0px 0px 12px 5px rgba(0, 0, 0, 0.21);
}
.e-postskill-modal .modal-title h6 {
  color: #474747;
  font-family: "Poppins", sans-serif;
  text-transform: unset;
  text-align: center;
  font-size: 15px;
  font-weight: 500;
}
.e-postskill-modal .modal-title h6 .displayFormName {
  color: #3a0b5f;
  font-weight: 700;
  text-transform: capitalize;
}

@media only screen and (max-width: 768px) {
  .e-postskill-modal .custom-modal-container {
    width: 75%;
    right: 0;
    left: 0;
    position: absolute;
  }
  .e-postskill-modal .mob-slider {
    margin: 1rem 0px;
  }
  .e-postskill-modal .mob-slider {
    display: block;
  }
  .e-postskill-modal .desktop-images {
    display: none;
  }
  .e-postskill-modal .modal-background {
    padding-top: 50px;
  }
  .e-postskill-modal .modal-title h6 {
    font-size: 0.8rem;
  }
}
@media only screen and (max-width: 512px) {
  .e-postskill-modal .custom-modal-container {
    width: 90%;
    right: 0;
    left: 0;
  }
}

/* .modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 85%;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}
@media only screen and (max-width: 768px) {
  .modal-container {
  width: 85%;
  }
} */

/* .modal-container .mob-slider {
    display: none;
  }
@media only screen and (max-width: 768px) {
  .modal-container .desktop-images {
    display: none;
  }
  .modal-container .mob-slider {
    display: block;
  }
} */
/* 
.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}
.modal-title h6 {
    color: #474747;
    text-transform: unset;
        text-align: center;
} */

/* .modal-body {
  margin: 20px 0;
}
.modal-body img {
    width: 100%;
}

.modal-default-button {
  float: right;
} */

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

/* .modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
} */
</style>
