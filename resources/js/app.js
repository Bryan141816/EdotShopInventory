import Alpine from "alpinejs";
import inventory from "./inventory";
import brand from "./brand"
import category from "./category";

Alpine.data('inventory', inventory);
Alpine.data('brand', brand);
Alpine.data('category', category);

window.Alpine = Alpine;

Alpine.start();