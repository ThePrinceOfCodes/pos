<template>
  <div class="row">
    <section class="col-sm-12">
      <h2 class="title text-center">Cart</h2>
    </section>
    <section id="cart_items" class="col-sm-12">
      <div class="table-responsive cart_info">
        <table class="table table-condensed">
          <thead>
            <tr class="cart_menu">
              <td class=""><small>#</small></td>
              <td class="description"><small>Item</small></td>
              <td class="price"><small>Price</small></td>
              <td class="quantity"><small>Quantity</small></td>
              <td class="total"><small>Total</small></td>
              <td class="">
                <span
                  class="btn btn-sm btn-danger rounded-circle"
                  @click="clearCart"
                >
                  Clear
                </span>
              </td>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in localItems" :key="item.name">
              <td class="">
                <span class="text-muted">{{ `${index + 1}.` }}</span>
              </td>
              <td class="">
                <span class="text-muted">{{ item.name }}</span>
              </td>
              <td class="app-color">
                <span>{{ formatCurrency(item.price) }}</span>
              </td>
              <td class="">
                <div class="d-flex">
                  <span
                    class="btn btn-sm btn-light"
                    @click="item.quantity < 2 ? 1 : item.quantity--"
                    href=""
                  >
                    -
                  </span>

                  <input
                    class="form-control-sm my-auto"
                    type="number"
                    min="1"
                    oninput="validity.valid||(value=1);"
                    name="quantity"
                    v-model="item.quantity"
                    autocomplete="off"
                  />
                  <span class="btn btn-sm btn-light" @click="item.quantity++">
                    +
                  </span>
                </div>
              </td>
              <td class="">
                <span class="app-color">
                  {{ formatCurrency(item.price * item.quantity) }}
                </span>
              </td>
              <td class="text-center">
                <span
                  @click="removeFromCart(item.id)"
                  class="btn btn-sm text-danger rounded-circle"
                  ><font-awesome-icon icon="times" />
                </span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </section>
  </div>

  <!--/#cart_items-->
</template>

<script lang="ts">
import { defineComponent, inject, ref } from "vue";
import useCurrency from "@/services/currency.service";
export default defineComponent({
  props: {
    items: {
      type: Array,
      rquired: true,
    },
  },
  setup(props) {
    const { formatCurrency } = useCurrency();
    const localItems = ref(props.items);
    const removeFromCart = inject("removeFromCart");
    const clearCart = inject("clearCart");
    return { localItems, removeFromCart, clearCart, formatCurrency };
  },
});
</script>
