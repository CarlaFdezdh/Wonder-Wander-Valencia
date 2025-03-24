// Obtener elementos del DOM
const imageUpload = document.getElementById('imageUpload'); // Input de archivo
const imagePreview = document.getElementById('imagePreview'); // Imagen de vista previa

// Evento para detectar cuando se selecciona una imagen
imageUpload.addEventListener('change', function(event) {
    const file = event.target.files[0]; // Obtener el primer archivo seleccionado

    // Verificar si hay un archivo y si es una imagen
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader(); // Crear un lector de archivos

        // Cuando se cargue la imagen
        reader.onload = function(e) {
            // Establecer la fuente de la imagen en la URL cargada
            imagePreview.src = e.target.result;
            imagePreview.style.maxWidth = '300px'; // Asegurar que la imagen no sea demasiado grande
            imagePreview.style.maxHeight = '300px';
        };

        // Leer el archivo como una URL de datos
        reader.readAsDataURL(file);
    } else {
        // Si no es una imagen, mantener la imagen predeterminada
        imagePreview.src = 'media/imgs/mountains-mountain-svgrepo-com.svg';
    }
});