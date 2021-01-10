<template>
  <div id="app" class="bg-purple-200 h-screen max-h-screen">
    <div class="flex h-screen max-h-screen">
      <div class="pos-content w-3/4">
        <div class="header p-4">
          <div class="bg-white rounded p-4">
            <div class="flex">
              <div class="flex flex-1">
                <div class="border-r border-gray-300 flex-none pr-4">
                  <a class="text-2xl text-blue-500" href="/"><fa-icon icon="arrow-left"></fa-icon></a>
                </div>
              </div>
              <div class="flex">
                <button
                  class="border border-gray-300 py-1 px-4 rounded-full focus:outline-none mr-2"
                  :class="input.inStock ? 'bg-blue-500 text-white' : ''" @click="input.inStock = !input.inStock">
                  Tersedia
                </button>
              </div>
              <div class="flex border border-gray-300 py-1 px-4 rounded-full">
                <div class="flex-1">
                  <input v-model="input.search" class="w-full text-gray-600 text-lg font-thin focus:outline-none">
                </div>
                <div class="text-gray-300 text-lg ml-2">
                  <fa-icon v-if="input.search.length > 0" class="cursor-pointer" icon="times" @click="input.search = ''"></fa-icon>
                  <fa-icon v-else icon="search"></fa-icon>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div v-show="filteredProducts.length < 1" class="body p-4 flex justify-center items-center">
          <div class="text-center text-gray-500">
            <fa-icon class="text-5xl" icon="box-open"></fa-icon>
            <div>Tidak ada produk</div>
          </div>
        </div>
        <div v-show="filteredProducts.length > 0" class="body p-4" v-smoothscrollbar>
          <product-list :products="filteredProducts" @select-product="onSelectProduct"></product-list>
        </div>
        <div class="footer p-4">
          <div class="bg-white rounded h-full p-4">
            <div class="pb-2 border-b-2 border-gray-300" v-smoothscrollbar>
              <category-menu :categories="categories" @select="onSelectMenu"></category-menu>
            </div>
          </div>
        </div>
      </div>
      <div class="pos-sidebar w-1/4 bg-white">
        <div class="header">
          <div class="flex py-2 px-4">
            <div class="flex flex-1 items-center">
              <span class="text-2xl font-semibold">Keranjang</span>
              <span class="text-blue-500 font-semibold ml-2">{{ cart.items.length }}</span>
            </div>
            <div class="flex items-center">
              <a class="text-red-500" href="#" @click.prevent="clearCart">
                <fa-icon icon="trash-alt"></fa-icon>
              </a>
            </div>
          </div>
          <div class="py-2 px-4">
            <customer-dropdown :customers="options.customer" @change="onChangeCustomer"></customer-dropdown>
          </div>
        </div>
        <div class="body p-2" v-smoothscrollbar>
          <cart :items="cart.items" @update-item="onUpdateItem"></cart>
        </div>
        <div class="footer border-t-2 border-gray-300 py-4 px-2">
          <cart-summary :subtotal="cart.subtotal" @click-pay="paymentDialog.visible = true"></cart-summary>
        </div>
      </div>
    </div>
    <payment-dialog :cart="cart" :visible="paymentDialog.visible" @close="paymentDialog.visible = false" @pay="handlePayment"></payment-dialog>
  </div>
</template>

<script>
import axios from 'axios'

import CategoryMenu from './components/pos/CategoryMenu'
import Cart from './components/pos/Cart'
import CartSummary from './components/pos/CartSummary'
import CustomerDropdown from './components/pos/CustomerDropdown'
import PaymentDialog from './components/pos/PaymentDialog'
import ProductList from './components/pos/ProductList'

export default {
  components: {
    CategoryMenu,
    Cart,
    CartSummary,
    CustomerDropdown,
    PaymentDialog,
    ProductList
  },

  data () {
    return {
      categories: [
        {
          id: null,
          name: 'Semua'
        }
      ],
      cart: {
        items: [],
        subtotal: 0,
        discount: 0,
        tax: 0
      },
      customers: [],
      input: {
        category: null,
        customer: null,
        inStock: false,
        search: ''
      },
      options: {
        customer: []
      },
      products: [],
      paymentDialog: {
        visible: false
      }
    }
  },

  computed: {
    filteredProducts () {
      let products = this.products

      if (this.input.search.length > 0) {
        products = products.filter(product => {
          return product.name.toLowerCase().includes(this.input.search.toLowerCase())
        })
      }

      if (this.input.inStock) {
        products = products.filter(product => {
          return product.quantity > 0
        })
      }

      return products
    }
  },

  async created () {
    await this.getCategories()
    await this.getProducts()
    await this.getCustomers()
  },

  methods: {
    async getCategories () {
      try {
        const res = await axios.get('/json/product-categories/all')

        this.categories = this.categories.concat(res.data)
      } catch (e) {
        console.log(e)
      }
    },
    async getCustomers () {
      try {
        const res = await axios.get('/json/customers/all')

        this.customers = res.data

        this.options.customer = this.customers.map((items, index) => {
          const group = {
            label: index === 0 ? 'Pelajar' : 'Pengajar',
            options: items.map(item => {
              return {
                label: item.name,
                value: `${item.class}:${item.id}`
              }
            })
          }

          return group
        })
      } catch (e) {
        console.log(e)
      }
    },
    async getProducts () {
      try {
        const res = await axios.get('/json/products/all', {
          params: {
            category: this.input.category
          }
        })

        this.products = res.data
      } catch (e) {
        console.log(e)
      }
    },
    calculateSubtotal () {
      this.cart.subtotal = this.cart.items.reduce((val, item) => {
        return val + item.price * item.quantity
      }, 0)
    },
    clearCart () {
      this.cart.items = []

      this.calculateSubtotal()
    },
    onSelectMenu (category) {
      this.input.category = category.id

      this.getProducts()
    },
    onChangeCustomer (value) {
      this.input.customer = value
    },
    onSelectProduct (product) {
      const index = this.cart.items.findIndex(item => item.id === product.id)

      if (index < 0) {
        this.cart.items.push({
          id: product.id,
          name: product.name,
          price: product.price,
          quantity: 1
        })
      } else {
        this.cart.items[index].quantity += 1
      }

      this.calculateSubtotal()
    },
    onUpdateItem () {
      this.calculateSubtotal()
    },
    async handlePayment (payload) {
      const order = Object.assign(this.cart, {
        customer: this.input.customer
      })

      try {
        const { data } = await axios.post('/json/orders', order)

        this.paymentDialog.visible = false

        this.$notify({
          title: 'Success',
          message: data.message,
          type: 'success'
        })

        if (payload.print) {
          this.handlePrint(data.data, payload.amount)
        }

        this.clearCart()
        this.getProducts()
      } catch (e) {
        if (e.response) {
          console.log(`${e.response.status} :: ${e.message}`)
        }
      }
    },
    handlePrint (order, amountPaid) {
      const features = 'width=200,height=500,location=no,toolbar=no,menubar=no'
      const printWindow = window.open(`print?order=${order.id}&amount_paid=${amountPaid}`, '', features)

      printWindow.onload = () => {
        printWindow.focus()
        setTimeout(() => {
          printWindow.print()
        }, 100)
        setTimeout(() => {
          printWindow.close()
        }, 100)
      }
    }
  }
}
</script>

<style lang="scss">
.pos-content {
  .header {
    height: 100px;
  }
  .body {
    min-height: calc(100% - 100px - 210px);
    max-height: calc(100% - 100px - 210px);
  }
  .footer {
    height: 210px;
  }
}
.pos-sidebar {
  .header {
    height: 100px;
  }
  .body {
    min-height: calc(100% - 100px - 210px);
    max-height: calc(100% - 100px - 210px);
  }
  .footer {
    height: 210px;
  }
}
</style>
