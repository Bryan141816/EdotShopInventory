export default () => ({
  itemModalOpen: false,
  itemModalTitle: 'Add Item',
  isEdit: false,
  id: null,
  itemInput: {
    name: "",
    sku: "",
    cost_price: "",
    selling_price: "",
    quantity: "",
    image: "",
    description: "",
    brand_id: "",
    category_id: ""
  },

  brands: null,
  category: null,

  async fetchBrandAndCategory() {
    try {
      const response = await fetch("/api/brand_category", {
        credentials: 'include'
      });
      if (!response.ok) {
        throw new Error(`Response status: ${response.status}`);
      }
      const result = await response.json();
      this.brands = result.brands;
      this.category = result.category;
    } catch (error) {
      console.error(error.message);
    }
  },
  openItemModal() {
    this.itemModalOpen = true;

  },

  itemModalClose() {
    this.itemModalOpen = false;
    this.isEdit = false;
    this.itemInput = {
      name: "",
      sku: "",
      cost_price: "",
      selling_price: "",
      quantity: "",
      image: "",
      description: "",
      brand_id: "",
      category_id: ""
    };
    this.id = null;
    this.itemModalTitle = 'Add Item'
  },

  handleImage(event) {
    const file = event.target.files[0];

    if (!file) return;

    this.setImage(file);
  },

  handleDrop(event) {
    const file = event.dataTransfer.files[0];

    if (!file) return;

    this.setImage(file);

    const input = document.getElementById('image-upload');

    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);

    input.files = dataTransfer.files;
  },

  setImage(file) {
    if (!file.type.startsWith('image/')) return;

    this.itemInput.image = URL.createObjectURL(file);
  },

  clearImage() {
    this.itemInput.image = "";
  },

  handleDeleteClick(event) {
    const button = event.target;
    const row = button.closest('tr');
    this.id = row.getAttribute('name');
  },
  handleEditClick(event) {
    const button = event.target;
    const row = button.closest('tr');
    this.id = row.getAttribute('name');
    this.fetchBrandAndCategory();
    this.itemInput = {
      name: row.querySelector('[data-key="name"]').getAttribute('data-value'),
      sku: row.querySelector('[data-key="sku"]').getAttribute('data-value'),
      cost_price: row.querySelector('[data-key="cost_price"]').getAttribute('data-value'),
      selling_price: row.querySelector('[data-key="selling_price"]').getAttribute('data-value'),
      quantity: row.querySelector('[data-key="quantity"]').getAttribute('data-value'),
      description: row.querySelector('[data-key="description"]').getAttribute('data-value'),
      image: row.querySelector('[data-key="image"]').getAttribute('data-value'),
    }
    this.itemModalOpen = true;
    this.isEdit = true;
    this.itemModalTitle = "Update Item";
  },

  //Brand & Category
  brandModalOpen: false,
  brandModalTitle: "Create Brand",
  brandSaving: false,
  brandError: "",
  brandInput: {
    name: "",
    description: ""
  },
  brandModalmode: "brand",

  openBrandModal() {
    this.brandModalOpen = true;
    this.brandError = "";
    this.brandInput = { name: "", description: "" };
    this.brandModalTitle = "Create Brand";
    this.$nextTick(() => document.getElementById("brand-name")?.focus());
    this.brandModalmode = "brand";
  },

  closeBrandModal() {
    this.brandModalOpen = false;
    this.brandSaving = false;
    this.brandError = "";
  },

  openCategoryModal() {
    this.brandModalOpen = true;
    this.brandError = "";
    this.brandInput = { name: "", description: "" };
    this.brandModalTitle = "Create Category";
    this.$nextTick(() => document.getElementById("brand-name")?.focus());
    this.brandModalmode = "category";
  },

  async createBrand() {
    this.brandSaving = true;
    this.brandError = "";

    try {
      const url = this.brandModalmode == "brand" ? "/api/brands" : "/api/category";
      const response = await fetch(url, {
        method: "POST",
        headers: { Accept: "application/json" },
        body: new FormData(this.$refs.brandForm),
        credentials: 'include'
      });
      const result = await response.json();

      if (!response.ok) {
        this.brandError = result.errors?.name?.[0] ?? result.message ?? `Unable to create the ${this.brandModalmode}.`;
        return;
      }
      if (this.brandModalmode == "brand") {
        this.brands = [...(this.brands ?? []), result.brand];
        this.itemInput.brand_id = result.brand.id;
      }
      else {
        this.category = [...(this.category ?? []), result.category];
        this.itemInput.category_id = result.category.id;
      }
      this.closeBrandModal();
    } catch {
      this.brandError = `Unable to create the ${this.brandModalmode}. Please try again.`;
    } finally {
      this.brandSaving = false;
    }
  },

});
