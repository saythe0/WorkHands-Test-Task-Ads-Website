<template>
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Создать объявление
                </h2>
                <router-link
                    :to="{ name: 'AdList' }"
                    class="px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                >
                    Список объявлений
                </router-link>
            </div>

            <p class="text-gray-600 mb-8">Описание для создание объявления</p>

            <div
                class="bg-white p-8 rounded-lg shadow-sm border border-gray-200"
            >
                <div class="mb-8">
                    <label class="block text-lg font-medium text-gray-700 mb-2">
                        Название
                    </label>
                    <input
                        type="text"
                        maxlength="200"
                        v-model="form.title"
                        class="block w-full border-gray-700 rounded-md shadow-lg px-4 py-3 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        required
                    />
                </div>

                <div class="mb-8">
                    <label class="block text-lg font-medium text-gray-700 mb-2">
                        Описание
                    </label>
                    <textarea
                        v-model="form.description"
                        rows="4"
                        maxlength="1000"
                        class="block w-full border-gray-700 rounded-md shadow-lg px-4 py-3 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        required
                    ></textarea>
                </div>

                <div class="mb-8">
                    <label class="block text-lg font-medium text-gray-700 mb-2">
                        Цена
                    </label>
                    <input
                        type="number"
                        v-model="form.price"
                        min="0"
                        class="block w-full border-gray-700 rounded-md shadow-lg px-4 py-3 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                        required
                    />
                </div>

                <div class="mb-8">
                    <label class="block text-lg font-medium text-gray-700 mb-2">
                        Картинки (URL)
                    </label>
                    <input
                        type="text"
                        v-model="form.photo_links[0]"
                        placeholder="Введите URL картинки"
                        class="block w-full border-gray-700 rounded-md shadow-lg px-4 py-3 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    />
                    <input
                        v-if="form.photo_links[0]"
                        type="text"
                        v-model="form.photo_links[1]"
                        placeholder="Введите URL второй картинки"
                        class="mt-4 block w-full border-gray-700 rounded-md shadow-lg px-4 py-3 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    />
                    <input
                        v-if="form.photo_links[1]"
                        type="text"
                        v-model="form.photo_links[2]"
                        placeholder="Введите URL третьей картинки"
                        class="mt-4 block w-full border-gray-700 rounded-md shadow-lg px-4 py-3 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"
                    />
                </div>

                <button
                    @click="create"
                    class="w-full px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600"
                >
                    Создать
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import api from "@/api";

const form = ref({
    title: "",
    description: "",
    price: "",
    photo_links: [],
});

function create() {
    api.post("ads/create", {
        title: form.value.title,
        description: form.value.description,
        price: form.value.price,
        photo_links: form.value.photo_links,
    }).then((response) => {
        console.log(response.data);
    });
}
</script>

<style scoped></style>
