<template>
  <div class="product-image-wrapper">
    <div class="single-products">
      <div class="productinfo text-center">
        <img
          v-if="localItem.image === undefined"
          src="@/assets/Floral-Dolphin.svg"
          width="70"
          height="50"
        />
        <img v-else :src="localItem.image" width="70" height="50" alt="" />
        <h6 class="app-color">{{ formatCurrency(item.price) }}</h6>
        <p class="app-color">{{ localItem.name }}</p>
        <p class="mt-0">{{ `In stock: ${localItem.stock}` }}</p>
        <small>Qty: </small>
        <input
          v-model="localItem.quantity"
          class="form-control mb-2 text-center"
          min="1"
          oninput="validity.valid||(value=1);"
          type="number"
        />
        <a
          href="#"
          @click="$emit('item-selected', localItem)"
          class="btn btn-default add-to-cart"
        >
          <font-awesome-icon icon="shopping-cart" />
          <span>Add to cart</span></a
        >
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { defineComponent, PropType, reactive } from "vue";
import useCurrency from "@/services/currency.service";
import { CartItem } from "@/types";

export default defineComponent({
  props: {
    item: {
      type: Object as PropType<CartItem>,
      required: true,
    },
  },
  setup(props) {
    const { formatCurrency } = useCurrency();
    const localItem = reactive(props.item);
    const format = (val: number) => {
      localItem.quantity = val >= 1 ? val : localItem.quantity;
    };
    return { localItem, formatCurrency, format };
  },
});
</script>
