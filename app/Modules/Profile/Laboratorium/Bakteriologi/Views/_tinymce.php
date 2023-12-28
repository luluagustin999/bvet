tinymce.init({
selector: 'textarea#content',
height: 300,
language: '<?= $locale ?>',
<?php if ($locale != 'en') : ?>
  language_url: '<?= asset("admin/js/tinymce6-" . $locale . ".js", "js") ?>',
<?php endif; ?>
menubar: false,
entity_encoding : 'raw',
plugins: [
'advlist', 'anchor', 'autolink', 'codesample', 'fullscreen', 'help',
'image', 'lists', 'link', 'media', 'preview',
'searchreplace', 'table', 'template', 'visualblocks', 'wordcount'
],
setup: function (editor) {
editor.on('blur', function () {
htmx.ajax('POST', '<?= site_url($url) ?>', { target: '#content_error' });
});
},
statusbar: false,
toolbar: 'insertfile a11ycheck undo redo | bold italic | forecolor backcolor | template codesample | alignleft aligncenter alignright alignjustify | bullist numlist | link image',
});

// on htmx submit, trigger tinymce save = transfer text from editor to textarea
document.body.addEventListener('htmx:configRequest', (event) => {

tinyMCE.triggerSave();

let richContent = document.querySelector('#content');
event.detail.parameters['content'] = richContent.value;
});
