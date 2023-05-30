<template>
    <div>
    <div class="wt-projects">
        <div class="wt-project" v-if="index <= projects.length" v-for="(commentIndex, index) in commentsToShow" :key="index">
            <figure  v-if="projects[index]" >
                <img :src="base_url+'/uploads/users/'+freelancer_id+'/projects/'+projects[index].project_hidden_image" :alt="projects[index].project_hidden_image" v-if="projects[index].project_hidden_image" @click="showModal(index)">
                <img :src="base_url+'/uploads/settings/general/imgae-not-availabe.png'" :alt="img" v-else>
            </figure>
            <div class="wt-projectcontent" v-if="projects[index]">
                <h3 v-if="projects[index].project_title">{{projects[index].project_title}}</h3>
                <a :href="'http://'+projects[index].project_url" target="_blank" v-if="projects[index].project_url">{{projects[index].project_url}}</a>
            </div>
            <!-- Modal -->
            <div class="modal"  v-if="activeModalId === index">
              <div class="modal-dialog modal-md" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">{{projects[index].project_title}}</h5>
                    <button type="button" class="close"  @click="closeModal()" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body mx-auto">
                    <img :src="base_url+'/uploads/users/'+freelancer_id+'/projects/'+projects[index].project_hidden_image" :alt="projects[index].project_hidden_image" class="img-fluid mt-2" v-if="projects[index].project_hidden_image" @click="showModal(index)" style="height:300px">
                    <img :src="base_url+'/uploads/settings/general/imgae-not-availabe.png'" class="img-fluid mt-2" :alt="img" v-else>
                    <h5 class="mt-2 text-center"><a :href="'http://'+projects[index].project_url" target="_blank" v-if="projects[index].project_url">{{projects[index].project_url}}</a></h5>
                  </div>
                </div>
              </div>
            </div>
        </div>
        <div class="wt-btnarea">
            <a href="javascript:void(0);" class="wt-btn"  @click="commentsToShow += 3" v-if="commentsToShow < projects.length">
                {{ trans('lang.btn_load_more') }}
            </a>
        </div>
    </div>
    </div>
</template>

<script>
    export default{
        props: ['project', 'freelancer_id', 'img', 'no_of_post'],
        data() {
            return {
                projects: JSON.parse(this.project),
                base_url:APP_URL,
                commentsToShow: this.no_of_post,
                activeModalId : null,
            }
        },
        methods: {
           showModal(id) {
              this.activeModalId = id;
            },
           closeModal() {
              this.activeModalId = null;
            }
          },
        mounted:function(){
            
        }
    }
</script>
<style type="text/css">
    .modal{
        display: block !important;
    }
</style>