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


  /* ---------- Tables ----------
     Quill 1.x has no table support, so a table is stored as one self-contained block (a "blot")
     that holds the real <table> HTML. Click a table in the editor to edit its cells; use the
     table button in the toolbar to add one. */
  var tableRegistered = false;
  function registerTable() {
    if (tableRegistered || typeof window.Quill === 'undefined') return;
    tableRegistered = true;
    var BlockEmbed = Quill.import('blots/block/embed');
    class SbTable extends BlockEmbed {
      constructor(node) { super(node); node.setAttribute('contenteditable', 'false'); }
      static create(value) {
        var node = super.create();
        var tmp = document.createElement('div');
        tmp.innerHTML = String(value || '');
        var t = tmp.querySelector('table');
        node.innerHTML = t ? t.innerHTML : '<tbody><tr><td></td></tr></tbody>';
        node.setAttribute('contenteditable', 'false');
        return node;
      }
      static value(node) {
        var c = node.cloneNode(true);
        c.removeAttribute('contenteditable');
        return c.outerHTML;
      }
    }
    SbTable.blotName = 'sbtable';
    SbTable.tagName = 'table';
    Quill.register(SbTable, true);

    var css = document.createElement('style');
    css.textContent =
      '.ql-editor table{border-collapse:collapse;width:100%;margin:10px 0;cursor:pointer;table-layout:auto}' +
      '.ql-editor table td,.ql-editor table th{border:1px solid #bbb;padding:6px 8px;min-width:40px;text-align:left}' +
      '.ql-editor table th{background:#f1ebdd;font-weight:700}' +
      '.ql-editor table:hover{outline:2px solid #c9a961}' +
      '.ql-toolbar .ql-sbtable{width:34px!important}.ql-toolbar .ql-sbtable::before{content:"\\25A6";font-size:17px;line-height:24px}' +
      '.sbt-back{position:fixed;inset:0;background:rgba(0,0,0,.45);z-index:100000;display:flex;align-items:center;justify-content:center;padding:14px}' +
      '.sbt-box{background:#fff;color:#222;border-radius:12px;max-width:760px;width:100%;max-height:90vh;overflow:auto;padding:18px 20px;font:15px/1.4 system-ui,sans-serif;box-shadow:0 20px 60px rgba(0,0,0,.35)}' +
      '.sbt-box h3{margin:0 0 12px;font-size:1.1rem}.sbt-row{display:flex;gap:12px;flex-wrap:wrap;align-items:center;margin-bottom:10px}' +
      '.sbt-box label{display:flex;gap:6px;align-items:center}.sbt-box input[type=number]{width:70px;padding:6px;border:1px solid #ccc;border-radius:6px;font-size:16px}' +
      '.sbt-grid{overflow:auto;margin:10px 0;border:1px solid #ddd;border-radius:8px}.sbt-grid table{border-collapse:collapse;width:100%}' +
      '.sbt-grid td{padding:3px;border:1px solid #eee}.sbt-grid input{width:100%;min-width:90px;padding:7px;border:1px solid #ccc;border-radius:6px;font-size:16px;box-sizing:border-box}' +
      '.sbt-grid tr.sbt-head input{font-weight:700;background:#faf5e6}' +
      '.sbt-btn{border:1px solid #bbb;background:#f7f7f7;border-radius:8px;padding:7px 12px;font-size:14px;cursor:pointer}.sbt-btn:hover{background:#eee}' +
      '.sbt-primary{background:#0f2a24;color:#fff;border-color:#0f2a24}.sbt-primary:hover{background:#1b3c34}.sbt-danger{color:#a3261b;border-color:#e0a8a2}' +
      '.sbt-actions{display:flex;gap:8px;flex-wrap:wrap;justify-content:space-between;margin-top:12px}';
    document.head.appendChild(css);
  }

  function el(tag, props, children) {
    var n = document.createElement(tag);
    Object.keys(props || {}).forEach(function (k) { if (k === 'text') n.textContent = props[k]; else n.setAttribute(k, props[k]); });
    (children || []).forEach(function (c) { n.appendChild(c); });
    return n;
  }
  function escHtml(s) { return String(s).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;'); }

  /* Build <table> HTML from a 2-D array of strings. */
  function tableHtml(rows, header) {
    var h = '<table>';
    rows.forEach(function (r, i) {
      var tag = (header && i === 0) ? 'th' : 'td';
      if (header && i === 0) h += '<thead>';
      else if (i === (header ? 1 : 0)) h += '<tbody>';
      h += '<tr>';
      r.forEach(function (c) { h += '<' + tag + '>' + escHtml(c) + '</' + tag + '>'; });
      h += '</tr>';
      if (header && i === 0) h += '</thead>';
    });
    return h + (rows.length > (header ? 1 : 0) ? '</tbody>' : '') + '</table>';
  }
  function readTable(t) {
    var rows = [];
    t.querySelectorAll('tr').forEach(function (tr) {
      var cells = [];
      tr.querySelectorAll('th,td').forEach(function (c) { cells.push(c.textContent.replace(/ /g, ' ').trim()); });
      rows.push(cells);
    });
    return { rows: rows, header: !!t.querySelector('th') };
  }

  /* The cell editor: a grid of inputs with add / remove row and column. */
  function openTableEditor(opts) {
    var data = opts.rows.length ? opts.rows.map(function (r) { return r.slice(); }) : [['', ''], ['', '']];
    var header = !!opts.header;
    var back = el('div', { 'class': 'sbt-back' });
    var box = el('div', { 'class': 'sbt-box', role: 'dialog', 'aria-label': 'Edit table' });
    var gridWrap = el('div', { 'class': 'sbt-grid' });
    var headChk = el('input', { type: 'checkbox' });
    headChk.checked = header;
    headChk.addEventListener('change', function () { sync(); header = headChk.checked; paint(); });

    function sync() {
      gridWrap.querySelectorAll('tr').forEach(function (tr, r) {
        tr.querySelectorAll('input').forEach(function (inp, c) { if (data[r]) data[r][c] = inp.value; });
      });
    }
    function paint() {
      gridWrap.innerHTML = '';
      var t = el('table');
      data.forEach(function (row, r) {
        var tr = el('tr', header && r === 0 ? { 'class': 'sbt-head' } : {});
        row.forEach(function (val, c) {
          var inp = el('input', { type: 'text', 'aria-label': 'Row ' + (r + 1) + ', column ' + (c + 1) });
          inp.value = val;
          tr.appendChild(el('td', {}, [inp]));
        });
        t.appendChild(tr);
      });
      gridWrap.appendChild(t);
    }
    function mod(fn) { return function () { sync(); fn(); paint(); }; }
    function cols() { return data[0].length; }

    var tools = el('div', { 'class': 'sbt-row' }, [
      el('button', { type: 'button', 'class': 'sbt-btn', text: '+ Row' }),
      el('button', { type: 'button', 'class': 'sbt-btn', text: '− Row' }),
      el('button', { type: 'button', 'class': 'sbt-btn', text: '+ Column' }),
      el('button', { type: 'button', 'class': 'sbt-btn', text: '− Column' }),
      el('label', {}, [headChk, el('span', { text: 'First row is a heading' })])
    ]);
    var b = tools.querySelectorAll('button');
    b[0].addEventListener('click', mod(function () { var n = []; for (var i = 0; i < cols(); i++) n.push(''); data.push(n); }));
    b[1].addEventListener('click', mod(function () { if (data.length > 1) data.pop(); }));
    b[2].addEventListener('click', mod(function () { data.forEach(function (r) { r.push(''); }); }));
    b[3].addEventListener('click', mod(function () { if (cols() > 1) data.forEach(function (r) { r.pop(); }); }));

    var cancel = el('button', { type: 'button', 'class': 'sbt-btn', text: 'Cancel' });
    var save = el('button', { type: 'button', 'class': 'sbt-btn sbt-primary', text: 'Save table' });
    var left = el('div', { 'class': 'sbt-row', style: 'margin:0' }, [save, cancel]);
    var actions = el('div', { 'class': 'sbt-actions' }, [left]);
    if (opts.onDelete) {
      var del = el('button', { type: 'button', 'class': 'sbt-btn sbt-danger', text: 'Delete table' });
      del.addEventListener('click', function () { close(); opts.onDelete(); });
      actions.appendChild(del);
    }
    function close() { if (back.parentNode) back.parentNode.removeChild(back); document.removeEventListener('keydown', onKey); }
    function onKey(e) { if (e.key === 'Escape') close(); }
    cancel.addEventListener('click', close);
    save.addEventListener('click', function () { sync(); close(); opts.onSave(data, header); });
    back.addEventListener('mousedown', function (e) { if (e.target === back) close(); });
    document.addEventListener('keydown', onKey);

    box.appendChild(el('h3', { text: opts.title || 'Edit table' }));
    box.appendChild(tools); box.appendChild(gridWrap); box.appendChild(actions);
    back.appendChild(box);
    document.body.appendChild(back);
    paint();
    var first = gridWrap.querySelector('input');
    if (first) first.focus();
  }

  /* Ask for a size, then drop a table in at the cursor and open it for filling. */
  function insertTable(quill) {
    var range = quill.getSelection(true);
    var back = el('div', { 'class': 'sbt-back' });
    var box = el('div', { 'class': 'sbt-box', style: 'max-width:380px' });
    var rIn = el('input', { type: 'number', min: '1', max: '30', value: '3' });
    var cIn = el('input', { type: 'number', min: '1', max: '10', value: '2' });
    var hIn = el('input', { type: 'checkbox' }); hIn.checked = true;
    var ok = el('button', { type: 'button', 'class': 'sbt-btn sbt-primary', text: 'Create table' });
    var no = el('button', { type: 'button', 'class': 'sbt-btn', text: 'Cancel' });
    box.appendChild(el('h3', { text: 'Insert a table' }));
    box.appendChild(el('div', { 'class': 'sbt-row' }, [el('label', {}, [el('span', { text: 'Rows' }), rIn]), el('label', {}, [el('span', { text: 'Columns' }), cIn])]));
    box.appendChild(el('div', { 'class': 'sbt-row' }, [el('label', {}, [hIn, el('span', { text: 'First row is a heading' })])]));
    box.appendChild(el('div', { 'class': 'sbt-actions', style: 'justify-content:flex-start' }, [ok, no]));
    back.appendChild(box); document.body.appendChild(back);
    rIn.focus();
    function close() { if (back.parentNode) back.parentNode.removeChild(back); }
    no.addEventListener('click', close);
    back.addEventListener('mousedown', function (e) { if (e.target === back) close(); });
    ok.addEventListener('click', function () {
      var r = Math.max(1, Math.min(30, parseInt(rIn.value, 10) || 3));
      var c = Math.max(1, Math.min(10, parseInt(cIn.value, 10) || 2));
      var rows = [];
      for (var i = 0; i < r; i++) { var row = []; for (var j = 0; j < c; j++) row.push(''); rows.push(row); }
      close();
      var idx = range ? range.index : quill.getLength();
      var before = Array.prototype.slice.call(quill.root.querySelectorAll('table'));
      quill.insertEmbed(idx, 'sbtable', tableHtml(rows, hIn.checked), 'user');
      var fresh = Array.prototype.slice.call(quill.root.querySelectorAll('table')).filter(function (t) { return before.indexOf(t) === -1; })[0];
      if (fresh) editExisting(quill, fresh);
    });
  }

  function editExisting(quill, tableNode) {
    var info = readTable(tableNode);
    openTableEditor({
      title: 'Edit table',
      rows: info.rows, header: info.header,
      onSave: function (rows, header) {
        var tmp = document.createElement('div');
        tmp.innerHTML = tableHtml(rows, header);
        tableNode.innerHTML = tmp.querySelector('table').innerHTML;
        quill.update('user');
        quill.root.dispatchEvent(new Event('input', { bubbles: true }));
      },
      onDelete: function () {
        var blot = Quill.find(tableNode);
        if (blot) blot.remove();
        quill.update('user');
      }
    });
  }

  window.mountRichText = function (editorId, textareaId, options) {
    options = options || {};
    var ta = document.getElementById(textareaId);
    if (!ta) return null;
    if (typeof window.Quill === 'undefined') {
      fallbackToTextarea(editorId, ta);
      return null;
    }

    registerTable();
    var toolbar = [
      [{ header: [1, 2, 3, 4, 5, false] }],
      ['bold', 'italic', 'underline'],
      [{ list: 'ordered' }, { list: 'bullet' }],
      options.images === false ? ['link'] : ['link', 'image'],
      ['sbtable'],
      ['clean']
    ];

    var quill = new Quill('#' + editorId, {
      theme: 'snow',
      modules: {
        toolbar: {
          container: toolbar,
          handlers: {
            sbtable: function () { insertTable(quill); },
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
    quill.root.addEventListener('click', function (e) {
      var t = e.target.closest && e.target.closest('table');
      if (t && quill.root.contains(t)) { e.preventDefault(); editExisting(quill, t); }
    });
    /* Quill leaves an empty "<p><br></p>" when nothing was typed —
       store a real empty string instead so the field counts as blank. */
    function sync() {
      var html = quill.root.innerHTML;
      html = html.replace(/ contenteditable="false"/g, '');
      ta.value = (html === '<p><br></p>') ? '' : html;
    }
    ta.form.addEventListener('submit', sync);
    quill.on('text-change', sync);
    return quill;
  };
})();
