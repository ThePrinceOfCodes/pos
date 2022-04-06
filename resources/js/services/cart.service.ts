/* eslint-disable @typescript-eslint/no-explicit-any */
/* eslint-disable @typescript-eslint/explicit-module-boundary-types */
import { ReceiptDetails } from "@/types";
import axios from "@/api";
import { computed, reactive } from "vue";
import { formatDate } from "./utils.service";
import useCurrency from "@/services/currency.service";

const state = reactive({
    categories: [],
    allProducts: [],
    paymentMethods: [],
    sales: [],
    selectedCategory: 1,
    error: "",
    hasError: false,
});

export const useError = () => {
    const error = computed(() => state.error);
    const hasError = computed(() => state.hasError);
    const setError = (error: string) => {
        state.error = error;
        state.hasError = true;
    };
    const unSetError = () => {
        state.error = "";
        state.hasError = false;
    };

    return { error, hasError, setError, unSetError };
};

export const useCart = () => {
    const { setError, unSetError } = useError();
    const setSelectedCategory = (val: number) => {
        state.selectedCategory = val;
    };
    const selectedCategory = computed(() => state.selectedCategory);
    const paymentMethods = computed(() => state.paymentMethods);
    const categories = computed(() => state.categories);
    const sales = computed(() => state.sales);
    const error = computed(() => state.error);
    const hasError = computed(() => state.hasError);

    const products = computed(() =>
        state.allProducts.filter(
            (obj: any) => obj.category === state.selectedCategory
        )
    );

    //   get all categories from server
    const setCategories = async () => {
        try {
            const res = await axios.get("/categories", {
                headers: { "Content-Type": "application/json" },
            });
            state.categories = res.data;
            unSetError();
            return res;
        } catch (error) {
            // state.error = error.response.data;
            setError("Oops!! Error connecting to serve please refresh your browser");
            return error;
        }
    };

    //   get products for selected category
    const setProducts = async () => {
        try {
            const res = await axios.get("/products", {
                headers: { "Content-Type": "application/json" },
            });
            state.allProducts = res.data;
            unSetError();
            return res;
        } catch (error) {
            setError("Oops!! Error connecting to serve please refresh your browser");
            return error;
        }
    };

    //   get payment methods
    const setPaymentMethods = async () => {
        try {
            const res = await axios.get("/payment-methods", {
                headers: { "Content-Type": "application/json" },
            });
            state.paymentMethods = res.data;
            unSetError();
            return res;
        } catch (error) {
            setError("Oops!! Error connecting to serve please refresh your browser");
            return error;
        }
    };

    //   get sales
    const setSales = async (sale: number) => {
        try {
            const res = await axios.get(`/get-sales/${sale}`, {
                headers: { "Content-Type": "application/json" },
            });
            state.sales = res.data.map((obj: any) => ({
                id: obj.id,
                name: obj.product.name,
                price: obj.product.price,
                quantity: obj.quantity,
                total: obj.total,
                paymentMethod: obj.payment_method.name,
                reference: obj.reference,
            }));
            unSetError();
            return res;
        } catch (error) {
            setError("Oops!! Unable to get sales");
            return error;
        }
    };

    //   post transaction
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const postItems = async (items: any) => {
        try {
            const res = await axios.post("/make-sales", items, {
                headers: { "Content-Type": "application/json" },
            });
            unSetError();
            return res;
        } catch (error) {
            // state.error = error.response.data;
            console.log(error);
            setError("Oops!! Could not process items this time");
            return error;
        }
    };

    return {
        setCategories,
        setProducts,
        setPaymentMethods,
        setSales,
        postItems,
        setSelectedCategory,
        selectedCategory,
        paymentMethods,
        categories,
        products,
        sales,
        error,
        hasError,
    };
};

export const usePrint = () => {
    const { formatCurrency } = useCurrency();

    // formatted for printing
    const formatForPrinting = (items: any) => {
        return items.map((item: any, index: number) => ({
            index: index + 1,
            name: item.name,
            price: formatCurrency(item.price),
            quantity: item.quantity,
            total: formatCurrency(item.price * item.quantity),
        }));
    };

    const print = (items: any, details: ReceiptDetails, total: number, txref: any) => {
        let trs = "";
        items.forEach((item: any) => {
            trs += `<tr>`;
            // eslint-disable-next-line @typescript-eslint/no-unused-vars
            for (const [key, value] of Object.entries(item)) {
                trs += `<td>${value}</td>`;
            }
            trs += "</tr>";
        });

        const printWindow = window.open("", "", "width=800, height=600");

        printWindow?.document.write(`<!DOCTYPE html>
      <html>
        <head>
          <style>
            #frame {
              box-shadow: 0 0 1in -0.25in rgba(0, 0, 0, 0.5);
              padding: 2rem;
              margin: 0 auto;
              width: 25rem;
              background: #FFF;
            }
            table{
              width: 100%;
              border-collapse: collapse;
              margin-bottom: 5px;
            }
            .total {
              font-weight: bold;
            }
            .total-table {
              margin-top: 2.5rem;
            }
            .header-item {
              margin-top: 0.5rem;
              margin-bottom: 0.5rem;
              text-align: center;
            }
            .left {
              float: left;
            }
            .right {
              float: right;
            }
            .clear {
              clear: both;
              margin-top: 0.5rem;
              margin-bottom: 0;
            }
          </style>
        </head>
        <body>
          <div>
            <h4 class="header-item total">${details.company_name}</h4>
            <p class="header-item">${details.company_address}</p>
            <p class="header-item">${details.company_phone}</p>
            <p class="header-item">Transaction Receipt</p>
            <p class="header-item">${txref}</p>
            <p>
              <span class="left">Cashier: ${details.name}</span>
              <span class="right">Date: ${formatDate(Date())}</span>
            </p>
            <p class="clear">Items</p>
            <table>
              <tbody>
                <tr>
                  <td>#</td><td>Name</td><td>Price</td><td>Qty</td><td>Total</td>
                </tr>
                ${trs}
                <tr class="total">
                  <td></td>
                  <td></td>
                  <td>Total:</td>
                  <td></td>
                  <td>${formatCurrency(total)}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </body>
      </html>`);

        printWindow?.focus();
        printWindow?.print();
        printWindow?.close();
    };
    return { print, formatForPrinting };
};
