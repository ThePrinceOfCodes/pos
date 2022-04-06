import useAuth from "./services/auth.service";
import axios from "./api";

const { logout } = useAuth();

axios.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem("token");
    // eslint-disable-next-line no-param-reassign
    config.headers.Authorization = `Bearer ${token}`;
    return config;
  },
  (error) => Promise.reject(error)
);

axios.defaults.timeout = 10000;

axios.interceptors.response.use(
  (response) => response.data,
  (error) => {
    // eslint-disable-next-line no-underscore-dangle
    if (
      error.response &&
      error.response.status === 401 &&
      error.response.config &&
      !error.response.config.__isRetryRequest
    ) {
      logout();
    }
    return Promise.reject(error);
  }
);
