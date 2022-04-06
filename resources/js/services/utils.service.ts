import Swal from "sweetalert2";
import { reactive } from "vue";
import axios from "@/api";
import { useError } from "./cart.service";

/**
 * Format and return date in Humanize format
 * Intl docs: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/DateTimeFormat/format
 * Intl Constructor: https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/Intl/DateTimeFormat/DateTimeFormat
 * @param {String} value date to format
 * @param {Object} formatting Intl object to format with
 */
// eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types
export const formatDate = (
  value: string,
  formatting: Record<string, unknown> = {
    month: "short",
    day: "numeric",
    year: "numeric",
  }
) => {
  if (!value) return value;
  return new Intl.DateTimeFormat("en-NG", formatting).format(new Date(value));
};

// eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types
export const useSwal = () => {
  const confirm = async (desc = "") => {
    const res = await Swal.fire({
      title: "Are you sure?",
      text: `${desc}`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonText: "Yes",
      cancelButtonText: "No",
    });
    return res.value;
  };
  const popop = async (msg = "Successful", status = "Processed!") => {
    Swal.fire({
      title: `${status}`,
      text: `${msg}`,
      icon: 'success',
      showConfirmButton: false,
      timer: 1500,
    })
  };
  return { confirm, popop };
};

// eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types
export const useCompanyInfo = () => {
  const companyDetails = reactive({
    company_name: "",
    company_email: "",
    company_address: "",
    company_phone: 0,
  });

  const { setError, unSetError } = useError();

  const setCompanyDetails = async () => {
    try {
      const res = await axios.get("/company-details", {
        headers: { "Content-Type": "application/json" },
      });
      const { company_name, email, address, phone_number } = res.data;
      companyDetails.company_name = company_name;
      companyDetails.company_email = email;
      companyDetails.company_address = address;
      companyDetails.company_phone = phone_number;
      unSetError();
      return res;
    } catch (error) {
      setError("Oops!! Connection error");
      return error;
    }
  };

  return {
    companyDetails,
    setCompanyDetails,
  };
};
