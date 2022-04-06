<template>
  <cart :items="cartItems" />
  <div v-show="cartItems.length > 0" class="">
    <span class="form-control text-center">
      {{
        `Items: ${cartItems.length}, Total Amount:  ${formatCurrency(total)}`
      }}
    </span>
    <div class="d-flex justify-content-end">
      <select v-model="payment_method" class="form-control mt-auto w-50 mr-2">
        <option
          v-for="method in paymentMethods"
          :value="method.id"
          :key="method.id"
        >
          {{ method.name }}
        </option>
      </select>
      <button @click="sendToServer" class="btn btn-primary form-control w-50">
        <small>Process</small>
      </button>
    </div>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent, inject, ref } from "vue";
import Cart from "./Cart.vue";
import useCurrency from "@/services/currency.service";
import { useCart, usePrint } from "@/services/cart.service";
import { CartItem } from "@/types";
import useAuth from "@/services/auth.service";
import { useCompanyInfo, useSwal } from "@/services/utils.service";

export default defineComponent({
  components: { Cart },
  setup() {
    const payment_method = ref(1);
    const { formatCurrency } = useCurrency();
    const { print, formatForPrinting } = usePrint();
    const cartItems = inject<CartItem[]>("cartItems");
    const { user } = useAuth();
    const { postItems, setPaymentMethods, paymentMethods, setProducts } =
      useCart();
    const { confirm } = useSwal();
    const { companyDetails, setCompanyDetails } = useCompanyInfo();
    const clearCart = inject<any>("clearCart");

    const { salesId, name } = user;

    // formatted for sending to server
    const paymentItems = computed(() =>
      cartItems?.map((item) => ({
        product_id: item.id,
        price: item.price,
        qty: item.quantity,
        total_amount: item.price * item.quantity,
      }))
    );

    // get details
    setCompanyDetails();
    // set payment methods
    setPaymentMethods();

    const total = computed(() => {
      return cartItems?.reduce((acc, obj) => obj.price * obj.quantity + acc, 0);
    });

    // send items in cart to server for recording. call endpoint (make-sales)
    const sendToServer = async () => {
      const result = await confirm();
      if (result) {
        const res = await postItems({
          salesID: salesId,
          items: paymentItems.value,
          payment_method: payment_method.value,
        });
        if (res.success) {

            console.log(res);
          // print reciept
          printItems(res.data.txref);
          // refresh server
          setProducts();
          clearCart();
        }
      }
    };

    // print items on the table
    const printItems = (txref) => {
      print(
        formatForPrinting(cartItems),
        { name, ...companyDetails },
        total.value || 0,
        txref
      );
    };

    return {
      cartItems,
      total,
      formatCurrency,
      payment_method,
      paymentMethods,
      sendToServer,
    };
  },
});
</script>
