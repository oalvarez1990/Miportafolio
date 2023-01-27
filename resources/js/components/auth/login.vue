<!-- script de js -->
<script setup>
import { reactive, ref } from "vue";
import { useRouter } from "vue-router";

const router = useRouter();

let form = reactive({
    email: "",
    password: "",
});
let error = ref("");

const login = async () => {
    await axios.post("/api/login", form).then((response) => {
        // console.log(response);
        if (response.data.success) {
            console.log("Listing");
            localStorage.setItem("token", response.data.data.token);
            router.push("/admin/home");
        } else {
            error.value = response.data.message;
        }
    });
};
</script>

<template>
    <div class="login">
        <div class="formLo">
            <p class="text-danger" v-if="error">{{ error }}</p>
            <form @submit.prevent="login">
                <!-- Create input for email -->
                <input class="input_auth"
                    v-model="form.email"
                    type="email"
                    placeholder="Enter you Email"
                />
                <br />
                <!-- Create input for password -->
                <input class="input_auth"
                    v-model="form.password"
                    type="password"
                    placeholder="Enter you Password"
                />
                <br />
                <!-- Create button for login -->
                <input type="submit" value="submit" class="submit input_auth" />
            </form>
        </div>
    </div>
</template>
<!-- Create css for login -->
<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
.login {
    background-color: #6c5ce7;
    padding: 0;
    margin: 0;
    height: 100vh;
    width: 100%;
}
.formLo {
    display: flex;
    align-items: center;
    width: 22.8em;
    height: 55em;
    margin: 1em auto 0 auto;
    overflow: hidden;
}
.input_auth {
    background: white;
    background-position: 0.5em 0.6em;
    border: none;
    color: rgb(80, 80, 80, 1);
    padding: 0 0 0 4rem;
    margin: 0 0 1em 0;
    width: 20em;
    height: 2.8em;
    outline: none;
    transition: background-color 0.4s;
    border-radius: 0.5em;
}
.input_auth:hover {
    background-color: rgb(255, 255, 255, 255);
}
.input_auth:focus {
    background-color: rgb(255, 255, 255, 255);
}
.submit {
    color: 35, 35, 35, 0.8;
    background-color: rgb(255, 255, 255, 1);
    padding: 0;
    /* margin: 2.5em 0 0 7em; */
    width: 20em;
    text-transform: uppercase;
    cursor: pointer;
    transition: background-color 0.4s;
    /* bold */
    font-weight: 600;
}
.submit:hover {
    background-color: rgb(255, 255, 255, 255);
    color: #ffffff;
}
.submit:focus {
    background: #43467f;
    color: #ffffff;
}
.text-danger {
    color: red;
}
</style>
