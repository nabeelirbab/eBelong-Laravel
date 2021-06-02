<template>
    <div class="banner animate__animated animate__lightSpeedInRight  "  v-animate-onscroll="'animate__animated animate__lightSpeedInRight'">
        <!-- <div class="container">   -->
        <div class="">        
            <div class="banner-content">
                <div class="banner-content__title pb-3">
                    Speed up your hiring process

                </div>
                <div class="banner-content__subtitle pb-5">Share your requirements with our CTO instantly</div>
                <button @click="scrollfunction" class="banner1-button e-button e-button-primary">Let's Get Started</button>
                <!-- <div class="banner-content__search d-flex pb-3"  >
                    <vue-bootstrap-typeahead
                        :data="skills"
                        :serializer="item => item.name"
                        v-model="query"
                        @hit="selectedQuery = $event"
                        class="e-input-field banner-content__search--input" placeholder="Search for Designers, Developers and more"/><button v-on:click="()=>onClick()" class="e-button e-button-primary">
                    <span class="d-none d-md-block">Search</span><i class="fas fa-search d-block d-md-none"></i></button>
                </div> -->
            </div>
            <!-- <ul class="e-project-type__list">
                <li
                    v-on:click="()=>onClick(item.slug)"
                    v-for="(item,index) in items.skills"
                    v-if="item.is_featured"
                    :key="index"
                    class="e-project-type__list--item"
                >
                <img :src="`/uploads/logos/${item.logo}`" style="width:15px"/>
                {{ item.title }}
                </li>
            </ul>  -->
        </div>
        <div class="banner-slider">

        </div>
    </div>
</template>
<!-- v-if="i < 4 && item.is_featured" -->
<script>
export default {
  name: "BannerContent1",
  props: ['items'],
  data(){
      return {
          skills:[],
          query:'',
          selectedQuery:null,
          url: window.APP_URL + '/search-results'
      }
  },
  methods:{
      onClick(slug){
         if(!slug) slug = this.skills.find(obj=>obj.name === this.query).slug;
         window.location.replace(`${this.url}?type=freelancer&s=&skills[]=${slug}`);
      },
      scrollfunction() {
      const element = document.getElementById('scroll-id');
      element.scrollIntoView({ behavior: 'smooth' });
    }
  },
  mounted: function(){
      axios.post(APP_URL + '/search/get-searchable-data',{
             type:'freelancer'
      }).then(response=>this.skills = response.data.searchables)
  }
  
};
</script>