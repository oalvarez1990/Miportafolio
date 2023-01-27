<script setup>
import Base from "../layouts/base.vue";
import { onMounted, ref } from "vue";

let form = ref({
    name: "",
    photo: "",
    email: "",
    phone: "",
    address: "",
    description: "",
    tagline: "",
    cv: "",
});

onMounted(async () => {
    getAbout();
});
const getAbout = async () => {
    // await axios.get("/api/about").then((response) => {
    //     console.log(response);
    //     if (response.data.success) {
    //         form.value = response.data.data;
    //     }
    // });
    let response = await axios.get("/api/about");
    form.value = response.data;
    console.log("form", form.value);
};
const getPhoto = () => {
    let photo = "/img/avatar.png";
    if (form.value.photo) {
        if (form.value.photo.indexOf("base64") != -1) {
            photo = form.value.photo;
        }
    } else {
        photo = "/public/img/upload" + form.value.photo;
    }
    return photo;
};
const changePhoto = (e) => {
    let file = e.target.files[0];
    let reader = new FileReader();
    let limit = 1024 * 1024 * 2;
    if (file.size > limit) {
        // alert('File size is too large')
        // return
        swal({
            title: "Error!",
            text: "File size is too large",
            icon: "error",
            button: "Ok",
        });
        return false;
    }
    reader.onloadend = () => {
        form.value.cv = reader.result;
    };
    reader.readAsDataURL(file);
};
const uploadCv = (e) => {
    let file = e.target.files[0];
    let reader = new FileReader();
    let limit = 1024 * 1024 * 2;
    if (file.size > limit) {
        // alert('File size is too large')
        // return
        swal({
            title: "Error!",
            text: "File size is too large",
            icon: "error",
            button: "Ok",
        });
        return false;
    }
    reader.onloadend = () => {
        form.cv = reader.result;
    };
    reader.readAsDataURL(file);
};
const update_about = async () => {
    await axios
        .post(`/api/update_about ${form.value.id}`, form.value)
        .then((response) => {
            console.log(response);
            if (response.data.success) {
                swal({
                    title: "Success!",
                    text: "Data has been updated",
                    icon: "success",
                    button: "Ok",
                });
            }
        });
};
</script>

<template>
    <Base />
    <main class="main">
        <!-- Side Nav Dummy-->
        <div class="main__sideNav"></div>
        <!-- End Side Nav -->
        <!-- Main Content -->
        <div class="main__content">
            <!--==================== ABOUT ====================-->
            <section class="about section" id="about">
                <div class="about_container">
                    <div class="titlebar">
                        <div class="titlebar_item">
                            <h1>About Us</h1>
                        </div>
                        <div class="titlebar_item">
                            <div
                                class="btn btn-secondary"
                                @click.prevent="updateAbout"
                            >
                                Save Changes
                            </div>
                        </div>
                    </div>
                    <div class="card_wrapper">
                        <div class="wrapper_left">
                            <div class="card">
                                <p>Full Name</p>
                                <input
                                    type="text"
                                    class="input"
                                    v-model="form.name"
                                />

                                <p>Email</p>
                                <input
                                    type="email"
                                    class="input"
                                    v-model="form.email"
                                />

                                <p>Phone</p>
                                <input
                                    type="text"
                                    class="input"
                                    v-model="form.phone"
                                />

                                <p>Address</p>
                                <input
                                    type="text"
                                    class="input"
                                    v-model="form.address"
                                />

                                <p>Description</p>
                                <textarea
                                    cols="10"
                                    rows="5"
                                    v-model="form.description"
                                ></textarea>
                            </div>
                            <div class="card">
                                <p>Tagline</p>
                                <input
                                    type="text"
                                    class="input"
                                    v-model="form.tagline"
                                />
                            </div>
                        </div>

                        <div class="wrapper_right">
                            <div class="card">
                                <div class="avatar_profile">
                                    <img
                                        :src="getPhoto()"
                                        alt=""
                                        class="avatar_profile_img"
                                    />
                                </div>
                                <input
                                    type="file"
                                    id="fileimg"
                                    @change="changePhoto"
                                />
                            </div>
                            <div class="card">
                                <p>CV</p>
                                <input
                                    type="file"
                                    id="filecv"
                                    @change="uploadCv"
                                />
                            </div>
                        </div>
                    </div>
                    <div class="titlebar">
                        <div class="titlebar_item"></div>
                        <div class="titlebar_item">
                            <div
                                class="btn btn-secondary"
                                @click.prevent="update_about"
                            >
                                Save Changes
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <!-- End Main Content -->
    </main>
</template>
