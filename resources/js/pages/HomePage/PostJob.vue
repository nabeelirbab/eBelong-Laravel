<template>
  <div class="e-postjob mt-5">
    <div v-if="show" class="container">
      <div class="e-postjob__container d-flex justify-content-between">
        <div class="row">
          <div class="col-sm-12 col-md-7">
            <div class="e-postjob__left">
              <div class="e-postjob__header py-5">
                  <div class="e-postjob__header__title">Post a Job</div>
                  <div class="e-postjob__header__image"><img :src="`${APP_URL}/images/paper_plane.svg`" alt="paper_plane"/></div>
              </div>
              <div class="e-postjob__content">
                    You can always start your hunt for the right freelancer by just posting your job and start receiving proposals from our top talent. You can then shortlist and select the most suitable Freelancer for your job
              </div>
              <div class="row">
                <div class="col-12 my-4 col-md-10">
                  <input
                    v-model="email"
                    type="email"
                    class="w-100 e-input-field"
                    placeholder="Email address"
                  />
                  <p v-if="errors.length">
                    <ul>
                      <li style="list-style:none; color : red " v-for="error in errors" v-bind:key="error.id" >{{ error }}</li>
                    </ul>
                  </p>
                  <button v-on:click="onClick" class="e-button e-button-primary my-3">Continue</button>
                    <!-- <div class="row">
                      <div class="col-sm-12 col-md-12 col-lg-12 ">
                        <div class="or-area">or</div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12 col-lg-6">
                        <a href="#" class="google btn"><i class="fa fa-google fa-fw">
                          </i> Continue with Google
                        </a>
                      </div>
                      <div class="col-md-12 col-lg-6">
                        <a href="#" class="fb btn">
                          <i class="fa fa-facebook fa-fw"></i> Continue with Facebook
                        </a>
                      </div>
                    </div> -->
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-12 col-md-5" style="position: relative;">
            <div v-animate-onscroll.repeat="{down:'animated rollIn'}" class="e-postjob__right d-none d-md-block">
              <img :src="`${APP_URL}/images/post_job.svg`" alt="post_job"/>
            </div>
          </div>
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
      errors: [],
      APP_URL: window.APP_URL,
      email:null,
      show: true
    };
  },
  mounted(){
    // console.log(this.items);
    this.show = this.items && this.items.roles && this.items.roles[0].role_type === "admin" ? false : true;
  },
  methods:{
      onClick(){
        if(this.validate()){
          if(this.items && this.items.roles && this.items.roles[0].role_type){
              window.location.replace(`${this.APP_URL}/search-result?type=freelancer`)
        }
        else if(!this.errors.length && this.email!==null){
            window.location.replace(`${this.APP_URL}/register?email=${this.email}`)
        }
        }   
        },
        
        validate(e){
        this.errors = [];
        if (!this.email || this.email==null) {
          this.errors.push('The Email is required.');
        } else if (!this.validEmail(this.email)) {
          this.errors.push('Email is not valid');
        }
        if (!this.errors.length) {
          return true;
        }
        e.preventDefault();
        },
        
        validEmail: function (email) {
        var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        return re.test(email);
      }
  }
};
</script>