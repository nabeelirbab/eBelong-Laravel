<template>
  <div  class="bannerjob py-5 d-md-block">
  <div class="container">
    <h2 v-animate-onscroll.repeat="'animated flash'" class="text-center bannerjob__title pb-4 pt-4">How Ebelong works</h2>
    <div
      class="bannerjob__content d-md-flex justify-content-between"
    >
      <div>
        <ul class="bannerjob__items" style="background:#F5F5F5;position: relative; left: -10px">
          <li v-for="(item,i) in items" :class="{'bannerjob__item-selected' : i===selected}" v-on:click="()=>selected=i" :key='i' class="bannerjob__item pb-4">{{item}}</li>
        </ul>
      </div>
      <div><img class="bannerjob__image" style="width:300px" :src="`${APP_URL}/images/home/layer_${selected+1}.svg`"/></div>
      <div style="position: absolute; bottom: -20px;left:20px">
        <button v-on:click="onClick()" class="e-button e-button-primary">Let's Get Started</button>
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
              '01   Tell Us Who You Need',
              '02   Meet Your Talent',
              '03   Get Work Done',
              '04   Make secure payment'
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