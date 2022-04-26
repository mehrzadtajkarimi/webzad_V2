CKEDITOR.replace('textarea', {
	extraPlugins: 'filebrowser',
	height: 300,
	filebrowserUploadUrl: "/upload.php",
	filebrowserUploadMethod: "form"
});