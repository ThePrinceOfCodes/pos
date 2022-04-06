// eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types
export default function useCurrency() {
  const currency = "₦";
  const formatCurrency = (val: number) =>
    new Intl.NumberFormat("en-NG", {
      style: "currency",
      currency: "NGN",
    }).format(val);
  return { currency, formatCurrency };
}
