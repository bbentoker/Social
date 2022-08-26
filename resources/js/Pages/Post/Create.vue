<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, useForm } from "@inertiajs/inertia-vue3";
import { ref } from "vue";

const props = defineProps(["StoreLink"]);

const url = props.StoreLink;
const caption = ref(null);
const image = ref(null);

function submit() {
    const form = useForm({
        caption: caption.value,
        image: image.value,
    });
    
    form.post(url);
}
function setImage(e) {
    image.value = e.target.files[0];
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
                            <div class="mb-6">
                                <label
                                    for="caption"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Caption</label
                                >
                                <input
                                    type="text"
                                    id="caption"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    v-model="caption"
                                    placeholder="Caption"
                                />
                            </div>
                            <div class="mb-6">
                                <label
                                    for="image"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300"
                                    >Image</label
                                >
                                <input
                                    type="file"
                                    id="image"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    v-on:change="setImage"
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
