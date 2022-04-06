<template>
  <div class="p-3">
    <div class="row">
      <!-- top -->
      <div class="col-md-12">
        <header-nav />
        <alert-bar v-if="hasError" :message="error" />
      </div>
      <!-- Right -->
      <div class="col-md-12 col-lg-6">
        <left />
      </div>
      <!-- Left -->
      <div class="col-md-12 col-lg-6">
        <right />
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { useCart } from "@/services/cart.service";
import { defineComponent, provide, reactive } from "vue";
import HeaderNav from "../HeaderNav.vue";
import Left from "./Left/Left.vue";
import Right from "./Right/Right.vue";
import AlertBar from "@/Views/components/AlertBar.vue";
import { CartItem } from "@/types";

export default defineComponent({
  name: "Home",
  components: { Left, HeaderNav, Right, AlertBar },
  setup() {
    const { setCategories, error, hasError } = useCart();

    // get categories from serve and save in state
    setCategories();

    const cartItems = reactive<CartItem[]>([]);
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const addToCart = (item: any) => {
      if (
        !cartItems.some((obj) => obj.id === item.id) &&
        item.quantity <= item.stock &&
        item.quantity > 0
      ) {
        cartItems.push(item);
      }
    };
    const removeFromCart = (id: number) => {
      const index = cartItems.findIndex((obj) => obj.id === id);
      cartItems.splice(index, 1);
    };
    const clearCart = () => {
      while (cartItems.length > 0) {
        cartItems.pop();
      }
    };
    provide("addToCart", addToCart);
    provide("removeFromCart", removeFromCart);
    provide("clearCart", clearCart);
    provide("cartItems", cartItems);

    return { error, hasError };
  },
});
</script>
