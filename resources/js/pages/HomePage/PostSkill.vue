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
            <step-2 :skills="items.skills" :selectedSkills="selectedSkills" :wantedPositions="wantedPositions" :selectedCategories="selectedCategories" :step="step" v-if="step==1" @updateData="updateData"></step-2>
            <step-3 :range_data="range_data" :step="step" v-if="step==3" @updateData="updateData"></step-3>
            <step-4 :range_data="range_data" :selectedCategories="selectedCategories" :selectedSkills="selectedSkills" :wantedPositions="wantedPositions"  :accountDetails="accountDetails" :step="step" v-if="step==4" @updateData="updateData"></step-4>
            </div>
        </div>
        <div class="e-postskill-modal" v-if="show_modal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper" @click="show_modal = false">
                        <div class="modal-container">
                            <div class="modal-title">
                                <h6>Based on your requirements you shared, one of your Interim CTO 
                                    will reach out to you shortly to help you with your project</h6>
                            </div>
                        <div class="modal-body">
                            <img :src="`${baseUrl}/images/Interim-CTO.png`"/>
                        </div>

                        <div class="modal-footer">
                            <slot name="footer">
                                <button class="e-button e-button-primary" @click="show_modal = false">
                                OK
                                </button>
                            </slot>
                        </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
    </div>
    
</template>

<script>
import Step1 from './PostSkill/Step1.vue';
import Step2 from './PostSkill/Step2.vue';
import Step3 from './PostSkill/Step3.vue';
import Step4 from './PostSkill/Step4.vue';
// import sourceimage from '../../../../public/404-img.jpg';
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
              baseUrl:window.APP_URL,
              ...initalData,
              show_modal:false,
		  };
   },
   mounted(){
       window.postskill = this.$refs.postskill;
   },
   methods:{
       updateData(key,value){  
               this[key]= value;
       },
   },
   watch:{
       step:function(value){
            if(value==5){
                    //     this.$notify({
                    //     group:'success_message',
                    //     type:'success',
                    //     duration:5000,
                    //     text:'Your request submitted successfully, We will get back to please stay tuned'
                    
                    // })
                    this.show_modal = true;
                Object.keys(initalData).map(key=>{
                    this[key] = initalData[key];
                })
            }
       }
   }
}
</script>
<style scoped>
.modal-mask {
  position: fixed;
  z-index: 9998;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  display: table;
  transition: opacity 0.3s ease;
}

.modal-wrapper {
  display: table-cell;
  vertical-align: middle;
}

.modal-container {
  width: 35%;
  margin: 0px auto;
  padding: 20px 30px;
  background-color: #fff;
  border-radius: 2px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.33);
  transition: all 0.3s ease;
  font-family: Helvetica, Arial, sans-serif;
}

.modal-header h3 {
  margin-top: 0;
  color: #42b983;
}
.modal-title h6 {
    color: #474747;
    text-transform: unset;
}

.modal-body {
  /* margin: 20px 0; */
}
.modal-body img {
    width: 100%;
}

.modal-default-button {
  float: right;
}

/*
 * The following styles are auto-applied to elements with
 * transition="modal" when their visibility is toggled
 * by Vue.js.
 *
 * You can easily play with the modal transition by editing
 * these styles.
 */

.modal-enter {
  opacity: 0;
}

.modal-leave-active {
  opacity: 0;
}

.modal-enter .modal-container,
.modal-leave-active .modal-container {
  -webkit-transform: scale(1.1);
  transform: scale(1.1);
}

</style>