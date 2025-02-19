document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll(".ckeditor-classic").forEach((editorElement) => {
        ClassicEditor
            .create(editorElement, {
                removePlugins: ['ImageUpload', 'MediaEmbed', 'EasyImage', 'Table', 'TableToolbar']
            })
            .then((editor) => {
                editor.ui.view.editable.element.style.height = '200px';
            })
            .catch((error) => {
                console.error(error);
            });
    });
});
