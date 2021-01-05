<template>
  <ul class="cart pb-5">
    <li v-for="(item, key) in items" :key="key" class="item p-2 cursor-pointer select-none">
      <div class="flex">
        <div class="flex items-center justify-center border border-gray-300 rounded w-10 h-10">{{ item.quantity }}</div>
        <div class="flex-1 p-2 truncate">{{ item.name }}</div>
        <div class="amount p-2">{{ item.price | currency }}</div>
        <div class="action flex items-center">
          <button class="border border-blue-500 text-blue-500 rounded font-semibold w-8 h-8 focus:outline-none" @click="decreaseQuantity(key)">-</button>
          <button class="ml-2 border border-blue-500 text-blue-500 rounded font-semibold w-8 h-8 focus:outline-none" @click="increaseQuantity(key)">+</button>
        </div>
      </div>
    </li>
  </ul>
</template>

<script>
export default {
  props: {
    items: {
      type: Array,
      default () {
        return []
      }
    }
  },

  methods: {
    increaseQuantity (index) {
      this.items[index].quantity += 1;

      this.$emit('update-item', this.items[index])
    },
    decreaseQuantity (index) {
      this.items[index].quantity -= 1;

      if (this.items[index].quantity === 0) {
        const item = this.items[index].quantity

        this.items.splice(index, 1)

        this.$emit('update-item', item)

        return
      }

      this.$emit('update-item', this.items[index])
    }
  }
}
</script>

<style lang="scss">
.cart {
    .item {
    &:not(:first-child) {
      border-top: solid 1px #e2e8f0;
    }
    &:hover {
      .amount {
        display: none;
      }
      .action {
        display: block;
      }
    }
    .action {
      display: none;
    }
  }
}
</style>
