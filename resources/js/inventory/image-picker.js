document.addEventListener('DOMContentLoaded', function () {
  const input = document.getElementById('image-upload');
  const dropzone = document.getElementById('image-dropzone');
  const placeholder = document.getElementById('image-placeholder');
  const preview = document.getElementById('image-preview');
  const deleteButton = document.getElementById('image-delete');

  const MAX_FILE_SIZE = 2 * 1024 * 1024; // 2 MB

  function validateImage(file) {
    if (!file) {
      return false;
    }

    if (!file.type.startsWith('image/')) {
      alert('Please select a valid image file.');
      return false;
    }

    if (file.size > MAX_FILE_SIZE) {
      alert('Image must be 2 MB or smaller.');
      return false;
    }

    return true;
  }

  function showImage(file) {
    if (!validateImage(file)) {
      clearImage();
      return;
    }

    const imageUrl = URL.createObjectURL(file);

    preview.src = imageUrl;
    preview.classList.remove('hidden');
    placeholder.classList.add('hidden');

    deleteButton.classList.remove('hidden');
    deleteButton.classList.add('flex');
    document.getElementById('remove-image').value = '0';
  }

  function clearImage() {
    input.value = '';

    preview.src = '';
    preview.classList.add('hidden');

    placeholder.classList.remove('hidden');

    deleteButton.classList.add('hidden');
    deleteButton.classList.remove('flex');
    document.getElementById('remove-image').value = '1';
  }

  input.addEventListener('change', function () {
    const file = this.files[0];

    if (!validateImage(file)) {
      clearImage();
      return;
    }

    showImage(file);
  });

  dropzone.addEventListener('dragover', function (event) {
    event.preventDefault();
    dropzone.classList.add('bg-gray-200');
  });

  dropzone.addEventListener('dragleave', function () {
    dropzone.classList.remove('bg-gray-200');
  });

  dropzone.addEventListener('drop', function (event) {
    event.preventDefault();
    dropzone.classList.remove('bg-gray-200');

    const file = event.dataTransfer.files[0];

    if (!validateImage(file)) {
      clearImage();
      return;
    }

    const dataTransfer = new DataTransfer();
    dataTransfer.items.add(file);
    input.files = dataTransfer.files;

    showImage(file);
  });

  deleteButton.addEventListener('click', function () {
    clearImage();
  });
});