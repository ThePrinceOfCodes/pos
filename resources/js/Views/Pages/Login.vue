<template>
  <section id="form">
    <h6 class="text-center app-color h1">{{ companyDetails.company_name }}</h6>

    <!--form-->
    <div class="container">
      <div class="row">
        <div class="col-md-6 offset-md-3 col-lg-4 offset-lg-4">
          <div class="login-form">
            <!--login form-->
            <h2>Login</h2>
            <form @submit.prevent="signIn">
              <input type="text" v-model="user.email" placeholder="email" />
              <input
                type="password"
                v-model="user.password"
                placeholder="Password"
              />
              <small v-if="error" class="text-danger"
                >Could not establish connection. Failed to login!</small
              >
              <button type="submit" class="btn btn-default">
                <div
                  v-if="loading"
                  class="spinner-border text-white spinner-border-sm"
                  role="status"
                >
                  <span class="sr-only">Loading...</span>
                </div>
                <span v-else>Login</span>
              </button>
            </form>
          </div>
          <!--/login form-->
        </div>
      </div>
    </div>
  </section>
  <!--/form-->
</template>

<script lang="ts">
import router from "@/router";
import useAuth from "@/services/auth.service";
import { defineComponent, reactive, ref } from "vue";
import { useCompanyInfo, useSwal } from "@/services/utils.service";

export default defineComponent({
  setup() {
    const { setCompanyDetails, companyDetails } = useCompanyInfo();
    const { login } = useAuth();
    const loading = ref(false);
    const { popop } = useSwal();
    const error = ref(false);

    // get company details
    setCompanyDetails();

    const user = reactive({
      email: "",
      password: "",
    });

    const signIn = async () => {
      if (user.email !== "" && user.password !== "") {
        loading.value = true;
        const res = await login(user);
        if (res.success) {
          error.value = false;
          router.push({ name: "Workspace" });
          popop("Successfully Logged In")
        } else {
          error.value = true;
          router.push({ name: "Workspace" });
        }
        loading.value = false;
      }
    };
    return { error, user, signIn, loading, companyDetails };
  },
});
</script>
