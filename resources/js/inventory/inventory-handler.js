function clearForm() {
  document.getElementById('image-upload').value = '';
  document.getElementById('image-preview').src = '';
  document.getElementById('image-preview').classList.add('hidden');
  document.getElementById('image-placeholder').classList.remove('hidden');
  document.getElementById('image-delete').classList.add('hidden');
  document.getElementById('name').value = '';
  document.getElementById('sku').value = '';
  document.getElementById('cost_price').value = '';
  document.getElementById('selling_price').value = '';
  document.getElementById('quantity').value = '';
  document.getElementById('description').value = '';
}
document.addEventListener('DOMContentLoaded', function () {

  async function handleDeleteRow(itemId, row) {
    const response = await fetch(`/inventory/${itemId}`, {
      method: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': document
          .querySelector('meta[name="csrf-token"]')
          .getAttribute('content'),

        'Accept': 'application/json',
      },
    });

    if (response.ok) {
      row.remove();
      console.log('Item deleted');
    } else {
      console.error('Failed to delete item');
    }
  }
  const deleteButtons = document.querySelectorAll('.delete-button');
  deleteButtons.forEach(button => {
    button.addEventListener('click', function () {
      const row = this.closest('tr');
      const itemId = row.getAttribute('name');
      handleDeleteRow(itemId, row);
    });
  });
  
  const updateButtons = document.querySelectorAll('.update-button');
  updateButtons.forEach(button => {
    button.addEventListener('click', function () {
      console.log('Update button clicked');
      const row = this.closest('tr');
      const itemId = row.getAttribute('name');
      const itemData = {
        name: row.querySelector('[data-key="name"]').getAttribute('data-value'),
        sku: row.querySelector('[data-key="sku"]').getAttribute('data-value'),
        cost_price: row.querySelector('[data-key="cost_price"]').getAttribute('data-value'),
        selling_price: row.querySelector('[data-key="selling_price"]').getAttribute('data-value'),
        quantity: row.querySelector('[data-key="quantity"]').getAttribute('data-value'),
        description: row.querySelector('[data-key="description"]').getAttribute('data-value'),
        image: row.querySelector('[data-key="image"]').getAttribute('data-value'),
      };

      document.getElementById('name').value = itemData.name;
      document.getElementById('sku').value = itemData.sku;
      document.getElementById('cost_price').value = itemData.cost_price;
      document.getElementById('selling_price').value = itemData.selling_price;
      document.getElementById('quantity').value = itemData.quantity;
      document.getElementById('description').value = itemData.description;
      if (itemData.image) {
        document.getElementById('image-preview').src = itemData.image;
        document.getElementById('image-preview').classList.remove('hidden');
        document.getElementById('image-placeholder').classList.add('hidden');
        document.getElementById('image-delete').classList.remove('hidden');
      } else {
        document.getElementById('image-preview').src = '';
        document.getElementById('image-preview').classList.add('hidden');
        document.getElementById('image-placeholder').classList.remove('hidden');
        document.getElementById('image-delete').classList.add('hidden');
      }

      const form = document.getElementById('item-form');
      updateModalTitle('add-item-modal', 'Update Item');
      form.action = `/inventory/${itemId}/edit`;
      document.getElementById('submit-button').textContent = 'Update Item';
      openModal('add-item-modal');
    });
  });

  const params = new URLSearchParams(window.location.search);
  const search = params.get('search');

  if (search) {
    document.getElementById('search-input').value = search;
  }
});