export default () => ({
  open: false,
  id: null,
  title: "Create Brand",
  isEdit: false,
  brandInput: {
    name: "",
    description: "",
  },
  closeModal() {
    this.open = false;

  },
  _openModal() {
    this.open = true;
  },

  openCreateModal() {
    this.title = "Create Brand";
    this.isEdit = false;
    this.brandInput = {
      name: "",
      description: "",
    };
    this._openModal();
  },
  handleEditClick(event) {
    const button = event.target;
    const row = button.closest("tr");
    this.id = row.getAttribute('name');
    this.brandInput = {
      name: row.querySelector('[data-key="name"]').getAttribute('data-value'),
      description: row.querySelector('[data-key="description"]').getAttribute('data-value'),
    }
    this.title = "Update Brand";
    this.isEdit = true;
    this._openModal();
  },

  handleDeleteClick(event) {
    const button = event.target;
    const row = button.closest('tr');
    this.id = row.getAttribute('name');
  }
});