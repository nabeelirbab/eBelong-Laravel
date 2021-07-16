/**
 * Load all the javascript by using Vue.js and write all your JS code
 * in this file.
 */

require('./bootstrap');
import Vue from 'vue';
import VueSplide from '@splidejs/vue-splide';
import VueBootstrapTypeahead from 'vue-bootstrap-typeahead';
import Notifications from 'vue-notification';
import VueAnimateOnScroll from 'vue-animate-onscroll';
 
Vue.use(VueAnimateOnScroll);
Vue.use(Notifications);
Vue.component('vue-bootstrap-typeahead', VueBootstrapTypeahead)
Vue.use(VueSplide);
window.Vue = require('vue');
window.console.log = function () { };
window.console.error = function () { };
Vue.directive('isvisible',function(el,binding){
    // console.log(el,binding);
    // const data = JSON.parse(JSON.stringify((binding.expression)));
    // console.log(data);
    let {animate} =binding.value;
    let options = {
        root: null,
        rootMargin: '0px',
        threshold: 1.0,
        trackVisibility: true,
        delay:100
    }
    // window.addEventListener('scroll',function(){
        const observer = new IntersectionObserver(([entry])=>{
            if (entry && entry.isIntersecting && entry.isVisible && !el.classList.contains(`animate__${animate}`)) {
                el.classList.add('animate__animated',`animate__${animate}`)
            }else{
                el.classList.remove('animate__animated',`animate__${animate}`)
            }
        },options);
    // })
    observer.observe(el);
})
if(document.querySelectorAll('[data-vue]')){
    const selector = document.querySelectorAll('[data-vue]');
    for(let i=0;i < selector.length;i++){
        const currentSelector = selector[i];
        const component = currentSelector.getAttribute('data-component');
        const data = JSON.parse(currentSelector.getAttribute('data-vue'));
        // console.log(data);
        new Vue({
            el: `#${currentSelector.id}`,
            render:h => h(require(`./pages/HomePage/${component}.vue`).default,
                { props:
                 { items: data }
                 })
          //  components: {[component] : require(`./pages/HomePage/${component}.vue`).default,template:`<div />`},
            
        })
    }    
}
