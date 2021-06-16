<template>
<div>
<div class="trusted_partner">
  <div class="trusted_partner__items container d-flex flex-wrap justify-content-between align-items-center">

    <div class="py-2 py-md-4 bannerjob__item text-center">Trusted by:</div><br/>
    <div class="py-2 py-md-4"><img :src="`${baseUrl}/images/home/trusted_by_1.svg`"/></div>
    <div class="py-2 py-md-4"><img :src="`${baseUrl}/images/home/trusted_by_2.svg`"/></div>
    <div class="py-2 py-md-4"><img :src="`${baseUrl}/images/home/trusted_by_3.svg`"/></div>
    <div class="py-2 py-md-4"><img :src="`${baseUrl}/images/home/trusted_by_4.svg`"/></div>
    <div class="py-2 py-md-4"><img :src="`${baseUrl}/images/home/trusted_by_5.svg`"/></div>


  </div>
</div>
  <div v-isvisible.scroll="" class="container">
    <div class="e-freelancer mt-5 mb-5">
      <div class="e-freelancer__header">Our Super Star Talent</div>
      <div class="e-freelancer__content">
        <splide :options="options">
          <splide-slide
           
            class="e-freelancer__item"
            v-for="item in items"
            :key="item.id"
          >
            
            <!-- <img v-if="item.is_certified == 1" style="margin-left: 180px;height: 40px;" :src="`${baseUrl}/images/certified/Certified_Icon.png`"/> -->
            <img v-if="item.is_certified == 1" style="position: absolute; top: 10px; right: 8px; max-width: 50px;" :src="`${baseUrl}/images/certified/Certified_Icon.png`"/>


            <div  v-on:click="() => onClick(item.slug)" class="e-freelancer__item-image c-pointer">
              <img :src="item.imagePath" :alt="item.first_name" />
            </div>
            <div class="e-freelancer__item-title" >
              {{ item.first_name }} {{ item.last_name }}
            </div>
            <div class="e-freelancer__item-skill text-center">
              {{ item.tagline }}
            </div>
            <div class="e-freelancer__item-rating my-2 mb-4">
               <span class="wt-stars"><span :style="{'width': item.rating_width+'%'}"></span></span>
            </div>
            <div class="e-freelancer__item-price">
              <span> ${{ item.hourly_rate }}/hr </span>
            </div>
          </splide-slide>
                  </splide>
      </div>
      <div class="text-center mt-5">
      <!-- <button ref="submit" class="e-button e-button-whitebackground">
                See all
      </button> -->
      <a class="e-button e-button-whitebackground" v-bind:href="'/search-results?type=freelancer'">See all</a>
      </div>      
    </div>
  </div>
</div>
</template>
<script>
import index from '../../components/pageBuilder/edit----------/app/index.vue';
export default {
  components: { index },
  name: "Slider",
  props: ["items"],

  methods: {
    onClick(name) {
      window.location.replace(`${this.url}${name}`);
    },
  },
  data() {
    return {
      baseUrl:window.APP_URL,
      url: window.APP_URL + "/profile/",
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