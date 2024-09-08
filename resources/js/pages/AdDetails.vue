<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <!-- Подробности объявления -->
            <div
                class="bg-white p-8 rounded-lg shadow-sm border border-gray-200"
            >
                <!-- Картинки -->
                <div v-if="ad.photo_links.length" class="mb-6">
                    <div
                        class="space-x-4 overflow-x-auto grid grid-cols-3 justify-items-center"
                    >
                        <img
                            v-for="(url, index) in ad.photo_links"
                            :key="index"
                            :src="url"
                            alt="Photo"
                            class="object-cover rounded-md max-h-48"
                        />
                    </div>
                </div>

                <!-- Название -->
                <h2 class="text-3xl font-semibold text-gray-800 mb-4">
                    {{ ad.title }}
                </h2>

                <!-- Описание -->
                <p class="text-gray-600 mb-4">
                    {{ ad.description }}
                </p>

                <!-- Цена -->
                <p class="text-lg font-medium text-gray-800 mb-6">
                    {{ ad.price }} ₽
                </p>

                <!-- Кнопка назад -->
                <router-link
                    :to="{ name: 'AdList' }"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                >
                    Назад к списку
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { useRoute } from "vue-router";
import api from "@/api";

const ad = ref({
    title: "",
    description: "",
    price: "",
    photo_links: [],
});

const route = useRoute();

onMounted(() => {
    const adId = route.params.id;
    api.post("/ads/show/" + adId, {
        fields: "photo_links,description",
    }).then((response) => {
        ad.value = response.data;
        console.log(response.data);
    });
});
</script>

<style scoped></style>
