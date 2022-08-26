<script setup>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import { Link } from "@inertiajs/inertia-vue3";

const props = defineProps(["Profile", "Link"]);
const profile = props.Profile;
const link = props.Link;
</script>

<template>
    <Head title="Profile" />

    <BreezeAuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div class="flex flex-row m-5">
                            <div class="basis-1/4 m-5">
                                <img
                                    v-bind:src="profile.image"
                                    class="profile-image"
                                />
                            </div>
                            <div class="basis-3/4 bio">
                                <div class="flex flex-col">
                                    <div class="basis-1/3 text-lg font-bold">
                                        <div class="flex flex-row">
                                            <div class="basis-1/4">
                                                {{ profile.username }}
                                            </div>
                                            <div class="basis-1/4">
                                                <Link :href="link">
                                                    <button
                                                        class="bg-blue-500 px-5 py-2 font-sans text-sm rounded text-white hover:bg-blue-600"
                                                    >
                                                        Edit
                                                    </button>
                                                </Link>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="basis-1/3 text-sm mt-5">
                                        {{ profile.title }}
                                    </div>
                                    <div class="basis-1/3 text-sm mt-5">
                                        {{ profile.description }}
                                    </div>
                                    <div class="basis-1/3 text-sm mt-8">
                                        <b
                                            >followers
                                            {{
                                                profile.follower_count
                                            }}
                                            following
                                            {{ profile.following_count }}</b
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />
                        <div class="m-5 grid grid-cols-3 gap-4">
                                <Link :href="route('posts.create')">
                                    <!-- center an image vertically and horizontally in this container -->
                                    <div class="flex items-center justify-center border-solid border-2">
                                        <div style="height: 20rem;">
                                            <img src="/plus.png" style="height: 10rem;margin-top:5rem;">
                                        </div>
                                    </div>

                                </Link>
                            <div v-for="post in profile.posts" :key="post.id" class="border-solid border-2">
                                <Link :href="route('posts.show', post.id)">
                                    <img v-bind:src="post.image" style="height: 20rem;" />
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<style>
.profile-image {
    margin-left: 3em;
    border-radius: 50%;
    height: 11rem;
}
.bio {
    margin-top: 1.5em;
}
.username {
    font-size: 1.3rem;
}
</style>
