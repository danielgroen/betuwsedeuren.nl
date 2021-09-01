// JavaScript Document

function getBaseURL () {
   return location.protocol + '//' + location.hostname + 
      (location.port && ':' + location.port) + '/';
}

(function() {
    tinymce.create('tinymce.plugins.vecb_button1', {
        init : function(ed, url) {
            ed.addButton('vecb_button1', {
                title : 'Nieuwe kolom',image : url+'/icons/intro_header.png',onclick : function() {
                     ed.selection.setContent('<div class="col-md-6">' + ed.selection.getContent() + '</div>');
                }
            });
        },
        createControl : function(n, cm) {
            return null;
        },
    });
    tinymce.PluginManager.add('vecb_button1', tinymce.plugins.vecb_button1);
})();