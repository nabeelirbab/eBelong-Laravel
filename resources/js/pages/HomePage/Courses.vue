<template>
  <div>
    <div v-isvisible.scroll="" class="container">
      <div class="e-freelancer mt-5 mb-5">
        <div class="e-freelancer__header">Featured Courses</div>
        <div class="e-freelancer__content">
          <splide :options="options">
            <splide-slide
              class="e-freelancer__item"
              v-for="item in items"
              :key="item.id"
            >
              <div
                class="e-freelancer-full-box c-pointer"
                v-on:click="() => onClick(item.slug)"
              >
                <img
                  v-if="item.is_certified == 1"
                  class="home-certified-logo"
                  :src="`${baseUrl}/images/certified/Certified_Icon.png`"
                />
                <img
                  v-if="item.is_instructor == 1"
                  class="home-instructor-logo"
                  :src="`${baseUrl}/images/instructor/instructor_logo.png`"
                />

                <div class="e-freelancer__item-image">
                  <img :src="item.imagePath" :alt="item.first_name" />
                </div>

                <div class="e-freelancer__item-title" style="font-size: 15px;">
                  <!-- {{ item.first_name }} {{ item.last_name }} -->
                  {{ item.title }}
                </div>
                <div class="e-freelancer__item-skill text-center">
                  {{ item.sellerName }}
                </div>
              <!--   <div
                  v-if="item.has_agency == 1 && item.agency_avatar != null"
                  class="e-freelancer__item-agency text-center"
                >
                  <div class="e-freelancer__item-agency-image">
                    <img
                      class="e-freelancer__item-agency-image-area"
                      :src="`${baseUrl}/uploads/agency_logos/${item.agency_id}/${item.agency_avatar}`"
                    />
                  </div>
                  <div class="e-freelancer__item-agency-text">
                    <a v-bind:href="'agency/' + item.agency_slug">{{
                      item.agency_name
                    }}</a>
                  </div>
                </div>
                <div
                  v-if="item.has_agency == 1 && item.agency_avatar == null"
                  class="e-freelancer__item-agency text-center"
                >
                  <div class="e-freelancer__item-agency-image">
                    <img
                      class="e-freelancer__item-agency-image-area"
                      :src="`${baseUrl}/uploads/settings/general/imgae-not-availabe.png`"
                    />
                  </div>
                  <div class="e-freelancer__item-agency-text">
                    <a v-bind:href="'agency/' + item.agency_slug">{{
                      item.agency_name
                    }}</a>
                  </div>
                </div> -->

                <div class="e-freelancer__item-rating my-2 mb-4">
                  <span v-if="item.user_type == '' || item.user_type =='Remote'">Remote</span>
                  <span v-else>In-Person</span>              
                </div> 
                <div class="e-freelancer__item-price" v-if="item.is_featured == 'true'">
                  <span> ${{ item.price }} </span>
                </div>
              </div>
            </splide-slide>
          </splide>
        </div>
        <div class="text-center mt-5">
          <!-- <button ref="submit" class="e-button e-button-whitebackground">
                See all
      </button> -->
          <a
            class="e-button e-button-whitebackground"
            v-bind:href="'/courses'"
            >See all</a
          >
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import index from "../../components/pageBuilder/edit----------/app/index.vue";
export default {
  components: { index },
  name: "Courses",
  props: ["items"],

  methods: {
    onClick(name) {
      window.location.replace(`${this.url}${name}`);
    },
  },
  data() {
    return {
      baseUrl: window.APP_URL,
      url: window.APP_URL + "/course/",
      options: {
        rewind: true,
        pagination: false,
        perPage: 4,
        gap: "20px",
        breakpoints: {
          768: {
            perPage: 1,
            padding: {
              right: "5rem",
            },
          },
          400: {
            perPage: 1,
          },
        },
      },
    };
  },
};
</script>
