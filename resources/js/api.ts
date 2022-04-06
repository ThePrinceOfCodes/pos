import axios from "axios";

const baseURL = process.env.MIX_VUE_APP_BASE_URL;
export default axios.create({
  baseURL,
});
