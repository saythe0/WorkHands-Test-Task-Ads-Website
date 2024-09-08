import axios from "axios";
import { notify } from "@kyvg/vue3-notification";

const instance = axios.create({
    baseURL: "/api/",
    headers: {
        Accept: "application/json",
        "X-Requested-With": "XMLHttpRequest",
    },
});

instance.defaults.withCredentials = true;

instance.interceptors.response.use(
    function (response) {
        if (response.data.hasOwnProperty("status")) {
            if (response.data.status == "success") {
                notify({
                    title: "Успешно!",
                    text: response.data.message ?? "",
                    type: "success",
                });
            } else {
                notify({
                    title: "Ошибка",
                    text: response.data.message ?? "",
                    type: "error",
                });
            }
        } else if (response.data.hasOwnProperty("errors")) {
            Object.values(response.data.errors).forEach((arr) => {
                arr.forEach((err) => {
                    notify({
                        title: "Ошибка",
                        text: err,
                        type: "error",
                    });
                });
            });
        }
        return response;
    },
    function (error) {
        notify({
            title: "Ошибка",
            text: error.message ?? "",
            type: "error",
        });
        console.error(`API error: ${error}`);
    }
);

export default instance;
