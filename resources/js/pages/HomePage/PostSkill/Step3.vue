<template>
  <div class="e-skills-percentage">
    <div class="e-skills-percentage__header">
      <div class="d-flex justify-content-between">
        <div>
          <div class="e-skills-percentage__title pb-3">
            Tell us more about what you’re looking for
          </div>
          <div class="e-skills-percentage__subtitle pb-3">
            Help us in finding the perfect match for your work
          </div>
        </div>
        <div><img :src="`${APP_URL}/images/home/step_2.svg`" /></div>
      </div>
    </div>

    <div class="e-skills-percentage__content">
      <ul
        class="e-skills-percentage__list row justify-content-between flex-wrap"
      >
        <li
          v-for="(item, i) in Object.keys(items)"
          :key="i"
          class="e-skills-percentage__items pb-3 col-4"
          :class="items[item] === 'range' ? 'text-center' : 'w-50'"
        >
          <span v-if="items[item] !== 'range'">{{ items[item] }}</span>
          <span v-else
            ><input
              class="slider"
              v-on:change="(e) => onchange(e.target.value, item)"
              type="range"
          /></span>
        </li>
      </ul>
    </div>
    <div class="e-skills-percentage__footer mt-4">
      <button
        v-on:click="() => this.$emit('updateData', 'step', 4)"
        class="e-button e-button-primary"
      >
        Continue
      </button>
    </div>
  </div>
</template>
<script>
export default {
  name: "Step3",
  props:['range_data','updateData'],
  data() {
    return {
      APP_URL: window.APP_URL,
      items: {
        product_focus: "Product Focus",
        range1: "range",
        project_focused: "Project Focused",
        initiator: "Initiator",
        range2: "range",
        follower: "Follower",
        creative: "Creative",
        range3: "range",
        structed_methodical: "Structured & Methodical",
        waterfall_approach: "Waterfall Approach",
        range4: "range",
        agile_approach: "Agile Approach",
        vocal_blunt: "Vocal & Blunt",
        range5: "range",
        silent_shy: "Silent & Shy",
        instructions_follower: "Instructions follower",
        range6: "range",
        collaborative: "Collaborative",
      },
      //change_data:this.items,
      new_data: {},
    };
  },
  mounted(){
      const onlyKeys = Object.keys(this.items).filter(data=>!data.includes("range"));
      const new_data = {};
      onlyKeys.map(key=>{
        new_data[key] = null;
      }) 
      this.$emit("updateData","range_data",new_data,3)
      
  },
  methods: {
    onchange(value, key) {
      const checkSelected =
        value === 50 ? false : value < 50 ? "left" : "right";
      const new_items = { ...this.items };
      let new_data = {...this.range_data};
      const rangeIndex = Object.keys(new_items).findIndex(
        (data) => data === key
      );
      const leftData = Object.keys(new_items)[rangeIndex - 1];
      const rightData = Object.keys(new_items)[rangeIndex + 1];
      new_data[leftData] = null;
      new_data[rightData] = null;
      if (checkSelected) {
        new_data[checkSelected === "left" ? leftData : rightData] = true;
      }
      this.$emit("updateData","range_data",new_data,3)
    },
  },
};
</script>