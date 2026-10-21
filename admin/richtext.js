/* Shared rich-text (Quill) mounting used by every admin "Description"/
   "Content" field — Products today, Blog posts too. Keeps editor behaviour
   (and fixes to it) consistent in one place instead of duplicated per page. */
function mountRichText(editorId, textareaId) {
  var ta = document.getElementById(textareaId);
  var quill = new Quill('#' + editorId, {
    theme: 'snow',
    modules: {
      toolbar: [
        [{ header: [1, 2, 3, 4, 5, false] }],
        ['bold', 'italic', 'underline'],
        [{ list: 'ordered' }, { list: 'bullet' }],
        ['link', 'image'],
        ['clean']
      ]
    }
  });
  quill.root.innerHTML = ta.value;
  ta.form.addEventListener('submit', function () {
    /* Quill leaves an empty "<p><br></p>" when nothing was typed —
       store a real empty string instead so the field counts as blank. */
    var html = quill.root.innerHTML;
    ta.value = (html === '<p><br></p>') ? '' : html;
  });
  return quill;
}
