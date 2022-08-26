<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head,useForm } from "@inertiajs/inertia-vue3";
import {ref} from 'vue';

const props = defineProps(['Profile', 'User','UpdateUrl']);

const url = props.UpdateUrl;

const profile = props.Profile;
const user = props.User;

const image = ref(null)
const password = ref(null)
const password_confirmation = ref(null)

 

function setImage(e){
    image.value = e.target.files[0]
}

function submit(){
    const form = useForm({
        username: profile.username,
        title: profile.title,
        description: profile.description,
        url: profile.url,
        email: user.email,
        password: password.value,
        password_confirmation: password_confirmation.value,
        image: image.value,
    });

    Inertia.post(url,{
        _method : "PUT",
        ...form
    });

    
}
</script>

<template>
    <Head title="Profile-Edit" />

    <BreezeAuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <form @submit.prevent="submit">
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label
                                        for="username"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        >Username</label
                                    >
                                    <input
                                        type="text"
                                        id="username"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Username"
                                        v-model="profile.username"
                                        required=""
                                    />
                                </div>
                                <div>
                                    <label
                                        for="title"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        >Title</label
                                    >
                                    <input
                                        type="text"
                                        id="title"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Title"
                                        v-model="profile.title"
                                    />
                                </div>
                                <div>
                                    <label
                                        for="description"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        >Description</label
                                    >
                                    <input
                                        type="text"
                                        id="description"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Description"
                                        v-model="profile.description"
                                    />
                                </div>
                                <div>
                                    <label
                                        for="url"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                        >Url</label
                                    >
                                    <input
                                        type="url"
                                        id="url"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="url"
                                        v-model="profile.url"
                                    />
                                </div>
                            </div>
                            <div class="mb-6">
                                <label
                                    for="image"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Profile image</label
                                >
                                <input
                                    type="file"
                                    id="image"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    v-on:change="setImage"
                                    placeholder="•••••••••"
                                />
                            </div>
                            <div class="mb-6">
                                <label
                                    for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Email address</label
                                >
                                <input
                                    type="email"
                                    id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Email"
                                    v-model="user.email"
                                    required=""
                                />
                            </div>
                            <div class="mb-6">
                                <label
                                    for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Password</label
                                >
                                <input
                                    type="password"
                                    id="password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    v-model="password"
                                    placeholder="•••••••••"
                                />
                            </div>
                            <div class="mb-6">
                                <label
                                    for="password_confirmation"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Confirm password</label
                                >
                                <input
                                    type="password"
                                    id="password_confirmation"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    v-model="password_confirmation"
                                    placeholder="•••••••••"
                                />
                            </div>
                            <button
                                type="submit"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            >
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
