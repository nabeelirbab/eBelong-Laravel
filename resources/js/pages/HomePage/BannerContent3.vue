<template>
    <div class="banner animate__animated animate__lightSpeedInRight  "  v-animate-onscroll="'animate__animated animate__lightSpeedInRight'">
        <!-- <div class="container">   -->
        <div class="">        
            <div class="banner-content">
                <div class="banner-content__title pb-3">
                    Hire an AI Team of experts to develop your next product
                </div>
                <div class="banner-content__subtitle pb-5">For most demanding and challenging jobs</div>
                <div class="banner-content__search d-flex pb-3"  >
                    <vue-bootstrap-typeahead
                        :data="skills"
                        :serializer="item => item.name"
                        v-model="query"
                        @hit="selectedQuery = $event"
                        class="e-input-field banner-content__search--input" placeholder="Search for Designers, Developers and more"/><button v-on:click="()=>onClick()" class="e-button e-button-primary">
                    <span class="d-none d-md-block">Search</span><i class="fas fa-search d-block d-md-none"></i></button>
                </div>
            <div class="home_slider_skill">
                <ul class="e-project-type__list">
                    <li
                        v-on:click="()=>onClick(item.slug)"
                        v-for="(item,index) in featuredItems"
                        :load="log(item)"
                        :key="index"
                        class="e-project-type__list--item"
                    >
                    <img :src="`/uploads/logos/${item.logo}`" style="width:15px"/>
                    {{ item.title }}
                    </li>
                </ul>
            
                    <!-- <div v-on:click="()=>onClick(item.slug)" class="banner-content__items pr-2" v-for="(item,i) in items.skills" :key="i">
                        <div class="pr-1 c-pointer" v-if="item.is_featured">
                            <div class="skill-img"><img :src="`/uploads/logos/${item.logo}`" style="width:15px"/></div>
                            <div class="skill-title">{{item.title}}</div>
                        </div>
                    </div> -->
                
        </div>
    </div>
    <div class="banner-slider">

    </div>
    </div>
    </div>
</template>
<!-- v-if="i < 4 && item.is_featured" -->
<script>
export default {
  name: "BannerContent",
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
         window.location.replace(`${window.APP_URL}/hire/${slug}`);
      },
      log(item) {
      console.log("featured items ", item)
    }
  },
  mounted: function(){
      axios.post(APP_URL + '/search/get-searchable-data',{
             type:'freelancer'
      }).then(response=>this.skills = response.data.searchables)
  },
  computed: {
      featuredItems() {

          return this.items.skills;
      }
  }
  
};
</script>