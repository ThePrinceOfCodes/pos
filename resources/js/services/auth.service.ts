import axios from "@/api";
import router from "@/router";
import { reactive } from "vue";
import { useError } from "./cart.service";

// eslint-disable-next-line @typescript-eslint/explicit-module-boundary-types
export default function useAuth() {
    const { setError, unSetError } = useError();

    const user = reactive({
        id: null,
        name: localStorage.getItem("name") || "",
        salesId: localStorage.getItem("salesId") || "",
    });

    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const saveItems = (data: any) => {
        localStorage.setItem("token", data.token);
        localStorage.setItem("name", data.user.name);
        localStorage.setItem("salesId", data.salesId);
    };

    const removeItems = () => {
        localStorage.removeItem("token");
        localStorage.removeItem("name");
        localStorage.removeItem("salesId");
    };

    //   login
    // eslint-disable-next-line @typescript-eslint/no-explicit-any
    const login = async (items: any) => {
        try {
            const res = await axios.post("/login", items);
            saveItems(res.data);
            unSetError();
            return res;
        } catch (error) {
            console.log(error);
            setError("Oops!! Unable to Login");
            return error;
        }
    };

    //   close Shift
    const closeShift = async (sale: number) => {
        try {
            const res = await axios.get(`/close-shift/${sale}`);
            unSetError();
            removeItems();
            return res;
        } catch (error) {
            removeItems();
            setError("Oops!! Error performing operation");
            return error;
        }
    };

    //   logout
    const logout = async () => {
        if (localStorage.getItem("token") !== null && localStorage.getItem("token") !== undefined) {
            try {
                const res = await axios.post("/logout");
                unSetError();
                removeItems();
                router.push({ name: "Login" });
                return res;
            } catch (error) {
                removeItems();
                setError("Oops!! Error performing operation");
                return error;
            }
        } else {
            router.push({ name: "Login" });
        }
    };

    return { user, login, logout, closeShift };
}
