<template>
  <div :class="`alert alert-${variant}`" role="alert">
    {{ message }}
  </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";
export default defineComponent({
  props: {
    message: {
      type: String,
      required: true,
    },
    variant: {
      type: String,
      default: "warning",
    },
  },
});
</script>
