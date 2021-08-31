<template>
  <div class="container">
    <div class="e_featured_skill">
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
    </div>
  </div>
</template>
<script>
// import index from "../../components/pageBuilder/edit----------/app/index.vue";
export default {
  name: "FeaturedSkill",
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
          const featured = this.items.skills.filter(skill => skill.is_featured == 1)

          return featured.slice(0, 7)
      }
  }
  
};
</script>