import Alpine from "alpinejs";
import inventory from "./inventory";
import brand from "./brand"
Alpine.data('inventory', inventory);
Alpine.data('brand', brand);
window.Alpine = Alpine;

Alpine.start();