<template>
  <el-dialog title="Pembayaran" :visible="visible" @close="close" @opened="$refs.amount.$el.focus()">
    <div class="text-center">
      <div>
        <label class="text-lg">Total Belanja</label>
        <div class="text-2xl">{{ total | currency }}</div>
      </div>
      <div class="mt-5">
        <label class="text-lg">Jumlah Bayar</label>
        <div>
          <cleave v-model="amount" class="text-center text-2xl focus:outline-none" placeholder="Rp 100.000" :options="options" ref="amount"></cleave>
        </div>
      </div>
      <div class="mt-5">
        <label class="text-lg">Kembali</label>
        <div class="text-2xl">{{ amount.replace(/Rp /, '') - total | currency }}</div>
      </div>
      <div class="mt-10">
        <button class="bg-blue-500 py-2 px-4 rounded text-white font-bold focus:outline-none mr-2" :disabled="amount.replace(/Rp /, '') < total" @click="pay">BAYAR</button>
        <button class="bg-blue-500 py-2 px-4 rounded text-white font-bold focus:outline-none" :disabled="amount.replace(/Rp /, '') < total" @click="pay(true)">BAYAR & CETAK</button>
      </div>
    </div>
  </el-dialog>
</template>

<script>
import Cleave from 'vue-cleave-component'

export default {
  components: {
    Cleave
  },

  props: {
    cart: {
      type: Object,
      required: true
    },
    visible: {
      type: Boolean,
      default: false
    }
  },

  data () {
    return {
      amount: '',
      options: {
        numeral: true,
        numeralDecimalMark: ',',
        delimiter: '.',
        prefix: 'Rp ',
        signBeforePrefix: true
      }
    }
  },

  computed: {
    total () {
      return this.cart.subtotal - this.cart.discount + this.cart.tax
    }
  },

  methods: {
    close () {
      this.$emit('close')

      this.amount = ''
    },
    pay (print = false) {
      this.$emit('pay', { amount: this.amount.replace(/Rp /, ''), print })

      this.amount = ''
    }
  }
}
</script>
