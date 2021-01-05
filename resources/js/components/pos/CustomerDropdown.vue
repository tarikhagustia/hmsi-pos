<template>
  <div class="customer-dropdown flex">
    <div class="flex items-center text-2xl text-blue-500 mr-3">
      <fa-icon :icon="['far', 'user']"></fa-icon>
    </div>
    <div class="flex-1">
      <el-select v-model="customer" class="w-full" filterable @change="handleChange">
        <el-option :value="null" label="Pelanggan"></el-option>
        <el-option-group v-for="group in customers" :key="group.label" :label="group.label">
          <el-option v-for="item in group.options" :key="item.value" :label="item.label" :value="item.value"></el-option>
        </el-option-group>
      </el-select>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    customers: {
      type: Array,
      default () {
        return []
      }
    }
  },

  data () {
    return {
      customer: null
    }
  },

  methods: {
    handleChange (value) {
      this.$emit('change', value)
    }
  }
}
</script>

<style lang="scss">
.customer-dropdown {
  .el-input__inner {
    border: none;
    color: #4299e1;
    font-size: 1rem;
    font-weight: 700;
  }
}
</style>