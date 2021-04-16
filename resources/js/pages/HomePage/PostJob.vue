<template>
  <div class="e-postjob mt-5">
     <div  v-if="show" class="container"> 
     
    <div class="e-postjob__container d-flex justify-content-between">
        
      <div class="e-postjob__left w-75">
          <div class="e-postjob__header py-5">
        Post a Job
    </div>   
      <div class="e-postjob__content">
             You can always start your hunt for the right freelancer by just posting your job and start receiving proposals from our top talent. You can then shortlist and select the most suitable Freelancer for your job
      </div>
      <div class="row">
        <div class="col-12 my-4 col-md-7">
          <input
            v-model="email"
            type="email"
            class="w-100 e-input-field"
            placeholder="Email address"
          />
            <button v-on:click="onClick" class="e-button e-button-primary my-3">Continue</button>
          
        </div>
        </div>
      </div>
      <div v-animate-onscroll.repeat="{down:'animated rollIn'}" class="e-postjob__right d-none d-md-block">
          <img :src="`${APP_URL}/images/post_job.svg`" alt="post_job"/>
      </div>
    </div>
  </div>
  </div>
</template>
<script>
export default {
  name: "PostJob",
  props:['items'],
  data() {
    return {
      APP_URL: window.APP_URL,
      email:'',
      show: true
    };
  },
  mounted(){
    console.log(this.items);
    this.show = this.items && this.items.roles && this.items.roles[0].role_type === "admin" ? false : true;
  },
  methods:{
      onClick(){
        if(this.items && this.items.roles && this.items.roles[0].role_type){
              window.location.replace(`${this.APP_URL}/search-result?type=freelancer`)
        }else{
            window.location.replace(`${this.APP_URL}/register?email=${this.email}`)

        }
      }
  }
};
</script>
