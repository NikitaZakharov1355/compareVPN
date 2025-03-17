// add button to wisywig editor

(function () {
    tinymce.create('tinymce.plugins.custom_button_class', {
        init: function (editor, url) {
            editor.addButton('custom_button_class', {
                title: 'Insert Button Link',
                icon: 'mce-ico mce-i-link',
                onclick: function () {
                    var selectedText = editor.selection.getContent({ format: 'text' });

                    editor.windowManager.open({
                        title: 'Insert Button Link',
                        body: [
                            {
                                type: 'textbox',
                                name: 'linkUrl',
                                label: 'URL'
                            },
                            {
                                type: 'textbox',
                                name: 'linkTarget',
                                label: 'Target (_blank or _self)',
                                value: '_self'
                            }
                        ],
                        onsubmit: function (e) {
                            var linkUrl = e.data.linkUrl;
                            var linkTarget = e.data.linkTarget;

                            if (linkUrl) {
                                var linkHtml = '<a href="' + linkUrl + '" class="button" target="' + linkTarget + '">' + (selectedText || 'Button') + '</a>';
                                editor.insertContent(linkHtml);
                            }
                        }
                    });
                }
            });
        }
    });

    tinymce.PluginManager.add('custom_button_class', tinymce.plugins.custom_button_class);
})();