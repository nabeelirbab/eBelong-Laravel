<template>
  <div class="why_ebelong">
    <div class="why_ebelong_section">
      <div class="container">
        <div class="row">
          <div class="col-sm-12 col-md-6">
            <div class="why_ebelong_title">
              <h3>Why eBelong?</h3>
            </div>
            <div class="why_ebelong_discription">
              <p>
                We know how difficult it can be to quickly expand your team with
                key development resources while maintaining the continuity and
                velocity required to stay on time and in budget. When our
                customers need experienced resources for their team or project, 
                they call us and that’s why 100’s of other engineering firms
                continue to call upon us to meet their needs and that’s why you
                can call on us too.
              </p>
            </div>
            <div class="why_ebelong_btn">
              <!-- <button v-on:click="onClickButton" class="banner1-button e-button e-button-primary">
                Read more
              </button> -->
              <a class="banner1-button e-button e-button-primary" v-bind:href="'/page/about-us'">Read more</a>
            </div>
          </div>
          <div class="col-sm-12 col-md-6">
            <div
              v-animate-onscroll.repeat="{ down: 'animated rollIn' }"
              class="why_ebelong_img d-none d-md-block"
            >
              <img
                :src="`${baseUrl}/images/home/whyebelong-1.png`"
                alt="post_job"
              />
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="why_ebelong_tiles">
      <div class="container">
        <div class="row">
          <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="card-body-img">
                  <img
                    :src="`${baseUrl}/images/home/tile-icon-1.svg`"
                    alt="icon"
                    style="width: 70%;"
                  />
                </div>
                <div class="card-body-title">
                  <h6>Engineering Staff Augmentation</h6>
                </div>
                <div class="card-body-description">
                  <p>
                    We provide dependable experts who will support your
                    development efforts ensuring you get projects done on-time
                    and in-budget.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="card-body-img">
                  <img
                    :src="`${baseUrl}/images/home/tile-icon-2.svg`"
                    alt="icon"
                    style="width: 40%;"
                  />
                </div>
                <div class="card-body-title">
                  <h6>Custom Software Development</h6>
                </div>
                <div class="card-body-description">
                  <p>
                    Our team is equipped to handle any development need you
                    have, big, small, mobile apps, compression and everything
                    in-between.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="card-body-img">
                  <img
                    :src="`${baseUrl}/images/home/tile-icon-3.svg`"
                    alt="icon"
                    style="width: 40%;"
                  />
                </div>
                <div class="card-body-title">
                  <h6>Integration</h6>
                </div>
                <div class="card-body-description">
                  <p>
                    We help integrate external services into your eCommerce
                    website creating significant efficiency and cost savings
                    for you.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="card-body-img">
                  <img
                    :src="`${baseUrl}/images/home/tile-icon-4.svg`"
                    alt="icon"
                    style="width: 40%;"
                  />
                </div>
                <div class="card-body-title">
                  <h6>Performance & Code Evaluation</h6>
                </div>
                <div class="card-body-description">
                  <p>
                    We will evaluate your code for targeted performance
                    improvements so you can provide best in class industry
                    metrics.
                  </p>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-2 col-md-4 col-sm-6 col-xs-6 mb-3">
            <div class="card">
              <div class="card-body">
                <div class="card-body-img">
                  <img
                    :src="`${baseUrl}/images/home/tile-icon-5.svg`"
                    alt="icon"
                    style="width: 40%;"
                  />
                </div>
                <div class="card-body-title">
                  <h6>QA Testing</h6>
                </div>
                <div class="card-body-description">
                  <p>
                    We can help upi nuil and execute a sold, comprehensive
                    test plan, test procedures, or a full testing team so that
                    your final project is world-class.
                  </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
// import index from "../../components/pageBuilder/edit----------/app/index.vue";
export default {
  // components: { index },
  name: "WhyeBelong",

  data() {
    return {
      baseUrl: window.APP_URL,
    };
  },
  methods:{
      onClickButton(){
        window.location.replace(`${baseUrl}/page/about-us`)
      }
  },
};
</script>