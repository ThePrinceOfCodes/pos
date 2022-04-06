<template>
  <product-list />
</template>

<script lang="ts">
import { defineComponent } from "vue";
import ProductList from "./ProductList.vue";
export default defineComponent({
  components: { ProductList },
});
</script>
