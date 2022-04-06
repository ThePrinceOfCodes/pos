<template>
  <div class="left-sidebar">
    <h2>Category</h2>
    <input
      type="text"
      v-model="search"
      class="w-100 form-control form-control-sm"
      placeholder="Search category.."
    />
    {{ categories }}
    <div class="panel-group category-products">
      <div
        v-for="category in filteredCategories"
        :key="category.id"
        @click="setSelectedCategory(category.id)"
        class="panel panel-default"
      >
        <div class="panel-heading btn">
          <small
            :class="`${
              selectedCategory === category.id
                ? 'text-primary'
                : 'text-secondary'
            }`"
          >
            {{ category.name.toUpperCase() }}
          </small>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { useCart } from "@/services/cart.service";
import { computed, defineComponent, ref } from "vue";

interface Category {
  id: number;
  name: string;
}
export default defineComponent({
  setup() {
    const search = ref("");
    const { selectedCategory, setSelectedCategory, categories } = useCart();

    const filteredCategories = computed(() => {
      return categories.value.filter(
        (obj: Category) =>
          obj.name.toLowerCase().indexOf(search.value.toLowerCase()) > -1
      );
    });
    return {
      search,
      selectedCategory,
      setSelectedCategory,
      categories,
      filteredCategories,
    };
  },
});
</script>
