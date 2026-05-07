/**
 * UMeditor 分页按钮注册（v1.6.0+）
 *
 * 在编辑器内插入 <hr class="ui_editor_pagebreak"/>，
 * 前端 cms_content_data_model::format_content() 会按此切分内容为多页。
 *
 * Author: 极速CMS <https://www.jisucms.com>
 */
(function () {
    if (typeof UM === 'undefined' || typeof UM.registerUI !== 'function') {
        return;
    }

    // 注入按钮样式（UMeditor 默认皮肤无 pagebreak 图标，这里用文字代替）
    if (!document.getElementById('jisucms-pagebreak-style')) {
        var style = document.createElement('style');
        style.id = 'jisucms-pagebreak-style';
        style.type = 'text/css';
        style.appendChild(document.createTextNode(
            '.edui-default .edui-toolbar .edui-btn-pagebreak .edui-icon{background:none;position:relative;}' +
            '.edui-default .edui-toolbar .edui-btn-pagebreak .edui-icon:after{' +
                'content:"\u5206\u9875";position:absolute;left:0;right:0;top:0;bottom:0;' +
                'text-align:center;line-height:22px;font-size:12px;font-weight:bold;color:#333;' +
            '}'
        ));
        document.head.appendChild(style);
    }

    UM.registerUI('pagebreak', function (name) {
        var me = this;
        var $btn = $.eduibutton({
            icon: name,
            title: (me.getLang && me.getLang(name)) || '\u5206\u9875',
            theme: me.getOpt('theme'),
            click: function () {
                me.focus();
                me.execCommand('insertHtml', '<hr class="ui_editor_pagebreak"/>');
            }
        });
        return $btn;
    });
})();
