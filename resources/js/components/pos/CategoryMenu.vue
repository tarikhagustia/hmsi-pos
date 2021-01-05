<template>
  <ul class="category-menu flex">
    <li
      v-for="(category, key) in categories"
      :key="key" class="whitespace-no-wrap py-2 px-4"
      :class="{ 'active': activeIndex === key }">
      <a href="#" @click.prevent="handleSelect(key)">{{ category.name }}</a>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    categories: {
      type: Array,
      default () {
        return []
      }
    }
  },

  data () {
    return {
      activeIndex: 0
    }
  },

  methods: {
    handleSelect (index) {
      this.activeIndex = index

      this.$emit('select', this.categories[index])
    }
  }
}
</script>

<style lang="scss">
.category-menu {
  li {
    &.active {
      border-top: solid 0.2rem #4299e1;
      padding-top: 0.3rem;
    }
  }
}
</style>
