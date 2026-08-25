export default () => ({
  open: false,
  id: null,
  title: "Create Category",
  brandInput: {
    name: "",
    description: "",
  },
  closeModal() {
    this.open = false;
    this.brandInput = {
      name: "",
      description: "",
    };
  },
  openModal() {
    this.open = true;
  },

  handleDeleteClick(event) {
    const button = event.target;
    const row = button.closest('tr');
    this.id = row.getAttribute('name');
  }
});