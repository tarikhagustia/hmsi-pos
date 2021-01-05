<template>
  <div class="grid grid-cols-4 gap-2 pb-8">
    <div
      v-for="(product, key) in products"
      :key="key"
      class="bg-white rounded p-2 flex items-center justify-center cursor-pointer select-none relative"
      @click="handleSelect(product)">
      <div
        class="absolute top-0 right-0 text-white p-2 mt-2 mr-2 text-xs"
        :class="{ 'bg-red-500': product.quantity < 1, 'bg-orange-500': product.quantity > 0 && product.quantity <=5, 'bg-green-500': product.quantity > 5  }">
        {{ product.quantity }}
      </div>
      <div class="text-center">
        <img class="rounded" :src="product.image_url">
        <div class="mt-5 font-semibold text-sm">{{ product.name }}</div>
        <div class="font-bold text-blue-500 text-sm">{{ product.price | currency }}</div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    products: {
      type: Array,
      default () {
        return []
      }
    }
  },

  methods: {
    handleSelect (product) {
      if (product.quantity < 1) {
        this.$notify({
          title: 'Error',
          message: 'Stok tidak mencukupi.',
          type: 'error'
        })

        return
      }

      this.$emit('select-product', product)
    }
  }
}
</script>
