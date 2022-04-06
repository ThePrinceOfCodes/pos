<template>
  <div class="features_items row">
    <!-- category select -->
    <div class="col-sm-6">
      <h2 class="title text-center">Category</h2>
      <select v-model="category" class="w-100 mb-4 form-control">
        <!-- <option value="null">--Select Category--</option> -->
        <option v-for="cat in categories" :value="cat.id" :key="cat.id">
          {{ cat.name }}
        </option>
      </select>
    </div>
    <!-- products search -->
    <div class="col-sm-6">
      <h2 class="title text-center">Products</h2>
      <input
        type="text"
        v-model="search"
        class="w-100 mb-4 form-control"
        placeholder="Search products.."
      />
    </div>
    <!-- product list -->
    <div
      class="col-sm-4 col-md-4 col-lg-3"
      v-for="item in filteredProducts"
      :key="item.id"
    >
      <item :item="item" @item-selected="addToCart" />
    </div>
  </div>
</template>
<script lang="ts">
import { computed, defineComponent, inject, ref, watch } from "vue";
import Item from "@/Views/components/Item.vue";
import { useCart } from "@/services/cart.service";
import { CartItem } from "@/types";

export default defineComponent({
  components: { Item },
  setup() {
    const search = ref("");
    const category = ref(1);
    const { categories, setSelectedCategory, products, setProducts } =
      useCart();

    watch(category, (val: number) => {
      setSelectedCategory(val);
    });

    const filteredProducts = computed(() => {
      return products.value.filter(
        (obj: CartItem) =>
          obj.name.toLowerCase().indexOf(search.value.toLowerCase()) > -1
      );
    });

    // get all products from server
    setProducts();

    const polling = ref();
    // refetch products
    const setItems = () => {
      polling.value = setInterval(() => {
        setProducts();
      }, 120000);
    };

    setItems();

    const addToCart = inject("addToCart");
    return {
      search,
      category,
      categories,
      products,
      addToCart,
      filteredProducts,
    };
  },
});
</script>
