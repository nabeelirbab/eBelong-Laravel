<template>
    <div class="e-account-details">
        <div class="e-account-details__header">
            <div class="e-account-details__title pb-3">
                Lets Get it done
            </div>
            <div class="e-account-details__subtitle pb-3">
                Thank you for being so patient, Lets finish it off now
            </div>
            
        </div>
        <form v-on:submit="onSubmit" class="e-account-details__content">
            <div>
                <div v-if="show_error" class="text-danger py-3">
          Please fill all the details.
      </div>   
            </div>
            <div class="row">
                <div class="col-md-4 col-12 pt-3">
                     <input @input="(e)=>onChange(e.target)" :value="full_name" name="full_name" type="text" class="w-100 e-input-field" placeholder="Full Name" />
                </div>
                <div class="col-md-3 col-12 pt-3">
                    <input @input="(e)=>onChange(e.target)" :value="phone_number" name="phone_number" type="number" class="w-100 e-input-field" placeholder="Phone Number" />
                </div>
            </div>
            <div class="row">
                <div class="col-md-7 col-12 pt-3">
                     <textarea style="height:80px"  name="full_na" type="text" class="w-100 e-input-field" placeholder="Share here for more details" />
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-6 pt-3">
                    <input  @input="(e)=>onChange(e.target)" :value="email" name="email" type="email" class="w-100 e-input-field" placeholder="Enter your work email address" />
                </div>
                <div class="col-md-2 col-12 text-center pt-3">
                   
            <button ref="submit" class="e-button e-button-primary">
                Submit
            </button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
import textarea from '../../../components/pageBuilder/edit----------/textarea.vue';
import Vue from 'vue'
import VueCookies from 'vue-cookies'
Vue.use(VueCookies)

export default {
  components: { textarea },
    name:'Step4',
    data(){
        return {
            email:'',
            phone_number:'',
            full_name:'',
            show_error:false
        }
    },
    props:["updateData","selectedCategories","wantedPositions","selectedSkills","range_data"],
    methods:{
        onSubmit(e){
            

            e.preventDefault();
            if(!this.email || !this.phone_number || !this.full_name){
                this.show_error = true;
                return false;
            }
            this.$refs.submit.disabled = true;
            this.$refs.submit.style.opacity = '0.4';
            this.show_error =false;
            const submitData = {
                email:this.email,
                phone_number:this.phone_number,
                full_name:this.full_name,
                positions:this.wantedPositions,
                selectedCategories:JSON.stringify(this.selectedCategories),
                selectedSkills:JSON.stringify(this.selectedSkills),
                ...this.range_data
            }
            
            this.$cookies.set("storedUserName",this.full_name);  
            // this.$emit('updateData', 'step', 5);
            
            axios.post(window.APP_URL + '/postskill',submitData).then(res=>{
                if(res.data.status){
         
                    this.$emit('updateData', 'step', 5);
                }
            });
        },
        onChange(target){
            this[target.name]= target.value;
        }
    }

}
</script>