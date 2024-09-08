import AdCreate from "@/pages/AdCreate.vue";
import AdDetails from "@/pages/AdDetails.vue";
import AdList from "@/pages/AdList.vue";

const routes = [
    {
        path: "/",
        component: AdList,
        name: "AdList",
    },
    {
        path: "/details/:id",
        component: AdDetails,
        name: "AdDetails",
    },
    {
        path: "/create",
        component: AdCreate,
        name: "AdCreate",
    },
];

export default routes;
