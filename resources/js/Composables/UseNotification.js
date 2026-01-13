import { ref } from "vue";

const notifications = ref([]);
var id = ref(0);

export function UseNotification() {
    const addNotify = (
        message,
        type = "success",
        reload = false,
        duration = 5000
    ) => {
        id.value++;
        notifications.value.push({
            id: id.value,
            message,
            type,
            duration,
            reload,
        });
    };

    const removeNotify = (id) => {
        notifications.value = notifications.value.filter((n) => n.id !== id);
    };

    return { notifications, id, addNotify, removeNotify };
}
