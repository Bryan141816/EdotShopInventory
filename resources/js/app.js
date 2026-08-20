import Alpine from "alpinejs";
import itemModal from "./inventory/item-modal";

Alpine.data('itemModal', itemModal);
window.Alpine = Alpine;

Alpine.start();