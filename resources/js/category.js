export default () => ({
  open: false,
  id: null,
  title: "Create Category",
  isEdit: false,
  categoryInput: {
    name: "",
    description: "",
  },
  closeModal() {
    this.open = false;
    this.categoryInputnput = {
      name: "",
      description: "",
    };
  },
  _openModal() {
    this.open = true;
  },
  openCreateModal() {
    this.title = "Create Category";
    this.isEdit = false;
    this.categoryInputnput = {
      name: "",
      description: "",
    };
    this._openModal();
  },
  handleEditClick(event) {
    const button = event.target;
    const row = button.closest("tr");
    this.id = row.getAttribute('name');
    this.categoryInput = {
      name: row.querySelector('[data-key="name"]').getAttribute('data-value'),
      description: row.querySelector('[data-key="description"]').getAttribute('data-value'),
    }
    this.title = "Update Category";
    this.isEdit = true;
    this._openModal();
  },
  handleDeleteClick(event) {
    const button = event.target;
    const row = button.closest('tr');
    this.id = row.getAttribute('name');
  }
});