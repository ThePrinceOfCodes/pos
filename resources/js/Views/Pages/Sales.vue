<template>
  <div class="p-3">
    <div class="row">
      <!-- top -->
      <div class="col-md-12">
        <header-nav />
        <alert-bar v-if="hasError" :message="error" />
      </div>

      <!-- down -->
      <div class="col-md-12">
        <section id="cart_items" class="col-sm-12">
          <!-- search by reciept code -->
          <div>
            <h2 class="title text-center">Sales</h2>
            <input
              type="text"
              v-model="search"
              class="w-100 mb-4 form-control"
              placeholder="Search.."
            />
          </div>
          <!-- table -->
          <div class="table-responsive cart_info">
            <table class="table table-condensed">
              <thead>
                <tr class="cart_menu">
                  <td class="">
                    <button @click="printItems" class="btn btn-success btn-sm">
                      Print
                    </button>
                  </td>
                  <td class="description"><small>Item</small></td>
                  <td class="price"><small>Price</small></td>
                  <td class="quantity"><small>Quantity</small></td>
                  <td class="total"><small>Total</small></td>
                  <td class="receipt"><small>Payment Method</small></td>
                  <td class="receipt"><small>Transaction Ref</small></td>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(item, index) in filteredSales" :key="index">
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
                    <span class="text-muted">{{ item.quantity }}</span>
                  </td>
                  <td class="">
                    <span class="app-color">
                      {{ formatCurrency(item.total) }}
                    </span>
                  </td>
                  <td class="">
                    <span class="app-color">
                      {{ item.paymentMethod }}
                    </span>
                  </td>
                  <td class="">
                    <span class="app-color">
                      {{ item.reference }}
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
import { computed, defineComponent, ref } from "vue";
import { useCart, usePrint } from "@/services/cart.service";
import useCurrency from "@/services/currency.service";
import HeaderNav from "./HeaderNav.vue";
import useAuth from "@/services/auth.service";
import AlertBar from "@/Views/components/AlertBar.vue";
import { useCompanyInfo } from "@/services/utils.service";

export default defineComponent({
  components: {
    HeaderNav,
    AlertBar,
  },
  setup() {
    const search = ref("");
    const { formatCurrency } = useCurrency();
    const localItems = ref([]);
    const { error, hasError, sales, setSales } = useCart();
    const { user } = useAuth();
    const { print, formatForPrinting } = usePrint();
    const { companyDetails, setCompanyDetails } = useCompanyInfo();

    setCompanyDetails();

    const filteredSales = computed(() => {
      return sales.value.filter(
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
        (obj: any) =>
          obj.name.toLowerCase().indexOf(search.value.toLowerCase()) > -1 ||
          obj.price.indexOf(search.value) > -1 ||
          obj.paymentMethod.toLowerCase().indexOf(search.value.toLowerCase()) >
            -1 ||
          obj.reference.toLowerCase().indexOf(search.value.toLowerCase()) > -1
      );
    });

    const total = computed(() => {
      return filteredSales.value.reduce(
        // eslint-disable-next-line @typescript-eslint/no-explicit-any
        (acc, obj: any) => obj.price * obj.quantity + acc,
        0
      );
    });

    // print items on table
    const printItems = () => {
      print(
        formatForPrinting(filteredSales.value),
        { name: user.name, ...companyDetails },
        total.value || 0
      );
    };

    // get all sales
    setSales(Number(user.salesId));

    return {
      sales,
      filteredSales,
      error,
      hasError,
      localItems,
      formatCurrency,
      search,
      printItems,
    };
  },
});
</script>
