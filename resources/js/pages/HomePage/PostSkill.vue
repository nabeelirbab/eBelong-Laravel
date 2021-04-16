<template>
    <div class="container">
    <div class="e-postskill">
        <div class="e-postskill__header">
            <div>Let's Get Started</div>
           <div> Find your right match</div>
        </div>
        <notifications group="success_message" position="top right" />
        <div class="e-postskill__content">
        <step-1 :categories="items.categories" :selectedCategories="selectedCategories" :step="step" @updateData="updateData" v-if="step==1"></step-1>
        <step-2 :skills="items.skills" :selectedSkills="selectedSkills" :wantedPositions="wantedPositions"  :step="step" v-if="step==2" @updateData="updateData"></step-2>
        <step-3 :range_data="range_data" :step="step" v-if="step==3" @updateData="updateData"></step-3>
        <step-4 :range_data="range_data" :selectedCategories="selectedCategories" :selectedSkills="selectedSkills" :wantedPositions="wantedPositions"  :accountDetails="accountDetails" :step="step" v-if="step==4" @updateData="updateData"></step-4>
        </div>
    </div>
    </div>
</template>
<script>
import Step1 from './PostSkill/Step1.vue';
import Step2 from './PostSkill/Step2.vue';
import Step3 from './PostSkill/Step3.vue';
import Step4 from './PostSkill/Step4.vue';
const initalData = {
             step:1,
             selectedCategories:[],
             selectedSkills:[],
             accountDetails:{
                 fullName:'',
                 phoneNumber:'',
                 email:''
             },
             percentangeDetails:{

             },
             range_data:{},
             wantedPositions:null,
		  };

export default {
  name: 'PostSkill',
  components:{
      Step1,
      Step2,
      Step3,
      Step4
  },
   props:['items'],
   data() {
		  return {
              ...initalData
		  };
   },
   mounted(){
       window.postskill = this.$refs.postskill;
   },
   methods:{
       updateData(key,value){  
               this[key]= value;
       }
   },
   watch:{
       step:function(value){
            if(value==5){
                           this.$notify({
                        group:'success_message',
                        type:'success',
                        duration:5000,
                        text:'Your request submitted successfully, We will get back to please stay tuned'
                    
                    })
                Object.keys(initalData).map(key=>{
                    this[key] = initalData[key];
                })
            }
       }
   }
}
</script>