<template>
  <div class="e-project-type">
    <div class="e-project-type__header">
      <div class="d-flex justify-content-between flex-column flex-md-row">
        <div class="order-md-1 order-1">
          <div class="e-project-type__title">
            Tell us about your project type
          </div>
          <div class="e-project-type__subtitle">
            Select the category from the list below
          </div>
        </div>
        <div class="order-md-2 text-center">
          <img :src="`${APP_URL}/images/home/step_1.svg`" />
        </div>
      </div>
    </div>
    <div class="e-project-type__content">
      <ul class="e-project-type__list">
        <li
          v-on:click="() => onClick(category.title)"
          v-if="index < 9"
          v-for="(category, index) in categories"
          :key="index"
          class="e-project-type__list--item"
          :class="{
            'e-project-type__list--item__active': selectedCategories.includes(
              category.title
            ),
          }"
        >
          <img
            :src="`/uploads/categories/${category.image}`"
            style="width: 15px"
          />
          {{ category.title }}
        </li>
      </ul>
      <div class="e-project-type__search" v-if="filterCategories.length">
        <!-- <input class="e-input-field" type="text" /> -->
        <multiselect
          placeholder="Select for other types here"
          :multiple="true"
          :tagging="true"
          v-model="value"
          @select="(e) => onClick(e.id)"
          @remove="(e) => onClick(e.id)"
          track-by="id"
          label="title"
          :options="Object.values(categories)"
        >
          <span slot="noResult">Oops! Please enter valid matches</span>
        </multiselect>
      </div>
    </div>
    <div v-if="step === 1" class="e-project-type__footer">
      <!-- <div v-if="show_error" class="text-danger py-3">
          Please select categories
      </div> -->
      <!-- <button
        v-on:click="onSubmit"
        class="e-button e-button-primary"
      >
        Continue
      </button> -->
    </div>
  </div>
</template>

<script>
import Multiselect from "vue-multiselect";
Vue.component("multiselect", Multiselect);
export default {
  name: "Step1",
  components: { Multiselect },
  data() {
    return {
      value: null,
      APP_URL: window.APP_URL,
      show_error: false,
      filterCategories: Object.values(this.categories).filter(
        (obj, index) => index > 9
      ),
    };
  },
  props: ["step", "updateData", "selectedCategories", "categories"],
  methods: {
    onSubmit() {
      if (this.selectedCategories.length) {
        this.$emit("updateData", "step", 2);
      } else {
        this.show_error = true;
      }
    },
    onClick(index) {
      this.show_error = false;
      const selectedCategories = [...this.selectedCategories];
      const isPresent = selectedCategories.indexOf(index) >= 0;
      if (isPresent) {
        selectedCategories.splice(selectedCategories.indexOf(index), 1);
      } else {
        selectedCategories.push(index);
      }
      console.log(selectedCategories, "selectedCategories");
      this.$emit("updateData", "selectedCategories",selectedCategories, 1);
    },
    addTag(newTag) {
      const tag = {
        name: newTag,
        code: newTag.substring(0, 2) + Math.floor(Math.random() * 10000000),
      };
      this.options.push(tag);
      this.value.push(tag);
    },
  },
};
</script>

<style lang="scss">
.multiselect {
  &__select {
    display: none !important;
  }
  &__input {
    border: 0 !important;
  }
  &__tags {
    padding: 8px !important;
    border-radius: 0 !important;
    &-wrap {
      position: absolute;
      right: 0;
    }
  }
  &__tag {
    background: black !important;
    border-radius: 0 !important;
  }
}
</style>
<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>
