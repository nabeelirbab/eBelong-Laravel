<template>
    <div class="banner animate__animated animate__lightSpeedInRight  "  v-animate-onscroll="'animate__animated animate__lightSpeedInRight'">
    <div class="container">        
    <div class="banner-content">
        <div class="banner-content__title pb-3">
            Hire Freelance Talent
        </div>
        <div class="banner-content__subtitle pb-5">For most demanding and challenging jobs</div>
        <div class="banner-content__search d-flex pb-3"  >
            
           <vue-bootstrap-typeahead
            :data="items"
            :serializer="item => item.name"
            v-model="query"
            @hit="selectedQuery = $event"
            class="e-input-field banner-content__search--input" placeholder="Search for Designers, Developers and more"/><button v-on:click="()=>onClick()" class="e-button e-button-primary">
                <span class="d-none d-md-block">Search</span><i class="fas fa-search d-block d-md-none"></i></button>
            
        </div>
        <div>
        <span v-on:click="()=>onClick(item.slug)" class="banner-content__items pr-2" v-for="(item,i) in items" :key="i">
            <span class="pr-1 c-pointer" v-if="i < 4">{{item.name}}</span>
        </span>
        </div>
    </div>
    <div class="banner-slider">

    </div>
    </div>
    </div>
</template>
<script>
export default {
  name: "BannerContent",
  data(){
      return {
          items:[],
          query:'',
          selectedQuery:null,
          url: window.APP_URL + '/search-results'
      }
  },
  methods:{
      onClick(slug){
         if(!slug) slug = this.items.find(obj=>obj.name === this.query).slug;
         window.location.replace(`${this.url}?type=freelancer&s=&skills[]=${slug}`);
      }
  },
  mounted: function(){
      axios.post(APP_URL + '/search/get-searchable-data',{
             type:'freelancer'
      }).then(response=>this.items = response.data.searchables)
  }
  
};
</script>