<template>
    <div class="min-h-screen flex items-start justify-center bg-gray-50 py-8">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Список объявлений
                </h2>
                <div class="flex items-center gap-4">
                    <v-select
                        :options="options"
                        v-model="selected"
                        :clearable="false"
                        label="title"
                        class="w-48"
                    >
                        <template v-slot:option="option">
                            {{ option.title }}
                        </template>
                    </v-select>

                    <router-link
                        :to="{ name: 'AdCreate' }"
                        class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                    >
                        Создать объявление
                    </router-link>
                </div>
            </div>

            <p class="text-gray-600 mb-8">
                Весь список объявлений с пагинацией.
                <br />
                Всего {{ pagination.total }} объявлений.
            </p>

            <div class="grid grid-cols-1 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                <div
                    v-for="ad in ads"
                    :key="ad.id"
                    class="bg-white flex flex-col p-6 rounded-lg shadow-sm border border-gray-200"
                >
                    <img
                        :src="ad.main_photo"
                        alt="Photo"
                        class="w-full h-40 object-cover rounded-md mb-4"
                    />
                    <h3 class="text-lg font-medium text-gray-800">
                        {{ ad.title }}
                    </h3>
                    <p class="text-gray-600 mb-3">{{ ad.price }} ₽</p>
                    <router-link
                        :to="{ name: 'AdDetails', params: { id: ad.id } }"
                        class="mt-auto flex w-fit px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600"
                    >
                        Подробнее
                    </router-link>
                </div>
            </div>

            <!-- Пагинация -->
            <div class="flex items-center space-x-2 justify-center mt-8">
                <button
                    @click="getAds(pagination.current_page - 1)"
                    :disabled="pagination.current_page === 1"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                >
                    <
                </button>

                <button
                    v-for="page in pagination.last_page"
                    @click="getAds(page)"
                    :class="
                        page === pagination.current_page
                            ? 'bg-blue-500 text-white'
                            : 'bg-gray-200 text-gray-700'
                    "
                    class="px-4 py-2 rounded-md hover:bg-blue-600 hover:text-white"
                >
                    {{ page }}
                </button>

                <button
                    @click="getAds(pagination.current_page + 1)"
                    :disabled="pagination.current_page === pagination.last_page"
                    class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300"
                >
                    >
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from "vue";
import api from "@/api";

const ads = ref([]);
const pagination = ref({
    current_page: 1,
    last_page: 1,
    total: 0,
});
const options = [
    {
        field: "created_at",
        order: "desc",
        title: "Новые",
    },
    {
        field: "created_at",
        order: "asc",
        title: "Старые",
    },
    {
        field: "price",
        order: "desc",
        title: "Дороже",
    },
    {
        field: "price",
        order: "asc",
        title: "Дешевле",
    },
];
const selected = ref(options[0]);

function getAds(page = 1) {
    api.post("ads", {
        page: page,
        sort_field: selected.value.field,
        sort_order: selected.value.order,
    }).then((response) => {
        ads.value = response.data.data;
        pagination.value = response.data.pagination;
    });
}

watch(selected, () => {
    getAds();
});

getAds();
</script>

<style scoped></style>
