import 'https://cdn.ckeditor.com/ckeditor5/30.0.0/classic/ckeditor.js'
import 'https://cdn.ckeditor.com/ckeditor5/31.1.0/classic/translations/fa.js'

ClassicEditor
.create( document.querySelector('#text'), {
  language: 'fa',
} )
.then( editor => {
  editor.ui.view.editable.element.style.height = '200px';
} )
.catch( error => {
  console.error( error );
} );
