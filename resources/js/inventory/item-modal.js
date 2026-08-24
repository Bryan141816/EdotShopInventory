export default () => ({
  itemModalOpen: false,
  title: 'Add Item',
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

  async openItemModal() {
    this.itemModalOpen = true;

    try {
      const response = await fetch("/api/brand_category");
      if(!response.ok){
        throw new Error(`Response status: ${response.status}`);
      }
      const result = await response.json();
      this.brands = result.brands;
      this.category = result.category;
    }catch(error){
      console.error(error.message);
    }
  },
  closeModal() {
    this.itemModalOpen = false;
    this.isEdit = false;
    this.itemInput = {
      name: "",
      sku: "",
      cost_price: "",
      selling_price: "",
      quantity: "",
      image: "",
      description: ""
    };
    this.id = null;
    this.title = 'Add Item'
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
    console.log(this)
    const button = event.target;
    const row = button.closest('tr');
    this.id = row.getAttribute('name');

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
    this.title = "Update Item";
  }
});