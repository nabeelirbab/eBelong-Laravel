<template>
   <form class="wt-formtheme wt-form-service" id="main-home-search-form">
        <div class="wt-formtitlethree">
            <h3 data-v-1fcb3bd6=""><span data-v-1fcb3bd6="">Find the top talent</span>for most challenging jobs</h3>
        </div>
        <fieldset> 
            <div class="form-group">
            <vue-bootstrap-typeahead
                    class="mb-4"
                    size="sm"
                    placeholder="I am looking for"
                    v-model="query"
                    :data="searchable_data"
                    :serializer="item => item.name"
                    ref="searchfield"
                    @input="watchSearchResults(types)"
                    inputClass="search-field"
                    @hit="recordSelected"
                >
                <template slot="suggestion" slot-scope="{ data, htmlText }">
                    <div class="d-flex align-items-center">
                        <span class="ml-4" v-html="htmlText"></span>
                    </div>
                    <input type="hidden" name="keyword" :value="data.slug" id="hidden_field">
                    <input type="hidden" name="url_type" :value="data.url_type" id="url_type">
                </template>
            </vue-bootstrap-typeahead>
            <span v-if="is_show" class="no-record-span">{{no_record}}</span>
            </div>
            <div class="form-group">
                <span class="wt-select" style="margin-bottom:35px;">
                    <select v-model="types" v-on:change="getSearchableData(types), emptyField(types)">
                        <option v-for="(filter, index) in filters" :key="index" :value="filter.value">{{filter.title}}</option>
                    </select>
                </span>
            </div> 

        </fieldset>
        <div class="wt-bannerthreeform-footer">
            <a href="javascript:void(0);" class="wt-btntwo" v-on:click.prevent="submitSearchForm(types)">Search Now</a>
        </div>
    </form>
</template>
<script>
 export default{
    props: ['widget_type', 'no_record_message', 'placeholder', 'freelancer_placeholder', 'employer_placeholder', 'job_placeholder', 'service_placeholder'],
        data(){
            return {
                filters:[],
                isActive: false,
                searchable_data:[],
                freelancers:[],
                employers:[],
                jobs:[],
                query:'',
                types:'job',
                selected_type:'',
                no_record:this.no_record_message,
                is_show: false,
                related_results:false,
                url: APP_URL + '/search-results',
                type_change:false,
                data : {
                    slug : "",
                    url_type : ""
                }
            }
        },
        methods: {

        
            displayFiltersName(type) {
                if(type == 'freelancer') {
                    this.selected_type = this.freelancer_placeholder;
                }  else if(type == 'job') {
                    this.selected_type = this.job_placeholder;
                } else if(type == 'employer') {
                    this.selected_type = this.employer_placeholder;
                } else if(type == 'service') {
                    this.selected_type = this.service_placeholder;
                }
            },
            getFilters(){
                
                let self = this;
                axios.get(APP_URL + '/search/get-search-filters')
                .then(function (response) {
                    if ( response.data.type == 'success') {
                        self.filters = response.data.result;
                    }
                });
            },
            changeFilter(){
                this.type_change = true;
            },
            getSearchableData: function(type, newQuery){
                this.displayFiltersName(type);
                let self = this;
                axios.post(APP_URL + '/search/get-searchable-data',{
                    type:type
                })
                .then(function (response) {
                    if (type == 'freelancer') {
                        self.searchable_data = response.data.searchables;
                    } else if (type == 'employer') {
                        self.searchable_data = response.data.searchables;
                    } else if (type == 'job') {
                        self.searchable_data = response.data.searchables;
                    } else if (type == 'service') {
                        self.searchable_data = response.data.searchables;
                    }
                });
            },
            emptyField:function(types){
                //this.$refs.searchfield.inputValue = '';
                this.isActive = false;
            },
            watchSearchResults:function(types){
                if(jQuery('.wt-radioholder').css('display') == 'block') {
                    jQuery('.wt-radioholder').css("display", "none");
                }
                if ( !(jQuery('.list-group').hasClass( "input-searching" )) ) {
                    jQuery('.list-group').addClass('input-searching');
                }
                if(this.$refs.searchfield.$children[0].matchedItems == '') {
                    jQuery('.search-field').parents('.form-group').find('span.no-record-span').css("display", "block");
                    jQuery('.wt-related-result').remove();
                    this.is_show = true;
                } else {
                    let keyword = this.query;
                    var urlParams = new URLSearchParams(window.location.search);
                    if (urlParams.get('type') && this.type_change == false) {
                        var type = urlParams.get('type');
                    } else {
                        var type = types;
                    }
                    if(type == 'Freelancers') {
                        type = 'freelancer';
                    } else if(type == 'Employers') {
                        type = 'employer';
                    } else if(type == 'Jobs') {
                        type = 'job';
                    } else if(type == 'Services') {
                        type = 'service';
                    }
                    jQuery('.search-field').parents('.form-group').find('span.no-record-span').css("display", "none");
                    jQuery('.wt-related-result').remove();
                    var html = '<a href="'+this.url+'?s='+keyword+'&type='+type+'" class="wt-related-result"><span v-if="related_results">show all result related to'+' <em>'+ keyword+'</em></span></a>';
                    jQuery(".list-group").append(html);
                    this.related_results = true;
                    this.is_show = false;
                }
            },
            recordSelected:function(){
                if (jQuery('.list-group').hasClass( "input-searching" )) {
                    jQuery('.list-group').removeClass('input-searching');
                }
            },
            toggleDropdown: function(){
                if (this.isActive == false) {
                    this.isActive = true;
                    jQuery('.wt-related-result').remove();
                } else {
                    this.isActive = false;
                }
            },
            submitSearchForm: function(type) {

                             
                var urlParams = new URLSearchParams(window.location.search);
                if (urlParams.get('type') && this.type_change == false) {
                    var type = urlParams.get('type');
                }   else {
                        if(type == 'Freelancers') {
                            type = 'freelancer';
                    }   else if(type == 'Employers') {
                            type = 'employer';
                    }   else if(type == 'Jobs') {
                            type = 'job';
                    } else if(type == 'Services') {
                            type = 'service';
                    }
                }
                
                if (typeof(document.getElementById("hidden_field")) != 'undefined' && document.getElementById("hidden_field") != null) {
                    let slug = document.getElementById('hidden_field').value;
                    
                    console.log("here");
                    let keyword = this.query
                    if (type == 'job') {
                        let url_type = document.getElementById('url_type').value;
                        if(url_type == 1)
                            window.location.replace(APP_URL+'/job/'+slug);
                        else if(url_type == 2)
                            window.location.replace(APP_URL+'/search-results?type=job&s=&skills[]='+slug);
                        else
                        {
                            window.location.replace(APP_URL+'/search-results?type=job&s=&category[]='+slug);
                        }
                    } else if (type == 'service'){
                        window.location.replace(APP_URL+'/service/'+slug);
                    }
                    else if(type == 'freelancer')
                    {
                        window.location.replace(APP_URL+'/search-results?type='+type+'&s=&skills[]='+slug);
                    }
                    else {
                        window.location.replace(APP_URL+'/profile/'+slug);
                    }
                } else {
                    window.location.replace(APP_URL+'/search-results?type='+type);
                }
               

            },
        },
        watch: {
            query: _.debounce(function(newQuery) { this.getSearchableData(newQuery) }, 250)
        },
        mounted: function () {
            var urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('type')) {
                var type = urlParams.get('type');
                this.displayFiltersName(type);
            }
            jQuery(".search-field").keydown(function(){
                var input = jQuery('.search-field');
                input.on('keydown', function() {
                    var key = event.keyCode || event.charCode;
                    if( key == 8 || key == 46 ) {
                        if(!jQuery(this).val()) {
                            jQuery(this).parents('.form-group').find('span.no-record-span').css("display", "none");
                        } else {
                            jQuery('.wt-related-result').remove();
                            this.is_show = true;
                        }
                    }
                });
            });

            $('form input').keydown(function (e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                                   
                   var types = $(".selected-search-type").text();
                   console.log("here");
                                      
                   // let keyword = this.query
                    if( document.getElementById('hidden_field'))
                        var slug = document.getElementById('hidden_field').value;
                    else
                        var slug = "";

                    if( types == 'Find Talent '){
                        types = 'freelancer'; 
                        if(slug == "") 
                            window.location.replace(APP_URL+'/search-results?type='+types);   
                        else
                            window.location.replace(APP_URL+'/search-results?type='+types+'&s=&skills[]='+slug);
                    }else {
                        types = 'job';
                        if( document.getElementById('url_type'))
                            var url_type = document.getElementById('url_type').value;
                        else
                            var url_type = "";

                        if(url_type == 1)
                        {
                            console.log(slug);
                            window.location.replace(APP_URL+'/job/'+slug);
                        }
                        else if(url_type == 2)
                            window.location.replace(APP_URL+'/search-results?type=job&s=&skills[]='+slug);
                        else if(url_type == "" && slug == "")
                        {
                            window.location.replace(APP_URL+'/search-results?type=job');
                        }
                        else
                            window.location.replace(APP_URL+'/search-results?type=job&s=&category[]='+slug);
                                             
                    }                                                               
                    return false;
                }
            });
  

        },
        created: function() {
            console.log("akber");
            this.getFilters();
            var urlParams = new URLSearchParams(window.location.search);
			console.log(urlParams); 
            if (urlParams.get('type')) {
                var type = urlParams.get('type');
                this.displayFiltersName(type);
                this.getSearchableData(type);
            } else {
                this.getSearchableData('job');
            }
        }
    }
</script>
<style>
.wt-radioholder{transition: 1s;}
</style>

