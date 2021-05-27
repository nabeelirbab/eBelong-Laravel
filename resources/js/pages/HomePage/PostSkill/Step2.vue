<template>
  <div class="e-wanted-postions">
    <div class="e-project-type__header">
      <div class="d-flex justify-content-between flex-column flex-md-row">
        <div class="order-md-1 order-1">
        <!-- <div class="e-project-type__title">Tell us about your project type</div> -->
        <div class="e-project-type__subtitle">
          Select your skills from the list below
        </div>
        </div>
        <!-- <div class="order-md-2 text-center"><img :src="`${APP_URL}/images/home/step_2.svg`"/></div> -->
      </div>
    </div>
    <div class="e-project-type__content">
      <ul class="e-project-type__list">
        <li
          v-on:click="() => onClick(skill.title)"
          v-for="(skill, index) in skills"
          v-if="skill.is_featured"
          :key="index"
          class="e-project-type__list--item"
         :class="{
            'e-project-type__list--item__active': selectedSkills.includes(skill.title),
          }"
        >
          <img :src="`/uploads/logos/${skill.logo}`" style="width:15px"/>
          {{ skill.title }}
        </li>
      </ul>
      <div class="e-project-type__search" v-if="filterSkills.length">
        <!-- <input class="e-input-field" type="text" /> -->
        <multiselect 
        placeholder="Select for other types here"
        :multiple="true" 
        :tagging="true" 
        v-model="value"
        @select="(e)=>onClick(e.title)" 
        @remove="(e)=>onClick(e.title)" 

        track-by="id" label="title"
        :options="filterSkills">
        <span slot="noResult">Oops! Please enter valid matches</span>
        </multiselect>
      </div>
    </div>
    <div class="e-wanted-postions__heading py-4">How many positions do you want to fill?</div>
    <div class="e-wanted-postions__content">
      <ul class="e-wanted-postions__list">
        <li
        
         v-for="item in items" :key="item" class="c-pointer e-wanted-postions__item mr-4 my-2 e-button-small e-button-light"
               v-on:click="() => $emit('updateData', 'wantedPositions', item)"

        :class="{'e-button-primary': item===wantedPositions}"
        >{{item}}</li>
      </ul>
    </div>
    <div class="e-wanted-postions__footer mt-5">
     <div v-if="show_error" class="text-danger py-3">
          Please select category, skills and postions.
      </div>
      <button
        v-on:click="onSubmit"
        class="e-button e-button-primary"
      >
        Continue
      </button>
    </div>
  </div>
</template>
<script>
export default {
  name: "Step2",
  props: ["step", "updateData", "wantedPositions","skills","selectedSkills", "selectedCategories"],
  data(){
      return{
          show_error:false,
          APP_URL: window.APP_URL,
          items:['One','2-3','4-5','6-8','9-10','10+'],
          value:null,
          filterSkills:Object.values(this.skills).filter((obj,index)=>!obj.is_featured),
      }
  },
  methods:{
    onSubmit(){
      if(this.selectedSkills.length && this.selectedCategories.length && this.wantedPositions){
        this.$emit('updateData', 'step', 3);
      }else{
        this.show_error = true;
      }
      
    },
    onClick(index) {
      const selectedSkills = [...this.selectedSkills];
      const isPresent = selectedSkills.indexOf(index) >= 0;
      if (isPresent) {
        selectedSkills.splice(selectedSkills.indexOf(index), 1);
      } else {
        selectedSkills.push(index);
      }
      this.$emit("updateData", "selectedSkills", selectedSkills);
    },
  }
};
</script>
