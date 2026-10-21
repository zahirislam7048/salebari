/* Shared rich-text (Quill) mounting used by every "Description"/"Content"/"About"
   field — Products, Blog, Brands, Malls, and the seller account forms. Keeps editor
   behaviour (and fixes to it) consistent in one place.

   mountRichText(editorId, textareaId, options)
     options.images  true (default): the image button uploads the photo to the server
                     and inserts its address — a phone photo is never embedded as a huge
                     base64 blob. false: no image button (seller forms).

   If the editor library can't load (blocked CDN, no connection), the plain textarea is
   shown instead so nothing is lost and the form can still be saved. */
(function () {
  var SCRIPT_SRC = (document.currentScript && document.currentScript.src) || '';
  var UPLOAD_URL = SCRIPT_SRC.replace(/richtext\.js.*$/, 'editor_upload.php');

  function fallbackToTextarea(editorId, ta) {
    var box = document.getElementById(editorId);
    if (box) box.style.display = 'none';
    ta.hidden = false;
    ta.removeAttribute('hidden');
    ta.rows = 10;
    ta.style.cssText = 'display:block;width:100%;min-height:200px;padding:10px;border:1px solid #ccc;border-radius:8px;font:inherit;font-size:16px;';
    var note = document.createElement('p');
    note.style.cssText = 'margin:6px 0;font-size:0.85rem;color:#8a1f17;';
    note.textContent = 'The visual editor could not load (check your internet connection). You can still type here; use <h2>, <p>, <strong>, <ul><li> tags for formatting.';
    ta.parentNode.insertBefore(note, ta);
  }

  window.mountRichText = function (editorId, textareaId, options) {
    options = options || {};
    var ta = document.getElementById(textareaId);
    if (!ta) return null;
    if (typeof window.Quill === 'undefined') {
      fallbackToTextarea(editorId, ta);
      return null;
    }

    var toolbar = [
      [{ header: [1, 2, 3, 4, 5, false] }],
      ['bold', 'italic', 'underline'],
      [{ list: 'ordered' }, { list: 'bullet' }],
      options.images === false ? ['link'] : ['link', 'image'],
      ['clean']
    ];

    var quill = new Quill('#' + editorId, {
      theme: 'snow',
      modules: {
        toolbar: {
          container: toolbar,
          handlers: {
            image: function () {
              var input = document.createElement('input');
              input.type = 'file';
              input.accept = 'image/*';
              input.onchange = function () {
                var file = input.files && input.files[0];
                if (!file) return;
                var tokenEl = ta.form && ta.form.querySelector('input[name="_token"]');
                var fd = new FormData();
                fd.append('image', file);
                fd.append('_token', tokenEl ? tokenEl.value : '');
                fetch(UPLOAD_URL, { method: 'POST', body: fd, credentials: 'same-origin' })
                  .then(function (r) { return r.json().catch(function () { return { error: 'Upload failed.' }; }); })
                  .then(function (j) {
                    if (!j.url) { alert(j.error || 'Upload failed.'); return; }
                    var range = quill.getSelection(true);
                    quill.insertEmbed(range.index, 'image', j.url, 'user');
                    quill.setSelection(range.index + 1, 0);
                  })
                  .catch(function () { alert('Upload failed. Please try a smaller image.'); });
              };
              input.click();
            }
          }
        }
      }
    });

    quill.root.innerHTML = ta.value;
    /* Quill leaves an empty "<p><br></p>" when nothing was typed —
       store a real empty string instead so the field counts as blank. */
    function sync() {
      var html = quill.root.innerHTML;
      ta.value = (html === '<p><br></p>') ? '' : html;
    }
    ta.form.addEventListener('submit', sync);
    quill.on('text-change', sync);
    return quill;
  };
})();
