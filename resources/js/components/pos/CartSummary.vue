<template>
  <div class="select-none">
    <div class="flex justify-between p-2">
      <div>Subtotal</div>
      <div>{{ subtotal | currency }}</div>
    </div>
    <div class="flex justify-between border-t border-b border-gray-300 p-2">
      <div>Diskon</div>
      <div>{{ discount | currency }}</div>
    </div>
    <div class="flex justify-between p-2">
      <div>Pajak</div>
      <div>{{ tax | currency }}</div>
    </div>
    <button class="bg-purple-500 text-white w-full mt-2 py-2 px-2 rounded flex items-center justify-between focus:outline-none" :disabled="subtotal === 0" @click="handleClick">
      <span class="font-semibold">BAYAR</span>
      <span class="text-xl font-bold">{{ total | currency }}</span>
    </button>
  </div>
</template>

<script>
export default {
  props: {
    subtotal: {
      type: Number,
      default: 0
    },
    discount: {
      type: Number,
      default: 0
    },
    tax: {
      type: Number,
      default: 0
    }
  },

  computed: {
    total () {
      return this.subtotal - this.discount + this.tax
    }
  },

  methods: {
    handleClick () {
      this.$emit('click-pay')
    }
  }
}
</script>
