<template>
  <div  class="bannerjob py-5 d-md-block">
  <div class="container">
    <h2 v-animate-onscroll.repeat="'animated flash'" class="text-center bannerjob__title pb-4">How eBelong works</h2>
    <div
      class="bannerjob__content d-md-flex justify-content-between"
    >
      <div>
        <ul class="bannerjob__items number" style="background:#F5F5F5;position: relative; left: -10px">
          <li v-for="(item,i) in items" :class="{'bannerjob__item-selected' : i===selected}" @click="selected = i" :key='i' class="bannerjob__item pb-4"> {{item}} </li>
        </ul>
      </div>
      <div>
        <img class="bannerjob__image" style="width:300px" :src="`${APP_URL}/images/home/layer_${selected+1}.svg`"/>
        <div class="bannerjob__image__text">Provide a little info and we’ll connect you with one of eBelong's CTOs.</div>
      </div>
      <div style="position: absolute; bottom: -20px;left:20px">
        <button v-on:click="onClick()" class="e-button e-button-primary">Let's Get Started</button>
        <!-- <button v-on:click="goto('art1')" class="e-button e-button-primary">Let's Get Started</button> -->
      </div>
      <div class="bannerjob__bullets d-none d-md-flex" style="position: absolute; bottom: -10px; left: 0; right: 0">
        <ul class="">
          <li v-for="(item,i) in items" :key="i" v-on:click="()=>selected=i" :class="{'bannerjob__bullet-active' : i===selected}" class="bannerjob__bullet"></li>
        </ul>
      </div>
    </div>
  </div>
  </div>
</template>
<script>
export default {
  name: "BannerJob",
  data(){
      return {
          APP_URL:window.APP_URL,
          items:[
              'Tell Us Who You Need',
              'Meet Your Talent',
              'Get Work Done',
              'Make secure payment'
          ],
          selected:0
      }
  },
  methods:{
    onClick(){
      let el = window.postskill;
      // Get the bounding rectangle so we can get the element position position
      el.scrollIntoView()
      
    }
    
  },
  mounted:function(){
      setInterval(()=>{
          this.selected = this.selected === 3 ? 0 : this.selected + 1;
      },4000)
  }
};
</script>
<style scoped>
ul.number {
	list-style-type: none;
	counter-reset: li;
}

ul.number li:before {
  counter-increment: li;
  content: counter(li, decimal-leading-zero);
	/* color: red; */
	margin-right: 1rem;
}
ul.number li.bannerjob__item-selected::after{

  content: "";
  position: absolute;
  width: 40%;
  height: 6px;
  border-radius: 2px;
  margin-left: 1.5rem;
  margin-top: 0.7rem;
  background: linear-gradient( 
  90deg
  ,#9013F3 41.07%,#D413F3 76.05%);
}
@media screen and (max-width: 768px) {
  ul.number li.bannerjob__item-selected::after{
    width: 20%;
  }
}
</style>