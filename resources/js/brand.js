export default () => ({

  id: null,

  handleDeleteClick(event){
    const button = event.target;
    const row = button.closest('tr');
    this.id = row.getAttribute('name');
  }
});