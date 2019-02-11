(function e(t,n,r){function s(o,u){if(!n[o]){if(!t[o]){var a=typeof require=="function"&&require;if(!u&&a)return a(o,!0);if(i)return i(o,!0);var f=new Error("Cannot find module '"+o+"'");throw f.code="MODULE_NOT_FOUND",f}var l=n[o]={exports:{}};t[o][0].call(l.exports,function(e){var n=t[o][1][e];return s(n?n:e)},l,l.exports,e,t,n,r)}return n[o].exports}var i=typeof require=="function"&&require;for(var o=0;o<r.length;o++)s(r[o]);return s})({1:[function(require,module,exports){
'use strict'

var searchSelectedElement = require ('../tools/search-selected-element');

module.exports = function() {
  if (typeof uploadcare == 'undefined') {
    return; // not loaded yet
  }
  var editor = CKEDITOR.currentInstance;
  
  var config = editor.config.uploadcare || {};
  
  // Apply default properties.
  if ( ! ('crop' in config)) {
    config.crop = '';
  }

  uploadcare.plugin(function(uc) {
    var settings, element, file;

    if (element = searchSelectedElement(editor, 'img')) {
      file = element.getAttribute('src');
    } else if (element = searchSelectedElement(editor, 'a')) {
      file = element.getAttribute('href');
    }

    if (file && uc.utils.splitCdnUrl(file)) {
      settings = uc.settings.build(
        uc.jQuery.extend({}, config, {multiple: false})
      );
      file = uploadcare.fileFrom('uploaded', file, settings);
    } else {
      settings = uc.settings.build(config)
      file = null;
    }

    var dialog = uploadcare.openDialog(file, settings).done(function(selected) {
      var files = settings.multiple ? selected.files() : [selected];
      uc.jQuery.when.apply(null, files).done(function() {
        uc.jQuery.each(arguments, function() {
          var imageUrl = this.cdnUrl;
          if (this.isImage && ! this.cdnUrlModifiers) {
            imageUrl += '-/preview/';
          }
          if (element) {
            var widget;
            if (editor.widgets && (widget = editor.widgets.selected[0])
                && widget.element === element
            ) {
              widget.setData('src', imageUrl).setData('height', null)
            } else if (element.getName() == 'img') {
              element.data('cke-saved-src', '');
              element.setAttribute('src', imageUrl);
              element.removeAttribute('width');
              element.removeAttribute('height');
            } else {
              element.data('cke-saved-href', '');
              element.setAttribute('href', this.cdnUrl);
            }
          } else {
            if (this.isImage) {
              editor.insertHtml('<img src="' + imageUrl + '" alt=""/><br>', 'unfiltered_html');
            } else {
              editor.insertHtml('<a href="' + this.cdnUrl + '">' + this.name + '</a> ', 'unfiltered_html');
            }
          }
        });
      });
    });
  });
}
},{"../tools/search-selected-element":8}],2:[function(require,module,exports){
'use scrict'

module.exports = function() {
  this.editor = null;
  this.targetImg = null;
}
},{}],3:[function(require,module,exports){
// Uploadcare CKeditor plugin
// Version: 2.1.1
'use strict';

var findOne = require('./tools/find-one');

CKEDITOR.plugins.add('uploadcare', {
  hidpi: true,
  icons: 'uploadcare',
  init : function(editor) {
    var targetImg = null;
    var getBody = require('./tools/get-body');
    
    CKEDITOR.addCss(require('./styles/resize'));
    var config = editor.config.uploadcare || {};

    // Check if Uploadcare is already loaded and load it if not.
    if (typeof uploadcare === 'undefined') {
        var version = config.widgetVersion || '2.4.0';
        var widget_url = 'https://ucarecdn.com/widget/' + version +
                 '/uploadcare/uploadcare.full.min.js'
        CKEDITOR.scriptLoader.load(widget_url);
    }

    editor.addCommand('showUploadcareDialog', {
      allowedContent: 'img[!src,alt]{width,height};a[!href]',
      requiredContent: 'img[src];a[href]',
      exec : require('./commands/show-uploadcare-dialog')
    });

    editor.ui.addButton && editor.ui.addButton('Uploadcare', {
      label : 'Uploadcare',
      toolbar : 'insert',
      command : 'showUploadcareDialog'
    });
    
    editor.on('contentDom', function() {
      
      var editable = editor.editable();
      var tools = null;
      var isResizing = false;
      var resizeImg = null;
      var resizeElements = null;
      var resizerSize = 12;
      
      var clearToolbar = require('./tools/clear-toolbar');
      
      editable.attachListener( editable.isInline() ? editable : editor.document, 'mousemove', function( evt ) {
        evt = evt.data;
        var target = evt.getTarget();
        var src = target.$.getAttribute('src');
         
        function onMouseOut(evt) {
          var target = evt.data.getTarget();
          var rect = target.$.getBoundingClientRect();
          
          if((evt.data.$.clientX < rect.left || evt.data.$.clientX > rect.right) || 
          (evt.data.$.clientY < rect.top || evt.data.$.clientY > rect.bottom)) {
            tools.hide();  
          }
        }
        
        if(target.is('img') && (src.indexOf('www.ucarecdn.com') > -1) && !isResizing) {
          var body = getBody();
          if(!body) {
            return;
          }
          targetImg = target;
          if(!tools) {
            tools = body.findOne ? body.findOne('div.tools-container') : findOne.bind(body)('div.tools-container');
            if(!tools) {
              tools = CKEDITOR.dom.element.createFromHtml('<div class="tools-container"><button class="button resize icon icon-resize"></button><button class="button dialog icon icon-crop"></button></div>');
            }
            tools.setStyle('zindex', '100');
            body.append(tools); 
            tools.on('mouseout', onMouseOut);
            
            tools.removeAllListeners();
            var resizeBtn = tools.findOne ? tools.findOne('button.resize') : findOne.bind(tools)('button.resize');
            
            resizeBtn.on('click', onResizeAction);
            
            var dialogBtn = tools.findOne ? tools.findOne('button.dialog') : findOne.bind(tools)('button.dialog');
            dialogBtn.on('click', function(){
              editor.getSelection().selectElement( targetImg );
              editor.execCommand('showUploadcareDialog');
            });
            
            target.removeAllListeners();
            target.on('mouseout', onMouseOut);          
            
          }
          else {
            tools.show();
          }
          
          var rect = getPosition(target);
          tools.setStyle('top', rect.top + 'px');
          tools.setStyle('left', rect.left + 'px');
          
          
        } else if (tools && target.$ !== tools.$ && !isResizing) {
          if(target.getParent() && !target.getParent().hasClass('tools-container')) {
            tools.hide();
          }
        }
        
        if(isResizing) {
          var nativeEvt = evt.$;

          var moveDiffX = nativeEvt.screenX - resizeElements.startX;
          var moveDiffY = resizeElements.startY - nativeEvt.screenY;
          var moveRatio = Math.abs(moveDiffX / moveDiffY);
          
          if ( moveDiffX <= 0 ) {
						if ( moveDiffY <= 0 ) {
							adjustToX(moveDiffX);
            } else {
							if ( moveRatio >= resizeElements.ratio ) {
								adjustToX(moveDiffX);
              } else {
								adjustToY(moveDiffY); 
              }
						}
					} else {
						if ( moveDiffY <= 0 ) {
							if ( moveRatio >= resizeElements.ratio ) {
								adjustToY(moveDiffY);
              } else {
								adjustToX(moveDiffX);
              }
						} else {
							adjustToY(moveDiffY);
						}
					}
            if(resizeElements.newWidth >= 15 && resizeElements.newHeight >= 15) {
              resizeImg.setAttributes( {width: resizeElements.newWidth, height: resizeElements.newHeight} );
              resizeElements.resizeBorder.setStyle('width', resizeElements.newWidth + 'px');
              resizeElements.resizeBorder.setStyle('height', resizeElements.newHeight + 'px');
              
              resizeElements.bottomRightResizer.setStyle('left', resizeElements.imgRect.left + resizeElements.newWidth - resizerSize/2 + 'px');
              resizeElements.bottomRightResizer.setStyle('top', resizeElements.imgRect.top + resizeElements.newHeight - resizerSize/2 + 'px');
            }
					}
      });
      
      editor.on('dragstart', function(evt) {
        clearToolbar();
      });

      function onResizeAction(raEvt) {
        clearToolbar();
        var img = targetImg;
        var rect = getPosition(img);
        var selection = editor.getSelection();
        if(selection.fake) {
          selection.fake(img);
        }
        
        var body = getBody();
        if(!body) {
          return;
        }
        var screenOverlay = CKEDITOR.dom.element.createFromHtml('<div class="screen-overlay"><div>');
        var resizeBorder = CKEDITOR.dom.element.createFromHtml('<div class="resize-border"><div>');
        screenOverlay.append(resizeBorder);
        body.append(screenOverlay);
        
        var bodyRect = getPosition(editable.getDocument().getDocumentElement());
        
        screenOverlay.setStyle('width', bodyRect.width + 'px');
        screenOverlay.setStyle('height', bodyRect.height + 'px');
        
        resizeBorder.setStyle('top', rect.top + 'px');
        resizeBorder.setStyle('left', rect.left + 'px');
        resizeBorder.setStyle('width', rect.width + 'px');
        resizeBorder.setStyle('height', rect.height + 'px');
        
        resizeElements = {
          resizeBorder: resizeBorder,
          imgRect: rect,
          newWidth: rect.width,
          newHeight: rect.height
        }
        
        createResizers(rect, screenOverlay);
        resizeImg = img;
        
        screenOverlay.on('click', function(){
          editor.resetUndo();
          if(isResizing) {
            isResizing = false;
            updateImgSrc();
            return;
          }
          
          screenOverlay.remove();
          resizeImg = null;
          resizeElements = null;
        });
        
        resizeBorder.on('click', function(clickEvt) {
          clickEvt.data.$.stopPropagation();
          clickEvt.data.$.preventDefault();
        });
        
        resizeElements.bottomRightResizer.on('mousedown', function(mdEvt) {
          
          mdEvt.data.$.stopPropagation();
          mdEvt.data.$.preventDefault();
          isResizing = true;
          resizeElements.startX = mdEvt.data.$.screenX;
				  resizeElements.startY = mdEvt.data.$.screenY;
          resizeElements.startWidth = resizeImg.$.clientWidth;
          resizeElements.startHeight = resizeImg.$.clientHeight;
          resizeElements.ratio = resizeElements.startWidth / resizeElements.startHeight;
          
        });
        
        resizeElements.bottomRightResizer.on('mouseup', function(evt) {
          editor.resetUndo();
          isResizing = false;
          updateImgSrc();
        });
      }
      
      function createResizers(rect, overlay) {
        
        var bottomRightResizer = CKEDITOR.dom.element.createFromHtml('<div class="resizer bottom-right"><div>');
        setUpResizer(bottomRightResizer, rect.bottom, rect.right, resizerSize);
        overlay.append(bottomRightResizer);
        resizeElements.bottomRightResizer = bottomRightResizer;
      }
      
      function setUpResizer(element, top, left, size) {
        element.setStyle('top', top - size/2 + 'px');
        element.setStyle('left', left - size/2 + 'px');
        element.setStyle('width', size + 'px');
        element.setStyle('height', size + 'px');
        element.on('click', function(evt) {
          evt.data.$.stopPropagation();
          evt.data.$.preventDefault();
        });
      }
      
      function getPosition(element) {
        var body = getBody();
        if(!body) {
          return;
        }
        var resRect = element.$.getBoundingClientRect();
        
        return {
          top: resRect.top + body.$.scrollTop,
          bottom: resRect.bottom + body.$.scrollTop,
          left: resRect.left + body.$.scrollLeft,
          right: resRect.right + body.$.scrollLeft,
          width: resRect.width,
          height: resRect.height
        };
      }
      
      function updateImgSrc() {
        var initialUrl = resizeImg.getAttribute('src');
        var newUrl = initialUrl.substr(0, initialUrl.indexOf('/preview')) + '/preview/' + resizeElements.newWidth + 'x' + resizeElements.newHeight + '/';
        resizeImg.setAttributes({
              'data-cke-saved-src': newUrl,
              'src': newUrl
            });
      }
      
      function adjustToX(moveDiffX) {
				resizeElements.newWidth = resizeElements.startWidth + moveDiffX;
				resizeElements.newHeight = Math.round( resizeElements.newWidth / resizeElements.ratio );
			}

			// Calculate height first, and then adjust width, preserving ratio.
			function adjustToY(moveDiffY) {
				resizeElements.newHeight = resizeElements.startHeight - moveDiffY;
				resizeElements.newWidth = Math.round( resizeElements.newHeight * resizeElements.ratio );
			}
    });    
  }
});

},{"./commands/show-uploadcare-dialog":1,"./styles/resize":4,"./tools/clear-toolbar":5,"./tools/find-one":6,"./tools/get-body":7}],4:[function(require,module,exports){

module.exports = 
".tools-container {" + 
"  position: absolute;" +
"  float: left;" +
"  border: 1px solid #ddd;" +
"  border-radius: 4px;" +
"  background: #fff;" +
"}" +

".button {" +
"  border: 0px;" +
"  background: #fff;" +
"  border-radius: 2px;" +
"  margin: 2px;" +
"}" +

".button:hover {" +
"  background-color: #e1edf7;" +
"}" +

".icon {" +
"  width: 22px;" +
"  height: 20px;" +
"}" +

".icon-resize {" +
"  background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTZweCIgaGVpZ2h0PSIxNnB4IiB2aWV3Qm94PSIwIDAgMTYgMTYiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+DQogICAgPGcgaWQ9IlBhZ2UtMSIgc3Ryb2tlPSJub25lIiBzdHJva2Utd2lkdGg9IjEiIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+DQogICAgICAgIDxnIHRyYW5zZm9ybT0idHJhbnNsYXRlKC0xLjAwMDAwMCwgLTEuMDAwMDAwKSI+DQogICAgICAgICAgICA8cGF0aCBkPSJNMTEuNDkxMjIwMywxLjAwMDM5Njk2IEMxMS4yOTA3OTQ5LDEuMDA5Nzk0NDMgMTEuMTM1OTM5MiwxLjE3OTkyMTAxIDExLjE0NTI5NjIsMS4zODAzNDYzMyBDMTEuMTU0NjkzNywxLjU4MDgxMjE1IDExLjMyNDgyMDMsMS43MzU2Njc4NSAxMS41MjUyNDU2LDEuNzI2MjcwMzggTDE1LjcyNzM3MjIsMS43MjYyNzAzOCBMMS43MjU5NTQ0MywxNS43Mjc2ODgxIEwxLjcyNTk1NDQzLDExLjUyNTYwMiBDMS43MzAyODg2MSwxMS4zMjUxMzYyIDEuNTcxMzAxMjcsMTEuMTU5MTgxOCAxLjM3MDg3NTk1LDExLjE1NDg0NzYgQzEuMzU0OTk3NDcsMTEuMTU0NTIzNSAxLjMzOTExODk5LDExLjE1NTIxMjIgMS4zMjMzMjE1MiwxMS4xNTY5NTM5IEMxLjEzNjM0NDMsMTEuMTc3NTMxMSAwLjk5NjAzMDM4LDExLjMzNzQ5MDYgMS4wMDAwODEwMSwxMS41MjU2MDIgTDEuMDAwMDgxMDEsMTYuNjA2Njc1NCBDMS4wMDAwODEwMSwxNi44MDcxNDEzIDEuMTYyNTkyNDEsMTYuOTY5NTcxNiAxLjM2MzAxNzcyLDE2Ljk2OTYxMjIgTDYuNDQ0MTMxNjUsMTYuOTY5NjEyMiBDNi42NDQ1OTc0NywxNi45NzI0ODgxIDYuODA5Mzc3MjIsMTYuODEyMjQ1MSA2LjgxMjIxMjY2LDE2LjYxMTgxOTcgQzYuODE1MDQ4MSwxNi40MTEzNTM5IDYuNjU0ODg2MDgsMTYuMjQ2NTc0MiA2LjQ1NDM3OTc1LDE2LjI0MzczODcgQzYuNDUwOTc3MjIsMTYuMjQzNjk4MiA2LjQ0NzUzNDE4LDE2LjI0MzY5ODIgNi40NDQxMzE2NSwxNi4yNDM3Mzg3IEwyLjIzNjMzNDE4LDE2LjI0MzczODcgTDE2LjI0MzQyMjgsMi4yMzY2NTAxMyBMMTYuMjQzNDIyOCw2LjQ0NDQ0NzU5IEMxNi4yNDA1ODczLDYuNjQ0OTEzNDIgMTYuNDAwNzg5OSw2LjgwOTY5MzE2IDE2LjYwMTIxNTIsNi44MTI1Mjg2MSBDMTYuODAxNjgxLDYuODE1MzY0MDUgMTYuOTY2NDYwOCw2LjY1NTE2MTUyIDE2Ljk2OTI5NjIsNi40NTQ2OTU3IEMxNi45NjkzMzY3LDYuNDUxMjkzMTYgMTYuOTY5MzM2Nyw2LjQ0Nzg1MDEzIDE2Ljk2OTI5NjIsNi40NDQ0NDc1OSBMMTYuOTY5Mjk2MiwxLjM2MzMzMzY3IEMxNi45NjkyNTU3LDEuMTYyOTA4MzUgMTYuODA2ODI1MywxLjAwMDM5Njk2IDE2LjYwNjM1OTUsMS4wMDAzOTY5NiBMMTEuNTI1MjQ1NiwxLjAwMDM5Njk2IEMxMS41MTM5NDQzLDAuOTk5ODcwMzggMTEuNTAyNTYyLDAuOTk5ODcwMzggMTEuNDkxMjIwMywxLjAwMDM5Njk2IiBpZD0iRmlsbC0xIiBmaWxsPSIjMDAwMDAwIj48L3BhdGg+DQogICAgICAgICAgICA8cmVjdCBpZD0iUmVjdGFuZ2xlLTEiIHg9IjAiIHk9IjAiIHdpZHRoPSIxOCIgaGVpZ2h0PSIxOCI+PC9yZWN0Pg0KICAgICAgICA8L2c+DQogICAgPC9nPg0KPC9zdmc+') 100% 100% no-repeat;" +
"  background-position: center;" +
"  background-size: 16px 16px;" +
"}" +

".icon-uploadcare {" +
"  background: url(\"../icons/uploadcare.png\") 100% 100% no-repeat;" +
"  background-position: center;" +
"}" +

".icon-crop {" +
"  background: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTZweCIgaGVpZ2h0PSIxNnB4IiB2aWV3Qm94PSIwIDAgMTYgMTYiIHZlcnNpb249IjEuMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB4bWxuczp4bGluaz0iaHR0cDovL3d3dy53My5vcmcvMTk5OS94bGluayI+DQogICAgPHRpdGxlPlBhZ2UgMTwvdGl0bGU+DQogICAgPGRlc2M+Q3JlYXRlZCB3aXRoIFNrZXRjaC48L2Rlc2M+DQogICAgPGRlZnM+PC9kZWZzPg0KICAgIDxnIGlkPSJQYWdlLTEiIHN0cm9rZT0ibm9uZSIgc3Ryb2tlLXdpZHRoPSIxIiBmaWxsPSJub25lIiBmaWxsLXJ1bGU9ImV2ZW5vZGQiPg0KICAgICAgICA8ZyB0cmFuc2Zvcm09InRyYW5zbGF0ZSgtMS4wMDAwMDAsIC0xLjAwMDAwMCkiPg0KICAgICAgICAgICAgPHBhdGggZD0iTTEyLjEyNTAyNzcsMTMuMDM5OTU1NiBMNS40NDY0Mzk2NSwxMy4wMzk5NTU2IEwxMi4xMjUwMjc3LDYuMzk4NDQ2MTcgTDEyLjEyNTAyNzcsMTMuMDM5OTU1NiBaIE0xMS41MTc4ODMzLDUuOTM2NzM2OTYgTDQuODU3MTUyNDcsMTIuNTYwNDg4MyBMNC44NTcxNTI0Nyw1LjkzNjczNjk2IEwxMS41MTc4ODMzLDUuOTM2NzM2OTYgWiBNMTYuODkyODU2OSwxLjYzOTI4OTY4IEMxNy4wMzU3MTQ0LDEuNDk3MjI1MzEgMTcuMDM1NzE0NCwxLjI0ODYxMjY1IDE2Ljg5Mjg1NjksMS4xMDY1NDgyOCBDMTYuNzQ5OTk5NCwwLjk2NDQ4MzkwNyAxNi41MDAwMzg2LDAuOTY0NDgzOTA3IDE2LjM1NzE4MTEsMS4xMDY1NDgyOCBMMTIuODM5MzE1Miw0LjYyMjY0MTUxIEw0Ljg1NzE1MjQ3LDQuNjIyNjQxNTEgTDQuODU3MTUyNDcsMi42MzM3NDAyOSBDNC44NTcxNTI0NywyLjI3ODU3OTM2IDQuNTUzNTgwMjgsMS45NzY2OTI1NiA0LjE5NjM5NjY3LDEuOTc2NjkyNTYgQzMuODM5MjUyOTMsMS45NzY2OTI1NiAzLjUzNTcyMDYsMi4yNzg1NzkzNiAzLjUzNTcyMDYsMi42MzM3NDAyOSBMMy41MzU3MjA2LDQuNjIyNjQxNTEgTDEuNjYwNzE1OTMsNC42MjI2NDE1MSBDMS4zMDM1NzIxOCw0LjYyMjY0MTUxIDEsNC45MjQ1MjgzIDEsNS4yNzk2ODkyMyBDMSw1LjYzNDg1MDE3IDEuMzAzNTcyMTgsNS45MzY3MzY5NiAxLjY2MDcxNTkzLDUuOTM2NzM2OTYgTDMuNTM1NzIwNiw1LjkzNjczNjk2IEwzLjUzNTcyMDYsMTQuMzU0MDUxMSBMMTIuMTI1MDI3NywxNC4zNTQwNTExIEwxMi4xMjUwMjc3LDE2LjM0Mjk1MjMgQzEyLjEyNTAyNzcsMTYuNjk4MTEzMiAxMi40Mjg1NiwxNyAxMi43ODU3MDM4LDE3IEMxMy4xNDI4NDc1LDE3IDEzLjQ0NjQxOTcsMTYuNjk4MTEzMiAxMy40NDY0MTk3LDE2LjM0Mjk1MjMgTDEzLjQ0NjQxOTcsMTQuMzM2MjkzIEwxNS4zMjE0MjQ0LDE0LjMzNjI5MyBDMTUuNjc4NTY4MSwxNC4zMzYyOTMgMTUuOTgyMTgwMiwxNC4wMzQ0MDYyIDE1Ljk4MjE4MDIsMTMuNjc5MjQ1MyBDMTUuOTgyMTgwMiwxMy4zMjQwODQ0IDE1LjY3ODU2ODEsMTMuMDIyMTk3NiAxNS4zMjE0MjQ0LDEzLjAyMjE5NzYgTDEzLjQ0NjQxOTcsMTMuMDIyMTk3NiBMMTMuNDQ2NDE5Nyw1LjA4NDM1MDcyIEwxNi44OTI4NTY5LDEuNjM5Mjg5NjggWiIgaWQ9IkZpbGwtMSIgZmlsbD0iIzAwMDAwMCI+PC9wYXRoPg0KICAgICAgICAgICAgPHJlY3QgaWQ9IlJlY3RhbmdsZS0xIiB4PSIwIiB5PSIwIiB3aWR0aD0iMTgiIGhlaWdodD0iMTgiPjwvcmVjdD4NCiAgICAgICAgPC9nPg0KICAgIDwvZz4NCjwvc3ZnPg==') 100% 100% no-repeat;" +
"  background-position: center;" +
"  background-size: 16px 16px;" +
"}" + 
 
".screen-overlay {" +
"  position: absolute;" +
"  top: 0;" +
"  left: 0;" +
"  min-height: 100%;" +
"  min-width: 100%;" +
"  z-index: 10;" +
"  cursor: default;" +
"}" +

".resize-border {" +
"  position: absolute;" +
"  border: 1px dashed #bbbbbb;" +
"  z-index: 11;" +
"  background-color: rgba(128, 128, 128, 0.15);" +
"  cursor: default;" +
"}" +

".resizer {" +
"  background-color: white;" +
"  border: 1px solid #bbbbbb;" +
"  position: absolute;" +
"  z-index: 12;" +
"}" +

".top-left {" +
"  cursor: nw-resize;" +
"}" +

".top-right {" +
"  cursor: ne-resize;" +
"}" +

".bottom-left {" +
"  cursor: sw-resize;" +
"}" +

".bottom-right {" +
"  cursor: se-resize;" +
"}";
},{}],5:[function(require,module,exports){
'use strict'

var getBody = require('./get-body');
var findOne = require('./find-one');

module.exports = function() {        
  var body = getBody();
  
  if(!body) {
    return;
  }
    
  var tools = body.findOne ? body.findOne('div.tools-container') : findOne.bind(body)('div.tools-container'); 
  
  if(tools) {
    tools.hide();
  }
}
},{"./find-one":6,"./get-body":7}],6:[function(require,module,exports){
module.exports = function( selector ) {
  var removeTmpId = createTmpId( this ),
    found = this.$.querySelector( getContextualizedSelector( this, selector ) );

  removeTmpId();

  return found ? new CKEDITOR.dom.element( found ) : null;
}


function getContextualizedSelector( element, selector ) {
		return '#' + element.$.id + ' ' + selector.split( /,\s*/ ).join( ', #' + element.$.id + ' ' );
	}

function createTmpId( element ) {
		var hadId = true;

		if ( !element.$.id ) {
			element.$.id = 'cke_tmp_' + CKEDITOR.tools.getNextNumber();
			hadId = false;
		}

		return function() {
			if ( !hadId )
				element.removeAttribute( 'id' );
		};
	}
},{}],7:[function(require,module,exports){
'use strict'

var editor = require('../globals/editor').editor;

module.exports = function getBody() {
  try {
    var editor = CKEDITOR.currentInstance;
    var editable = editor.editable();
    var doc = editable.getDocument();
    return doc.getBody();
  } catch (ex) {
    return null;      
  }
}
},{"../globals/editor":2}],8:[function(require,module,exports){
'use strict'

module.exports = function (editor, needle) {
  var sel = editor.getSelection();
  var element = sel.getSelectedElement();
  if (element && element.is(needle)) {
    return element;
  }

  var widget;
  if (editor.widgets && (widget = editor.widgets.selected[0])) {
    if (widget.element.is(needle)) {
      return widget.element;
    }
  }

  var range = sel.getRanges()[0];
  if (range) {
    range.shrink(CKEDITOR.SHRINK_TEXT);
    return editor.elementPath(range.getCommonAncestor()).contains(needle, 1);
  }
}
},{}]},{},[3])
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIm5vZGVfbW9kdWxlcy9icm93c2VyaWZ5L25vZGVfbW9kdWxlcy9icm93c2VyLXBhY2svX3ByZWx1ZGUuanMiLCJzcmMvY29tbWFuZHMvc2hvdy11cGxvYWRjYXJlLWRpYWxvZy5qcyIsInNyYy9nbG9iYWxzL2VkaXRvci5qcyIsInNyYy9wbHVnaW4uanMiLCJzcmMvc3R5bGVzL3Jlc2l6ZS5qcyIsInNyYy90b29scy9jbGVhci10b29sYmFyLmpzIiwic3JjL3Rvb2xzL2ZpbmQtb25lLmpzIiwic3JjL3Rvb2xzL2dldC1ib2R5LmpzIiwic3JjL3Rvb2xzL3NlYXJjaC1zZWxlY3RlZC1lbGVtZW50LmpzIl0sIm5hbWVzIjpbXSwibWFwcGluZ3MiOiJBQUFBO0FDQUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUN0RUE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQ0xBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUM1UkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTs7QUNsRkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBOztBQ2pCQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDMUJBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7O0FDYkE7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0EiLCJmaWxlIjoiZ2VuZXJhdGVkLmpzIiwic291cmNlUm9vdCI6IiIsInNvdXJjZXNDb250ZW50IjpbIihmdW5jdGlvbiBlKHQsbixyKXtmdW5jdGlvbiBzKG8sdSl7aWYoIW5bb10pe2lmKCF0W29dKXt2YXIgYT10eXBlb2YgcmVxdWlyZT09XCJmdW5jdGlvblwiJiZyZXF1aXJlO2lmKCF1JiZhKXJldHVybiBhKG8sITApO2lmKGkpcmV0dXJuIGkobywhMCk7dmFyIGY9bmV3IEVycm9yKFwiQ2Fubm90IGZpbmQgbW9kdWxlICdcIitvK1wiJ1wiKTt0aHJvdyBmLmNvZGU9XCJNT0RVTEVfTk9UX0ZPVU5EXCIsZn12YXIgbD1uW29dPXtleHBvcnRzOnt9fTt0W29dWzBdLmNhbGwobC5leHBvcnRzLGZ1bmN0aW9uKGUpe3ZhciBuPXRbb11bMV1bZV07cmV0dXJuIHMobj9uOmUpfSxsLGwuZXhwb3J0cyxlLHQsbixyKX1yZXR1cm4gbltvXS5leHBvcnRzfXZhciBpPXR5cGVvZiByZXF1aXJlPT1cImZ1bmN0aW9uXCImJnJlcXVpcmU7Zm9yKHZhciBvPTA7bzxyLmxlbmd0aDtvKyspcyhyW29dKTtyZXR1cm4gc30pIiwiJ3VzZSBzdHJpY3QnXG5cbnZhciBzZWFyY2hTZWxlY3RlZEVsZW1lbnQgPSByZXF1aXJlICgnLi4vdG9vbHMvc2VhcmNoLXNlbGVjdGVkLWVsZW1lbnQnKTtcblxubW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbigpIHtcbiAgaWYgKHR5cGVvZiB1cGxvYWRjYXJlID09ICd1bmRlZmluZWQnKSB7XG4gICAgcmV0dXJuOyAvLyBub3QgbG9hZGVkIHlldFxuICB9XG4gIHZhciBlZGl0b3IgPSBDS0VESVRPUi5jdXJyZW50SW5zdGFuY2U7XG4gIFxuICB2YXIgY29uZmlnID0gZWRpdG9yLmNvbmZpZy51cGxvYWRjYXJlIHx8IHt9O1xuICBcbiAgLy8gQXBwbHkgZGVmYXVsdCBwcm9wZXJ0aWVzLlxuICBpZiAoICEgKCdjcm9wJyBpbiBjb25maWcpKSB7XG4gICAgY29uZmlnLmNyb3AgPSAnJztcbiAgfVxuXG4gIHVwbG9hZGNhcmUucGx1Z2luKGZ1bmN0aW9uKHVjKSB7XG4gICAgdmFyIHNldHRpbmdzLCBlbGVtZW50LCBmaWxlO1xuXG4gICAgaWYgKGVsZW1lbnQgPSBzZWFyY2hTZWxlY3RlZEVsZW1lbnQoZWRpdG9yLCAnaW1nJykpIHtcbiAgICAgIGZpbGUgPSBlbGVtZW50LmdldEF0dHJpYnV0ZSgnc3JjJyk7XG4gICAgfSBlbHNlIGlmIChlbGVtZW50ID0gc2VhcmNoU2VsZWN0ZWRFbGVtZW50KGVkaXRvciwgJ2EnKSkge1xuICAgICAgZmlsZSA9IGVsZW1lbnQuZ2V0QXR0cmlidXRlKCdocmVmJyk7XG4gICAgfVxuXG4gICAgaWYgKGZpbGUgJiYgdWMudXRpbHMuc3BsaXRDZG5VcmwoZmlsZSkpIHtcbiAgICAgIHNldHRpbmdzID0gdWMuc2V0dGluZ3MuYnVpbGQoXG4gICAgICAgIHVjLmpRdWVyeS5leHRlbmQoe30sIGNvbmZpZywge211bHRpcGxlOiBmYWxzZX0pXG4gICAgICApO1xuICAgICAgZmlsZSA9IHVwbG9hZGNhcmUuZmlsZUZyb20oJ3VwbG9hZGVkJywgZmlsZSwgc2V0dGluZ3MpO1xuICAgIH0gZWxzZSB7XG4gICAgICBzZXR0aW5ncyA9IHVjLnNldHRpbmdzLmJ1aWxkKGNvbmZpZylcbiAgICAgIGZpbGUgPSBudWxsO1xuICAgIH1cblxuICAgIHZhciBkaWFsb2cgPSB1cGxvYWRjYXJlLm9wZW5EaWFsb2coZmlsZSwgc2V0dGluZ3MpLmRvbmUoZnVuY3Rpb24oc2VsZWN0ZWQpIHtcbiAgICAgIHZhciBmaWxlcyA9IHNldHRpbmdzLm11bHRpcGxlID8gc2VsZWN0ZWQuZmlsZXMoKSA6IFtzZWxlY3RlZF07XG4gICAgICB1Yy5qUXVlcnkud2hlbi5hcHBseShudWxsLCBmaWxlcykuZG9uZShmdW5jdGlvbigpIHtcbiAgICAgICAgdWMualF1ZXJ5LmVhY2goYXJndW1lbnRzLCBmdW5jdGlvbigpIHtcbiAgICAgICAgICB2YXIgaW1hZ2VVcmwgPSB0aGlzLmNkblVybDtcbiAgICAgICAgICBpZiAodGhpcy5pc0ltYWdlICYmICEgdGhpcy5jZG5VcmxNb2RpZmllcnMpIHtcbiAgICAgICAgICAgIGltYWdlVXJsICs9ICctL3ByZXZpZXcvJztcbiAgICAgICAgICB9XG4gICAgICAgICAgaWYgKGVsZW1lbnQpIHtcbiAgICAgICAgICAgIHZhciB3aWRnZXQ7XG4gICAgICAgICAgICBpZiAoZWRpdG9yLndpZGdldHMgJiYgKHdpZGdldCA9IGVkaXRvci53aWRnZXRzLnNlbGVjdGVkWzBdKVxuICAgICAgICAgICAgICAgICYmIHdpZGdldC5lbGVtZW50ID09PSBlbGVtZW50XG4gICAgICAgICAgICApIHtcbiAgICAgICAgICAgICAgd2lkZ2V0LnNldERhdGEoJ3NyYycsIGltYWdlVXJsKS5zZXREYXRhKCdoZWlnaHQnLCBudWxsKVxuICAgICAgICAgICAgfSBlbHNlIGlmIChlbGVtZW50LmdldE5hbWUoKSA9PSAnaW1nJykge1xuICAgICAgICAgICAgICBlbGVtZW50LmRhdGEoJ2NrZS1zYXZlZC1zcmMnLCAnJyk7XG4gICAgICAgICAgICAgIGVsZW1lbnQuc2V0QXR0cmlidXRlKCdzcmMnLCBpbWFnZVVybCk7XG4gICAgICAgICAgICAgIGVsZW1lbnQucmVtb3ZlQXR0cmlidXRlKCd3aWR0aCcpO1xuICAgICAgICAgICAgICBlbGVtZW50LnJlbW92ZUF0dHJpYnV0ZSgnaGVpZ2h0Jyk7XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICBlbGVtZW50LmRhdGEoJ2NrZS1zYXZlZC1ocmVmJywgJycpO1xuICAgICAgICAgICAgICBlbGVtZW50LnNldEF0dHJpYnV0ZSgnaHJlZicsIHRoaXMuY2RuVXJsKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgaWYgKHRoaXMuaXNJbWFnZSkge1xuICAgICAgICAgICAgICBlZGl0b3IuaW5zZXJ0SHRtbCgnPGltZyBzcmM9XCInICsgaW1hZ2VVcmwgKyAnXCIgYWx0PVwiXCIvPjxicj4nLCAndW5maWx0ZXJlZF9odG1sJyk7XG4gICAgICAgICAgICB9IGVsc2Uge1xuICAgICAgICAgICAgICBlZGl0b3IuaW5zZXJ0SHRtbCgnPGEgaHJlZj1cIicgKyB0aGlzLmNkblVybCArICdcIj4nICsgdGhpcy5uYW1lICsgJzwvYT4gJywgJ3VuZmlsdGVyZWRfaHRtbCcpO1xuICAgICAgICAgICAgfVxuICAgICAgICAgIH1cbiAgICAgICAgfSk7XG4gICAgICB9KTtcbiAgICB9KTtcbiAgfSk7XG59IiwiJ3VzZSBzY3JpY3QnXG5cbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24oKSB7XG4gIHRoaXMuZWRpdG9yID0gbnVsbDtcbiAgdGhpcy50YXJnZXRJbWcgPSBudWxsO1xufSIsIi8vIFVwbG9hZGNhcmUgQ0tlZGl0b3IgcGx1Z2luXG4vLyBWZXJzaW9uOiAyLjEuMVxuJ3VzZSBzdHJpY3QnO1xuXG52YXIgZmluZE9uZSA9IHJlcXVpcmUoJy4vdG9vbHMvZmluZC1vbmUnKTtcblxuQ0tFRElUT1IucGx1Z2lucy5hZGQoJ3VwbG9hZGNhcmUnLCB7XG4gIGhpZHBpOiB0cnVlLFxuICBpY29uczogJ3VwbG9hZGNhcmUnLFxuICBpbml0IDogZnVuY3Rpb24oZWRpdG9yKSB7XG4gICAgdmFyIHRhcmdldEltZyA9IG51bGw7XG4gICAgdmFyIGdldEJvZHkgPSByZXF1aXJlKCcuL3Rvb2xzL2dldC1ib2R5Jyk7XG4gICAgXG4gICAgQ0tFRElUT1IuYWRkQ3NzKHJlcXVpcmUoJy4vc3R5bGVzL3Jlc2l6ZScpKTtcbiAgICB2YXIgY29uZmlnID0gZWRpdG9yLmNvbmZpZy51cGxvYWRjYXJlIHx8IHt9O1xuXG4gICAgLy8gQ2hlY2sgaWYgVXBsb2FkY2FyZSBpcyBhbHJlYWR5IGxvYWRlZCBhbmQgbG9hZCBpdCBpZiBub3QuXG4gICAgaWYgKHR5cGVvZiB1cGxvYWRjYXJlID09PSAndW5kZWZpbmVkJykge1xuICAgICAgICB2YXIgdmVyc2lvbiA9IGNvbmZpZy53aWRnZXRWZXJzaW9uIHx8ICcyLjQuMCc7XG4gICAgICAgIHZhciB3aWRnZXRfdXJsID0gJ2h0dHBzOi8vdWNhcmVjZG4uY29tL3dpZGdldC8nICsgdmVyc2lvbiArXG4gICAgICAgICAgICAgICAgICcvdXBsb2FkY2FyZS91cGxvYWRjYXJlLmZ1bGwubWluLmpzJ1xuICAgICAgICBDS0VESVRPUi5zY3JpcHRMb2FkZXIubG9hZCh3aWRnZXRfdXJsKTtcbiAgICB9XG5cbiAgICBlZGl0b3IuYWRkQ29tbWFuZCgnc2hvd1VwbG9hZGNhcmVEaWFsb2cnLCB7XG4gICAgICBhbGxvd2VkQ29udGVudDogJ2ltZ1shc3JjLGFsdF17d2lkdGgsaGVpZ2h0fTthWyFocmVmXScsXG4gICAgICByZXF1aXJlZENvbnRlbnQ6ICdpbWdbc3JjXTthW2hyZWZdJyxcbiAgICAgIGV4ZWMgOiByZXF1aXJlKCcuL2NvbW1hbmRzL3Nob3ctdXBsb2FkY2FyZS1kaWFsb2cnKVxuICAgIH0pO1xuXG4gICAgZWRpdG9yLnVpLmFkZEJ1dHRvbiAmJiBlZGl0b3IudWkuYWRkQnV0dG9uKCdVcGxvYWRjYXJlJywge1xuICAgICAgbGFiZWwgOiAnVXBsb2FkY2FyZScsXG4gICAgICB0b29sYmFyIDogJ2luc2VydCcsXG4gICAgICBjb21tYW5kIDogJ3Nob3dVcGxvYWRjYXJlRGlhbG9nJ1xuICAgIH0pO1xuICAgIFxuICAgIGVkaXRvci5vbignY29udGVudERvbScsIGZ1bmN0aW9uKCkge1xuICAgICAgXG4gICAgICB2YXIgZWRpdGFibGUgPSBlZGl0b3IuZWRpdGFibGUoKTtcbiAgICAgIHZhciB0b29scyA9IG51bGw7XG4gICAgICB2YXIgaXNSZXNpemluZyA9IGZhbHNlO1xuICAgICAgdmFyIHJlc2l6ZUltZyA9IG51bGw7XG4gICAgICB2YXIgcmVzaXplRWxlbWVudHMgPSBudWxsO1xuICAgICAgdmFyIHJlc2l6ZXJTaXplID0gMTI7XG4gICAgICBcbiAgICAgIHZhciBjbGVhclRvb2xiYXIgPSByZXF1aXJlKCcuL3Rvb2xzL2NsZWFyLXRvb2xiYXInKTtcbiAgICAgIFxuICAgICAgZWRpdGFibGUuYXR0YWNoTGlzdGVuZXIoIGVkaXRhYmxlLmlzSW5saW5lKCkgPyBlZGl0YWJsZSA6IGVkaXRvci5kb2N1bWVudCwgJ21vdXNlbW92ZScsIGZ1bmN0aW9uKCBldnQgKSB7XG4gICAgICAgIGV2dCA9IGV2dC5kYXRhO1xuICAgICAgICB2YXIgdGFyZ2V0ID0gZXZ0LmdldFRhcmdldCgpO1xuICAgICAgICB2YXIgc3JjID0gdGFyZ2V0LiQuZ2V0QXR0cmlidXRlKCdzcmMnKTtcbiAgICAgICAgIFxuICAgICAgICBmdW5jdGlvbiBvbk1vdXNlT3V0KGV2dCkge1xuICAgICAgICAgIHZhciB0YXJnZXQgPSBldnQuZGF0YS5nZXRUYXJnZXQoKTtcbiAgICAgICAgICB2YXIgcmVjdCA9IHRhcmdldC4kLmdldEJvdW5kaW5nQ2xpZW50UmVjdCgpO1xuICAgICAgICAgIFxuICAgICAgICAgIGlmKChldnQuZGF0YS4kLmNsaWVudFggPCByZWN0LmxlZnQgfHwgZXZ0LmRhdGEuJC5jbGllbnRYID4gcmVjdC5yaWdodCkgfHwgXG4gICAgICAgICAgKGV2dC5kYXRhLiQuY2xpZW50WSA8IHJlY3QudG9wIHx8IGV2dC5kYXRhLiQuY2xpZW50WSA+IHJlY3QuYm90dG9tKSkge1xuICAgICAgICAgICAgdG9vbHMuaGlkZSgpOyAgXG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIFxuICAgICAgICBpZih0YXJnZXQuaXMoJ2ltZycpICYmIChzcmMuaW5kZXhPZignd3d3LnVjYXJlY2RuLmNvbScpID4gLTEpICYmICFpc1Jlc2l6aW5nKSB7XG4gICAgICAgICAgdmFyIGJvZHkgPSBnZXRCb2R5KCk7XG4gICAgICAgICAgaWYoIWJvZHkpIHtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgICB9XG4gICAgICAgICAgdGFyZ2V0SW1nID0gdGFyZ2V0O1xuICAgICAgICAgIGlmKCF0b29scykge1xuICAgICAgICAgICAgdG9vbHMgPSBib2R5LmZpbmRPbmUgPyBib2R5LmZpbmRPbmUoJ2Rpdi50b29scy1jb250YWluZXInKSA6IGZpbmRPbmUuYmluZChib2R5KSgnZGl2LnRvb2xzLWNvbnRhaW5lcicpO1xuICAgICAgICAgICAgaWYoIXRvb2xzKSB7XG4gICAgICAgICAgICAgIHRvb2xzID0gQ0tFRElUT1IuZG9tLmVsZW1lbnQuY3JlYXRlRnJvbUh0bWwoJzxkaXYgY2xhc3M9XCJ0b29scy1jb250YWluZXJcIj48YnV0dG9uIGNsYXNzPVwiYnV0dG9uIHJlc2l6ZSBpY29uIGljb24tcmVzaXplXCI+PC9idXR0b24+PGJ1dHRvbiBjbGFzcz1cImJ1dHRvbiBkaWFsb2cgaWNvbiBpY29uLWNyb3BcIj48L2J1dHRvbj48L2Rpdj4nKTtcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgIHRvb2xzLnNldFN0eWxlKCd6aW5kZXgnLCAnMTAwJyk7XG4gICAgICAgICAgICBib2R5LmFwcGVuZCh0b29scyk7IFxuICAgICAgICAgICAgdG9vbHMub24oJ21vdXNlb3V0Jywgb25Nb3VzZU91dCk7XG4gICAgICAgICAgICBcbiAgICAgICAgICAgIHRvb2xzLnJlbW92ZUFsbExpc3RlbmVycygpO1xuICAgICAgICAgICAgdmFyIHJlc2l6ZUJ0biA9IHRvb2xzLmZpbmRPbmUgPyB0b29scy5maW5kT25lKCdidXR0b24ucmVzaXplJykgOiBmaW5kT25lLmJpbmQodG9vbHMpKCdidXR0b24ucmVzaXplJyk7XG4gICAgICAgICAgICBcbiAgICAgICAgICAgIHJlc2l6ZUJ0bi5vbignY2xpY2snLCBvblJlc2l6ZUFjdGlvbik7XG4gICAgICAgICAgICBcbiAgICAgICAgICAgIHZhciBkaWFsb2dCdG4gPSB0b29scy5maW5kT25lID8gdG9vbHMuZmluZE9uZSgnYnV0dG9uLmRpYWxvZycpIDogZmluZE9uZS5iaW5kKHRvb2xzKSgnYnV0dG9uLmRpYWxvZycpO1xuICAgICAgICAgICAgZGlhbG9nQnRuLm9uKCdjbGljaycsIGZ1bmN0aW9uKCl7XG4gICAgICAgICAgICAgIGVkaXRvci5nZXRTZWxlY3Rpb24oKS5zZWxlY3RFbGVtZW50KCB0YXJnZXRJbWcgKTtcbiAgICAgICAgICAgICAgZWRpdG9yLmV4ZWNDb21tYW5kKCdzaG93VXBsb2FkY2FyZURpYWxvZycpO1xuICAgICAgICAgICAgfSk7XG4gICAgICAgICAgICBcbiAgICAgICAgICAgIHRhcmdldC5yZW1vdmVBbGxMaXN0ZW5lcnMoKTtcbiAgICAgICAgICAgIHRhcmdldC5vbignbW91c2VvdXQnLCBvbk1vdXNlT3V0KTsgICAgICAgICAgXG4gICAgICAgICAgICBcbiAgICAgICAgICB9XG4gICAgICAgICAgZWxzZSB7XG4gICAgICAgICAgICB0b29scy5zaG93KCk7XG4gICAgICAgICAgfVxuICAgICAgICAgIFxuICAgICAgICAgIHZhciByZWN0ID0gZ2V0UG9zaXRpb24odGFyZ2V0KTtcbiAgICAgICAgICB0b29scy5zZXRTdHlsZSgndG9wJywgcmVjdC50b3AgKyAncHgnKTtcbiAgICAgICAgICB0b29scy5zZXRTdHlsZSgnbGVmdCcsIHJlY3QubGVmdCArICdweCcpO1xuICAgICAgICAgIFxuICAgICAgICAgIFxuICAgICAgICB9IGVsc2UgaWYgKHRvb2xzICYmIHRhcmdldC4kICE9PSB0b29scy4kICYmICFpc1Jlc2l6aW5nKSB7XG4gICAgICAgICAgaWYodGFyZ2V0LmdldFBhcmVudCgpICYmICF0YXJnZXQuZ2V0UGFyZW50KCkuaGFzQ2xhc3MoJ3Rvb2xzLWNvbnRhaW5lcicpKSB7XG4gICAgICAgICAgICB0b29scy5oaWRlKCk7XG4gICAgICAgICAgfVxuICAgICAgICB9XG4gICAgICAgIFxuICAgICAgICBpZihpc1Jlc2l6aW5nKSB7XG4gICAgICAgICAgdmFyIG5hdGl2ZUV2dCA9IGV2dC4kO1xuXG4gICAgICAgICAgdmFyIG1vdmVEaWZmWCA9IG5hdGl2ZUV2dC5zY3JlZW5YIC0gcmVzaXplRWxlbWVudHMuc3RhcnRYO1xuICAgICAgICAgIHZhciBtb3ZlRGlmZlkgPSByZXNpemVFbGVtZW50cy5zdGFydFkgLSBuYXRpdmVFdnQuc2NyZWVuWTtcbiAgICAgICAgICB2YXIgbW92ZVJhdGlvID0gTWF0aC5hYnMobW92ZURpZmZYIC8gbW92ZURpZmZZKTtcbiAgICAgICAgICBcbiAgICAgICAgICBpZiAoIG1vdmVEaWZmWCA8PSAwICkge1xuXHRcdFx0XHRcdFx0aWYgKCBtb3ZlRGlmZlkgPD0gMCApIHtcblx0XHRcdFx0XHRcdFx0YWRqdXN0VG9YKG1vdmVEaWZmWCk7XG4gICAgICAgICAgICB9IGVsc2Uge1xuXHRcdFx0XHRcdFx0XHRpZiAoIG1vdmVSYXRpbyA+PSByZXNpemVFbGVtZW50cy5yYXRpbyApIHtcblx0XHRcdFx0XHRcdFx0XHRhZGp1c3RUb1gobW92ZURpZmZYKTtcbiAgICAgICAgICAgICAgfSBlbHNlIHtcblx0XHRcdFx0XHRcdFx0XHRhZGp1c3RUb1kobW92ZURpZmZZKTsgXG4gICAgICAgICAgICAgIH1cblx0XHRcdFx0XHRcdH1cblx0XHRcdFx0XHR9IGVsc2Uge1xuXHRcdFx0XHRcdFx0aWYgKCBtb3ZlRGlmZlkgPD0gMCApIHtcblx0XHRcdFx0XHRcdFx0aWYgKCBtb3ZlUmF0aW8gPj0gcmVzaXplRWxlbWVudHMucmF0aW8gKSB7XG5cdFx0XHRcdFx0XHRcdFx0YWRqdXN0VG9ZKG1vdmVEaWZmWSk7XG4gICAgICAgICAgICAgIH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRcdFx0YWRqdXN0VG9YKG1vdmVEaWZmWCk7XG4gICAgICAgICAgICAgIH1cblx0XHRcdFx0XHRcdH0gZWxzZSB7XG5cdFx0XHRcdFx0XHRcdGFkanVzdFRvWShtb3ZlRGlmZlkpO1xuXHRcdFx0XHRcdFx0fVxuXHRcdFx0XHRcdH1cbiAgICAgICAgICAgIGlmKHJlc2l6ZUVsZW1lbnRzLm5ld1dpZHRoID49IDE1ICYmIHJlc2l6ZUVsZW1lbnRzLm5ld0hlaWdodCA+PSAxNSkge1xuICAgICAgICAgICAgICByZXNpemVJbWcuc2V0QXR0cmlidXRlcygge3dpZHRoOiByZXNpemVFbGVtZW50cy5uZXdXaWR0aCwgaGVpZ2h0OiByZXNpemVFbGVtZW50cy5uZXdIZWlnaHR9ICk7XG4gICAgICAgICAgICAgIHJlc2l6ZUVsZW1lbnRzLnJlc2l6ZUJvcmRlci5zZXRTdHlsZSgnd2lkdGgnLCByZXNpemVFbGVtZW50cy5uZXdXaWR0aCArICdweCcpO1xuICAgICAgICAgICAgICByZXNpemVFbGVtZW50cy5yZXNpemVCb3JkZXIuc2V0U3R5bGUoJ2hlaWdodCcsIHJlc2l6ZUVsZW1lbnRzLm5ld0hlaWdodCArICdweCcpO1xuICAgICAgICAgICAgICBcbiAgICAgICAgICAgICAgcmVzaXplRWxlbWVudHMuYm90dG9tUmlnaHRSZXNpemVyLnNldFN0eWxlKCdsZWZ0JywgcmVzaXplRWxlbWVudHMuaW1nUmVjdC5sZWZ0ICsgcmVzaXplRWxlbWVudHMubmV3V2lkdGggLSByZXNpemVyU2l6ZS8yICsgJ3B4Jyk7XG4gICAgICAgICAgICAgIHJlc2l6ZUVsZW1lbnRzLmJvdHRvbVJpZ2h0UmVzaXplci5zZXRTdHlsZSgndG9wJywgcmVzaXplRWxlbWVudHMuaW1nUmVjdC50b3AgKyByZXNpemVFbGVtZW50cy5uZXdIZWlnaHQgLSByZXNpemVyU2l6ZS8yICsgJ3B4Jyk7XG4gICAgICAgICAgICB9XG5cdFx0XHRcdFx0fVxuICAgICAgfSk7XG4gICAgICBcbiAgICAgIGVkaXRvci5vbignZHJhZ3N0YXJ0JywgZnVuY3Rpb24oZXZ0KSB7XG4gICAgICAgIGNsZWFyVG9vbGJhcigpO1xuICAgICAgfSk7XG5cbiAgICAgIGZ1bmN0aW9uIG9uUmVzaXplQWN0aW9uKHJhRXZ0KSB7XG4gICAgICAgIGNsZWFyVG9vbGJhcigpO1xuICAgICAgICB2YXIgaW1nID0gdGFyZ2V0SW1nO1xuICAgICAgICB2YXIgcmVjdCA9IGdldFBvc2l0aW9uKGltZyk7XG4gICAgICAgIHZhciBzZWxlY3Rpb24gPSBlZGl0b3IuZ2V0U2VsZWN0aW9uKCk7XG4gICAgICAgIGlmKHNlbGVjdGlvbi5mYWtlKSB7XG4gICAgICAgICAgc2VsZWN0aW9uLmZha2UoaW1nKTtcbiAgICAgICAgfVxuICAgICAgICBcbiAgICAgICAgdmFyIGJvZHkgPSBnZXRCb2R5KCk7XG4gICAgICAgIGlmKCFib2R5KSB7XG4gICAgICAgICAgcmV0dXJuO1xuICAgICAgICB9XG4gICAgICAgIHZhciBzY3JlZW5PdmVybGF5ID0gQ0tFRElUT1IuZG9tLmVsZW1lbnQuY3JlYXRlRnJvbUh0bWwoJzxkaXYgY2xhc3M9XCJzY3JlZW4tb3ZlcmxheVwiPjxkaXY+Jyk7XG4gICAgICAgIHZhciByZXNpemVCb3JkZXIgPSBDS0VESVRPUi5kb20uZWxlbWVudC5jcmVhdGVGcm9tSHRtbCgnPGRpdiBjbGFzcz1cInJlc2l6ZS1ib3JkZXJcIj48ZGl2PicpO1xuICAgICAgICBzY3JlZW5PdmVybGF5LmFwcGVuZChyZXNpemVCb3JkZXIpO1xuICAgICAgICBib2R5LmFwcGVuZChzY3JlZW5PdmVybGF5KTtcbiAgICAgICAgXG4gICAgICAgIHZhciBib2R5UmVjdCA9IGdldFBvc2l0aW9uKGVkaXRhYmxlLmdldERvY3VtZW50KCkuZ2V0RG9jdW1lbnRFbGVtZW50KCkpO1xuICAgICAgICBcbiAgICAgICAgc2NyZWVuT3ZlcmxheS5zZXRTdHlsZSgnd2lkdGgnLCBib2R5UmVjdC53aWR0aCArICdweCcpO1xuICAgICAgICBzY3JlZW5PdmVybGF5LnNldFN0eWxlKCdoZWlnaHQnLCBib2R5UmVjdC5oZWlnaHQgKyAncHgnKTtcbiAgICAgICAgXG4gICAgICAgIHJlc2l6ZUJvcmRlci5zZXRTdHlsZSgndG9wJywgcmVjdC50b3AgKyAncHgnKTtcbiAgICAgICAgcmVzaXplQm9yZGVyLnNldFN0eWxlKCdsZWZ0JywgcmVjdC5sZWZ0ICsgJ3B4Jyk7XG4gICAgICAgIHJlc2l6ZUJvcmRlci5zZXRTdHlsZSgnd2lkdGgnLCByZWN0LndpZHRoICsgJ3B4Jyk7XG4gICAgICAgIHJlc2l6ZUJvcmRlci5zZXRTdHlsZSgnaGVpZ2h0JywgcmVjdC5oZWlnaHQgKyAncHgnKTtcbiAgICAgICAgXG4gICAgICAgIHJlc2l6ZUVsZW1lbnRzID0ge1xuICAgICAgICAgIHJlc2l6ZUJvcmRlcjogcmVzaXplQm9yZGVyLFxuICAgICAgICAgIGltZ1JlY3Q6IHJlY3QsXG4gICAgICAgICAgbmV3V2lkdGg6IHJlY3Qud2lkdGgsXG4gICAgICAgICAgbmV3SGVpZ2h0OiByZWN0LmhlaWdodFxuICAgICAgICB9XG4gICAgICAgIFxuICAgICAgICBjcmVhdGVSZXNpemVycyhyZWN0LCBzY3JlZW5PdmVybGF5KTtcbiAgICAgICAgcmVzaXplSW1nID0gaW1nO1xuICAgICAgICBcbiAgICAgICAgc2NyZWVuT3ZlcmxheS5vbignY2xpY2snLCBmdW5jdGlvbigpe1xuICAgICAgICAgIGVkaXRvci5yZXNldFVuZG8oKTtcbiAgICAgICAgICBpZihpc1Jlc2l6aW5nKSB7XG4gICAgICAgICAgICBpc1Jlc2l6aW5nID0gZmFsc2U7XG4gICAgICAgICAgICB1cGRhdGVJbWdTcmMoKTtcbiAgICAgICAgICAgIHJldHVybjtcbiAgICAgICAgICB9XG4gICAgICAgICAgXG4gICAgICAgICAgc2NyZWVuT3ZlcmxheS5yZW1vdmUoKTtcbiAgICAgICAgICByZXNpemVJbWcgPSBudWxsO1xuICAgICAgICAgIHJlc2l6ZUVsZW1lbnRzID0gbnVsbDtcbiAgICAgICAgfSk7XG4gICAgICAgIFxuICAgICAgICByZXNpemVCb3JkZXIub24oJ2NsaWNrJywgZnVuY3Rpb24oY2xpY2tFdnQpIHtcbiAgICAgICAgICBjbGlja0V2dC5kYXRhLiQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgY2xpY2tFdnQuZGF0YS4kLnByZXZlbnREZWZhdWx0KCk7XG4gICAgICAgIH0pO1xuICAgICAgICBcbiAgICAgICAgcmVzaXplRWxlbWVudHMuYm90dG9tUmlnaHRSZXNpemVyLm9uKCdtb3VzZWRvd24nLCBmdW5jdGlvbihtZEV2dCkge1xuICAgICAgICAgIFxuICAgICAgICAgIG1kRXZ0LmRhdGEuJC5zdG9wUHJvcGFnYXRpb24oKTtcbiAgICAgICAgICBtZEV2dC5kYXRhLiQucHJldmVudERlZmF1bHQoKTtcbiAgICAgICAgICBpc1Jlc2l6aW5nID0gdHJ1ZTtcbiAgICAgICAgICByZXNpemVFbGVtZW50cy5zdGFydFggPSBtZEV2dC5kYXRhLiQuc2NyZWVuWDtcblx0XHRcdFx0ICByZXNpemVFbGVtZW50cy5zdGFydFkgPSBtZEV2dC5kYXRhLiQuc2NyZWVuWTtcbiAgICAgICAgICByZXNpemVFbGVtZW50cy5zdGFydFdpZHRoID0gcmVzaXplSW1nLiQuY2xpZW50V2lkdGg7XG4gICAgICAgICAgcmVzaXplRWxlbWVudHMuc3RhcnRIZWlnaHQgPSByZXNpemVJbWcuJC5jbGllbnRIZWlnaHQ7XG4gICAgICAgICAgcmVzaXplRWxlbWVudHMucmF0aW8gPSByZXNpemVFbGVtZW50cy5zdGFydFdpZHRoIC8gcmVzaXplRWxlbWVudHMuc3RhcnRIZWlnaHQ7XG4gICAgICAgICAgXG4gICAgICAgIH0pO1xuICAgICAgICBcbiAgICAgICAgcmVzaXplRWxlbWVudHMuYm90dG9tUmlnaHRSZXNpemVyLm9uKCdtb3VzZXVwJywgZnVuY3Rpb24oZXZ0KSB7XG4gICAgICAgICAgZWRpdG9yLnJlc2V0VW5kbygpO1xuICAgICAgICAgIGlzUmVzaXppbmcgPSBmYWxzZTtcbiAgICAgICAgICB1cGRhdGVJbWdTcmMoKTtcbiAgICAgICAgfSk7XG4gICAgICB9XG4gICAgICBcbiAgICAgIGZ1bmN0aW9uIGNyZWF0ZVJlc2l6ZXJzKHJlY3QsIG92ZXJsYXkpIHtcbiAgICAgICAgXG4gICAgICAgIHZhciBib3R0b21SaWdodFJlc2l6ZXIgPSBDS0VESVRPUi5kb20uZWxlbWVudC5jcmVhdGVGcm9tSHRtbCgnPGRpdiBjbGFzcz1cInJlc2l6ZXIgYm90dG9tLXJpZ2h0XCI+PGRpdj4nKTtcbiAgICAgICAgc2V0VXBSZXNpemVyKGJvdHRvbVJpZ2h0UmVzaXplciwgcmVjdC5ib3R0b20sIHJlY3QucmlnaHQsIHJlc2l6ZXJTaXplKTtcbiAgICAgICAgb3ZlcmxheS5hcHBlbmQoYm90dG9tUmlnaHRSZXNpemVyKTtcbiAgICAgICAgcmVzaXplRWxlbWVudHMuYm90dG9tUmlnaHRSZXNpemVyID0gYm90dG9tUmlnaHRSZXNpemVyO1xuICAgICAgfVxuICAgICAgXG4gICAgICBmdW5jdGlvbiBzZXRVcFJlc2l6ZXIoZWxlbWVudCwgdG9wLCBsZWZ0LCBzaXplKSB7XG4gICAgICAgIGVsZW1lbnQuc2V0U3R5bGUoJ3RvcCcsIHRvcCAtIHNpemUvMiArICdweCcpO1xuICAgICAgICBlbGVtZW50LnNldFN0eWxlKCdsZWZ0JywgbGVmdCAtIHNpemUvMiArICdweCcpO1xuICAgICAgICBlbGVtZW50LnNldFN0eWxlKCd3aWR0aCcsIHNpemUgKyAncHgnKTtcbiAgICAgICAgZWxlbWVudC5zZXRTdHlsZSgnaGVpZ2h0Jywgc2l6ZSArICdweCcpO1xuICAgICAgICBlbGVtZW50Lm9uKCdjbGljaycsIGZ1bmN0aW9uKGV2dCkge1xuICAgICAgICAgIGV2dC5kYXRhLiQuc3RvcFByb3BhZ2F0aW9uKCk7XG4gICAgICAgICAgZXZ0LmRhdGEuJC5wcmV2ZW50RGVmYXVsdCgpO1xuICAgICAgICB9KTtcbiAgICAgIH1cbiAgICAgIFxuICAgICAgZnVuY3Rpb24gZ2V0UG9zaXRpb24oZWxlbWVudCkge1xuICAgICAgICB2YXIgYm9keSA9IGdldEJvZHkoKTtcbiAgICAgICAgaWYoIWJvZHkpIHtcbiAgICAgICAgICByZXR1cm47XG4gICAgICAgIH1cbiAgICAgICAgdmFyIHJlc1JlY3QgPSBlbGVtZW50LiQuZ2V0Qm91bmRpbmdDbGllbnRSZWN0KCk7XG4gICAgICAgIFxuICAgICAgICByZXR1cm4ge1xuICAgICAgICAgIHRvcDogcmVzUmVjdC50b3AgKyBib2R5LiQuc2Nyb2xsVG9wLFxuICAgICAgICAgIGJvdHRvbTogcmVzUmVjdC5ib3R0b20gKyBib2R5LiQuc2Nyb2xsVG9wLFxuICAgICAgICAgIGxlZnQ6IHJlc1JlY3QubGVmdCArIGJvZHkuJC5zY3JvbGxMZWZ0LFxuICAgICAgICAgIHJpZ2h0OiByZXNSZWN0LnJpZ2h0ICsgYm9keS4kLnNjcm9sbExlZnQsXG4gICAgICAgICAgd2lkdGg6IHJlc1JlY3Qud2lkdGgsXG4gICAgICAgICAgaGVpZ2h0OiByZXNSZWN0LmhlaWdodFxuICAgICAgICB9O1xuICAgICAgfVxuICAgICAgXG4gICAgICBmdW5jdGlvbiB1cGRhdGVJbWdTcmMoKSB7XG4gICAgICAgIHZhciBpbml0aWFsVXJsID0gcmVzaXplSW1nLmdldEF0dHJpYnV0ZSgnc3JjJyk7XG4gICAgICAgIHZhciBuZXdVcmwgPSBpbml0aWFsVXJsLnN1YnN0cigwLCBpbml0aWFsVXJsLmluZGV4T2YoJy9wcmV2aWV3JykpICsgJy9wcmV2aWV3LycgKyByZXNpemVFbGVtZW50cy5uZXdXaWR0aCArICd4JyArIHJlc2l6ZUVsZW1lbnRzLm5ld0hlaWdodCArICcvJztcbiAgICAgICAgcmVzaXplSW1nLnNldEF0dHJpYnV0ZXMoe1xuICAgICAgICAgICAgICAnZGF0YS1ja2Utc2F2ZWQtc3JjJzogbmV3VXJsLFxuICAgICAgICAgICAgICAnc3JjJzogbmV3VXJsXG4gICAgICAgICAgICB9KTtcbiAgICAgIH1cbiAgICAgIFxuICAgICAgZnVuY3Rpb24gYWRqdXN0VG9YKG1vdmVEaWZmWCkge1xuXHRcdFx0XHRyZXNpemVFbGVtZW50cy5uZXdXaWR0aCA9IHJlc2l6ZUVsZW1lbnRzLnN0YXJ0V2lkdGggKyBtb3ZlRGlmZlg7XG5cdFx0XHRcdHJlc2l6ZUVsZW1lbnRzLm5ld0hlaWdodCA9IE1hdGgucm91bmQoIHJlc2l6ZUVsZW1lbnRzLm5ld1dpZHRoIC8gcmVzaXplRWxlbWVudHMucmF0aW8gKTtcblx0XHRcdH1cblxuXHRcdFx0Ly8gQ2FsY3VsYXRlIGhlaWdodCBmaXJzdCwgYW5kIHRoZW4gYWRqdXN0IHdpZHRoLCBwcmVzZXJ2aW5nIHJhdGlvLlxuXHRcdFx0ZnVuY3Rpb24gYWRqdXN0VG9ZKG1vdmVEaWZmWSkge1xuXHRcdFx0XHRyZXNpemVFbGVtZW50cy5uZXdIZWlnaHQgPSByZXNpemVFbGVtZW50cy5zdGFydEhlaWdodCAtIG1vdmVEaWZmWTtcblx0XHRcdFx0cmVzaXplRWxlbWVudHMubmV3V2lkdGggPSBNYXRoLnJvdW5kKCByZXNpemVFbGVtZW50cy5uZXdIZWlnaHQgKiByZXNpemVFbGVtZW50cy5yYXRpbyApO1xuXHRcdFx0fVxuICAgIH0pOyAgICBcbiAgfVxufSk7XG4iLCJcbm1vZHVsZS5leHBvcnRzID0gXG5cIi50b29scy1jb250YWluZXIge1wiICsgXG5cIiAgcG9zaXRpb246IGFic29sdXRlO1wiICtcblwiICBmbG9hdDogbGVmdDtcIiArXG5cIiAgYm9yZGVyOiAxcHggc29saWQgI2RkZDtcIiArXG5cIiAgYm9yZGVyLXJhZGl1czogNHB4O1wiICtcblwiICBiYWNrZ3JvdW5kOiAjZmZmO1wiICtcblwifVwiICtcblxuXCIuYnV0dG9uIHtcIiArXG5cIiAgYm9yZGVyOiAwcHg7XCIgK1xuXCIgIGJhY2tncm91bmQ6ICNmZmY7XCIgK1xuXCIgIGJvcmRlci1yYWRpdXM6IDJweDtcIiArXG5cIiAgbWFyZ2luOiAycHg7XCIgK1xuXCJ9XCIgK1xuXG5cIi5idXR0b246aG92ZXIge1wiICtcblwiICBiYWNrZ3JvdW5kLWNvbG9yOiAjZTFlZGY3O1wiICtcblwifVwiICtcblxuXCIuaWNvbiB7XCIgK1xuXCIgIHdpZHRoOiAyMnB4O1wiICtcblwiICBoZWlnaHQ6IDIwcHg7XCIgK1xuXCJ9XCIgK1xuXG5cIi5pY29uLXJlc2l6ZSB7XCIgK1xuXCIgIGJhY2tncm91bmQ6IHVybCgnZGF0YTppbWFnZS9zdmcreG1sO2Jhc2U2NCxQSE4yWnlCM2FXUjBhRDBpTVRad2VDSWdhR1ZwWjJoMFBTSXhObkI0SWlCMmFXVjNRbTk0UFNJd0lEQWdNVFlnTVRZaUlIWmxjbk5wYjI0OUlqRXVNU0lnZUcxc2JuTTlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5Mekl3TURBdmMzWm5JaUI0Yld4dWN6cDRiR2x1YXowaWFIUjBjRG92TDNkM2R5NTNNeTV2Y21jdk1UazVPUzk0YkdsdWF5SStEUW9nSUNBZ1BHY2dhV1E5SWxCaFoyVXRNU0lnYzNSeWIydGxQU0p1YjI1bElpQnpkSEp2YTJVdGQybGtkR2c5SWpFaUlHWnBiR3c5SW01dmJtVWlJR1pwYkd3dGNuVnNaVDBpWlhabGJtOWtaQ0krRFFvZ0lDQWdJQ0FnSUR4bklIUnlZVzV6Wm05eWJUMGlkSEpoYm5Oc1lYUmxLQzB4TGpBd01EQXdNQ3dnTFRFdU1EQXdNREF3S1NJK0RRb2dJQ0FnSUNBZ0lDQWdJQ0E4Y0dGMGFDQmtQU0pOTVRFdU5Ea3hNakl3TXl3eExqQXdNRE01TmprMklFTXhNUzR5T1RBM09UUTVMREV1TURBNU56azBORE1nTVRFdU1UTTFPVE01TWl3eExqRTNPVGt5TVRBeElERXhMakUwTlRJNU5qSXNNUzR6T0RBek5EWXpNeUJETVRFdU1UVTBOamt6Tnl3eExqVTRNRGd4TWpFMUlERXhMak15TkRneU1ETXNNUzQzTXpVMk5qYzROU0F4TVM0MU1qVXlORFUyTERFdU56STJNamN3TXpnZ1RERTFMamN5TnpNM01qSXNNUzQzTWpZeU56QXpPQ0JNTVM0M01qVTVOVFEwTXl3eE5TNDNNamMyT0RneElFd3hMamN5TlRrMU5EUXpMREV4TGpVeU5UWXdNaUJETVM0M016QXlPRGcyTVN3eE1TNHpNalV4TXpZeUlERXVOVGN4TXpBeE1qY3NNVEV1TVRVNU1UZ3hPQ0F4TGpNM01EZzNOVGsxTERFeExqRTFORGcwTnpZZ1F6RXVNelUwT1RrM05EY3NNVEV1TVRVME5USXpOU0F4TGpNek9URXhPRGs1TERFeExqRTFOVEl4TWpJZ01TNHpNak16TWpFMU1pd3hNUzR4TlRZNU5UTTVJRU14TGpFek5qTTBORE1zTVRFdU1UYzNOVE14TVNBd0xqazVOakF6TURNNExERXhMak16TnpRNU1EWWdNUzR3TURBd09ERXdNU3d4TVM0MU1qVTJNRElnVERFdU1EQXdNRGd4TURFc01UWXVOakEyTmpjMU5DQkRNUzR3TURBd09ERXdNU3d4Tmk0NE1EY3hOREV6SURFdU1UWXlOVGt5TkRFc01UWXVPVFk1TlRjeE5pQXhMak0yTXpBeE56Y3lMREUyTGprMk9UWXhNaklnVERZdU5EUTBNVE14TmpVc01UWXVPVFk1TmpFeU1pQkROaTQyTkRRMU9UYzBOeXd4Tmk0NU56STBPRGd4SURZdU9EQTVNemMzTWpJc01UWXVPREV5TWpRMU1TQTJMamd4TWpJeE1qWTJMREUyTGpZeE1UZ3hPVGNnUXpZdU9ERTFNRFE0TVN3eE5pNDBNVEV6TlRNNUlEWXVOalUwT0RnMk1EZ3NNVFl1TWpRMk5UYzBNaUEyTGpRMU5ETTNPVGMxTERFMkxqSTBNemN6T0RjZ1F6WXVORFV3T1RjM01qSXNNVFl1TWpRek5qazRNaUEyTGpRME56VXpOREU0TERFMkxqSTBNelk1T0RJZ05pNDBORFF4TXpFMk5Td3hOaTR5TkRNM016ZzNJRXd5TGpJek5qTXpOREU0TERFMkxqSTBNemN6T0RjZ1RERTJMakkwTXpReU1qZ3NNaTR5TXpZMk5UQXhNeUJNTVRZdU1qUXpOREl5T0N3MkxqUTBORFEwTnpVNUlFTXhOaTR5TkRBMU9EY3pMRFl1TmpRME9URXpORElnTVRZdU5EQXdOemc1T1N3MkxqZ3dPVFk1TXpFMklERTJMall3TVRJeE5USXNOaTQ0TVRJMU1qZzJNU0JETVRZdU9EQXhOamd4TERZdU9ERTFNelkwTURVZ01UWXVPVFkyTkRZd09DdzJMalkxTlRFMk1UVXlJREUyTGprMk9USTVOaklzTmk0ME5UUTJPVFUzSUVNeE5pNDVOamt6TXpZM0xEWXVORFV4TWprek1UWWdNVFl1T1RZNU16TTJOeXcyTGpRME56ZzFNREV6SURFMkxqazJPVEk1TmpJc05pNDBORFEwTkRjMU9TQk1NVFl1T1RZNU1qazJNaXd4TGpNMk16TXpNelkzSUVNeE5pNDVOamt5TlRVM0xERXVNVFl5T1RBNE16VWdNVFl1T0RBMk9ESTFNeXd4TGpBd01ETTVOamsySURFMkxqWXdOak0xT1RVc01TNHdNREF6T1RZNU5pQk1NVEV1TlRJMU1qUTFOaXd4TGpBd01ETTVOamsySUVNeE1TNDFNVE01TkRRekxEQXVPVGs1T0Rjd016Z2dNVEV1TlRBeU5UWXlMREF1T1RrNU9EY3dNemdnTVRFdU5Ea3hNakl3TXl3eExqQXdNRE01TmprMklpQnBaRDBpUm1sc2JDMHhJaUJtYVd4c1BTSWpNREF3TURBd0lqNDhMM0JoZEdnK0RRb2dJQ0FnSUNBZ0lDQWdJQ0E4Y21WamRDQnBaRDBpVW1WamRHRnVaMnhsTFRFaUlIZzlJakFpSUhrOUlqQWlJSGRwWkhSb1BTSXhPQ0lnYUdWcFoyaDBQU0l4T0NJK1BDOXlaV04wUGcwS0lDQWdJQ0FnSUNBOEwyYytEUW9nSUNBZ1BDOW5QZzBLUEM5emRtYysnKSAxMDAlIDEwMCUgbm8tcmVwZWF0O1wiICtcblwiICBiYWNrZ3JvdW5kLXBvc2l0aW9uOiBjZW50ZXI7XCIgK1xuXCIgIGJhY2tncm91bmQtc2l6ZTogMTZweCAxNnB4O1wiICtcblwifVwiICtcblxuXCIuaWNvbi11cGxvYWRjYXJlIHtcIiArXG5cIiAgYmFja2dyb3VuZDogdXJsKFxcXCIuLi9pY29ucy91cGxvYWRjYXJlLnBuZ1xcXCIpIDEwMCUgMTAwJSBuby1yZXBlYXQ7XCIgK1xuXCIgIGJhY2tncm91bmQtcG9zaXRpb246IGNlbnRlcjtcIiArXG5cIn1cIiArXG5cblwiLmljb24tY3JvcCB7XCIgK1xuXCIgIGJhY2tncm91bmQ6IHVybCgnZGF0YTppbWFnZS9zdmcreG1sO2Jhc2U2NCxQSE4yWnlCM2FXUjBhRDBpTVRad2VDSWdhR1ZwWjJoMFBTSXhObkI0SWlCMmFXVjNRbTk0UFNJd0lEQWdNVFlnTVRZaUlIWmxjbk5wYjI0OUlqRXVNU0lnZUcxc2JuTTlJbWgwZEhBNkx5OTNkM2N1ZHpNdWIzSm5Mekl3TURBdmMzWm5JaUI0Yld4dWN6cDRiR2x1YXowaWFIUjBjRG92TDNkM2R5NTNNeTV2Y21jdk1UazVPUzk0YkdsdWF5SStEUW9nSUNBZ1BIUnBkR3hsUGxCaFoyVWdNVHd2ZEdsMGJHVStEUW9nSUNBZ1BHUmxjMk0rUTNKbFlYUmxaQ0IzYVhSb0lGTnJaWFJqYUM0OEwyUmxjMk0rRFFvZ0lDQWdQR1JsWm5NK1BDOWtaV1p6UGcwS0lDQWdJRHhuSUdsa1BTSlFZV2RsTFRFaUlITjBjbTlyWlQwaWJtOXVaU0lnYzNSeWIydGxMWGRwWkhSb1BTSXhJaUJtYVd4c1BTSnViMjVsSWlCbWFXeHNMWEoxYkdVOUltVjJaVzV2WkdRaVBnMEtJQ0FnSUNBZ0lDQThaeUIwY21GdWMyWnZjbTA5SW5SeVlXNXpiR0YwWlNndE1TNHdNREF3TURBc0lDMHhMakF3TURBd01Da2lQZzBLSUNBZ0lDQWdJQ0FnSUNBZ1BIQmhkR2dnWkQwaVRURXlMakV5TlRBeU56Y3NNVE11TURNNU9UVTFOaUJNTlM0ME5EWTBNemsyTlN3eE15NHdNems1TlRVMklFd3hNaTR4TWpVd01qYzNMRFl1TXprNE5EUTJNVGNnVERFeUxqRXlOVEF5Tnpjc01UTXVNRE01T1RVMU5pQmFJRTB4TVM0MU1UYzRPRE16TERVdU9UTTJOek0yT1RZZ1REUXVPRFUzTVRVeU5EY3NNVEl1TlRZd05EZzRNeUJNTkM0NE5UY3hOVEkwTnl3MUxqa3pOamN6TmprMklFd3hNUzQxTVRjNE9ETXpMRFV1T1RNMk56TTJPVFlnV2lCTk1UWXVPRGt5T0RVMk9Td3hMall6T1RJNE9UWTRJRU14Tnk0d016VTNNVFEwTERFdU5EazNNakkxTXpFZ01UY3VNRE0xTnpFME5Dd3hMakkwT0RZeE1qWTFJREUyTGpnNU1qZzFOamtzTVM0eE1EWTFORGd5T0NCRE1UWXVOelE1T1RrNU5Dd3dMamsyTkRRNE16a3dOeUF4Tmk0MU1EQXdNemcyTERBdU9UWTBORGd6T1RBM0lERTJMak0xTnpFNE1URXNNUzR4TURZMU5EZ3lPQ0JNTVRJdU9ETTVNekUxTWl3MExqWXlNalkwTVRVeElFdzBMamcxTnpFMU1qUTNMRFF1TmpJeU5qUXhOVEVnVERRdU9EVTNNVFV5TkRjc01pNDJNek0zTkRBeU9TQkROQzQ0TlRjeE5USTBOeXd5TGpJM09EVTNPVE0ySURRdU5UVXpOVGd3TWpnc01TNDVOelkyT1RJMU5pQTBMakU1TmpNNU5qWTNMREV1T1RjMk5qa3lOVFlnUXpNdU9ETTVNalV5T1RNc01TNDVOelkyT1RJMU5pQXpMalV6TlRjeU1EWXNNaTR5TnpnMU56a3pOaUF6TGpVek5UY3lNRFlzTWk0Mk16TTNOREF5T1NCTU15NDFNelUzTWpBMkxEUXVOakl5TmpReE5URWdUREV1TmpZd056RTFPVE1zTkM0Mk1qSTJOREUxTVNCRE1TNHpNRE0xTnpJeE9DdzBMall5TWpZME1UVXhJREVzTkM0NU1qUTFNamd6SURFc05TNHlOemsyT0RreU15QkRNU3cxTGpZek5EZzFNREUzSURFdU16QXpOVGN5TVRnc05TNDVNelkzTXpZNU5pQXhMalkyTURjeE5Ua3pMRFV1T1RNMk56TTJPVFlnVERNdU5UTTFOekl3Tml3MUxqa3pOamN6TmprMklFd3pMalV6TlRjeU1EWXNNVFF1TXpVME1EVXhNU0JNTVRJdU1USTFNREkzTnl3eE5DNHpOVFF3TlRFeElFd3hNaTR4TWpVd01qYzNMREUyTGpNME1qazFNak1nUXpFeUxqRXlOVEF5Tnpjc01UWXVOams0TVRFek1pQXhNaTQwTWpnMU5pd3hOeUF4TWk0M09EVTNNRE00TERFM0lFTXhNeTR4TkRJNE5EYzFMREUzSURFekxqUTBOalF4T1Rjc01UWXVOams0TVRFek1pQXhNeTQwTkRZME1UazNMREUyTGpNME1qazFNak1nVERFekxqUTBOalF4T1Rjc01UUXVNek0yTWpreklFd3hOUzR6TWpFME1qUTBMREUwTGpNek5qSTVNeUJETVRVdU5qYzROVFk0TVN3eE5DNHpNell5T1RNZ01UVXVPVGd5TVRnd01pd3hOQzR3TXpRME1EWXlJREUxTGprNE1qRTRNRElzTVRNdU5qYzVNalExTXlCRE1UVXVPVGd5TVRnd01pd3hNeTR6TWpRd09EUTBJREUxTGpZM09EVTJPREVzTVRNdU1ESXlNVGszTmlBeE5TNHpNakUwTWpRMExERXpMakF5TWpFNU56WWdUREV6TGpRME5qUXhPVGNzTVRNdU1ESXlNVGszTmlCTU1UTXVORFEyTkRFNU55dzFMakE0TkRNMU1EY3lJRXd4Tmk0NE9USTROVFk1TERFdU5qTTVNamc1TmpnZ1dpSWdhV1E5SWtacGJHd3RNU0lnWm1sc2JEMGlJekF3TURBd01DSStQQzl3WVhSb1BnMEtJQ0FnSUNBZ0lDQWdJQ0FnUEhKbFkzUWdhV1E5SWxKbFkzUmhibWRzWlMweElpQjRQU0l3SWlCNVBTSXdJaUIzYVdSMGFEMGlNVGdpSUdobGFXZG9kRDBpTVRnaVBqd3ZjbVZqZEQ0TkNpQWdJQ0FnSUNBZ1BDOW5QZzBLSUNBZ0lEd3ZaejROQ2p3dmMzWm5QZz09JykgMTAwJSAxMDAlIG5vLXJlcGVhdDtcIiArXG5cIiAgYmFja2dyb3VuZC1wb3NpdGlvbjogY2VudGVyO1wiICtcblwiICBiYWNrZ3JvdW5kLXNpemU6IDE2cHggMTZweDtcIiArXG5cIn1cIiArIFxuIFxuXCIuc2NyZWVuLW92ZXJsYXkge1wiICtcblwiICBwb3NpdGlvbjogYWJzb2x1dGU7XCIgK1xuXCIgIHRvcDogMDtcIiArXG5cIiAgbGVmdDogMDtcIiArXG5cIiAgbWluLWhlaWdodDogMTAwJTtcIiArXG5cIiAgbWluLXdpZHRoOiAxMDAlO1wiICtcblwiICB6LWluZGV4OiAxMDtcIiArXG5cIiAgY3Vyc29yOiBkZWZhdWx0O1wiICtcblwifVwiICtcblxuXCIucmVzaXplLWJvcmRlciB7XCIgK1xuXCIgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcIiArXG5cIiAgYm9yZGVyOiAxcHggZGFzaGVkICNiYmJiYmI7XCIgK1xuXCIgIHotaW5kZXg6IDExO1wiICtcblwiICBiYWNrZ3JvdW5kLWNvbG9yOiByZ2JhKDEyOCwgMTI4LCAxMjgsIDAuMTUpO1wiICtcblwiICBjdXJzb3I6IGRlZmF1bHQ7XCIgK1xuXCJ9XCIgK1xuXG5cIi5yZXNpemVyIHtcIiArXG5cIiAgYmFja2dyb3VuZC1jb2xvcjogd2hpdGU7XCIgK1xuXCIgIGJvcmRlcjogMXB4IHNvbGlkICNiYmJiYmI7XCIgK1xuXCIgIHBvc2l0aW9uOiBhYnNvbHV0ZTtcIiArXG5cIiAgei1pbmRleDogMTI7XCIgK1xuXCJ9XCIgK1xuXG5cIi50b3AtbGVmdCB7XCIgK1xuXCIgIGN1cnNvcjogbnctcmVzaXplO1wiICtcblwifVwiICtcblxuXCIudG9wLXJpZ2h0IHtcIiArXG5cIiAgY3Vyc29yOiBuZS1yZXNpemU7XCIgK1xuXCJ9XCIgK1xuXG5cIi5ib3R0b20tbGVmdCB7XCIgK1xuXCIgIGN1cnNvcjogc3ctcmVzaXplO1wiICtcblwifVwiICtcblxuXCIuYm90dG9tLXJpZ2h0IHtcIiArXG5cIiAgY3Vyc29yOiBzZS1yZXNpemU7XCIgK1xuXCJ9XCI7IiwiJ3VzZSBzdHJpY3QnXG5cbnZhciBnZXRCb2R5ID0gcmVxdWlyZSgnLi9nZXQtYm9keScpO1xudmFyIGZpbmRPbmUgPSByZXF1aXJlKCcuL2ZpbmQtb25lJyk7XG5cbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24oKSB7ICAgICAgICBcbiAgdmFyIGJvZHkgPSBnZXRCb2R5KCk7XG4gIFxuICBpZighYm9keSkge1xuICAgIHJldHVybjtcbiAgfVxuICAgIFxuICB2YXIgdG9vbHMgPSBib2R5LmZpbmRPbmUgPyBib2R5LmZpbmRPbmUoJ2Rpdi50b29scy1jb250YWluZXInKSA6IGZpbmRPbmUuYmluZChib2R5KSgnZGl2LnRvb2xzLWNvbnRhaW5lcicpOyBcbiAgXG4gIGlmKHRvb2xzKSB7XG4gICAgdG9vbHMuaGlkZSgpO1xuICB9XG59IiwibW9kdWxlLmV4cG9ydHMgPSBmdW5jdGlvbiggc2VsZWN0b3IgKSB7XG4gIHZhciByZW1vdmVUbXBJZCA9IGNyZWF0ZVRtcElkKCB0aGlzICksXG4gICAgZm91bmQgPSB0aGlzLiQucXVlcnlTZWxlY3RvciggZ2V0Q29udGV4dHVhbGl6ZWRTZWxlY3RvciggdGhpcywgc2VsZWN0b3IgKSApO1xuXG4gIHJlbW92ZVRtcElkKCk7XG5cbiAgcmV0dXJuIGZvdW5kID8gbmV3IENLRURJVE9SLmRvbS5lbGVtZW50KCBmb3VuZCApIDogbnVsbDtcbn1cblxuXG5mdW5jdGlvbiBnZXRDb250ZXh0dWFsaXplZFNlbGVjdG9yKCBlbGVtZW50LCBzZWxlY3RvciApIHtcblx0XHRyZXR1cm4gJyMnICsgZWxlbWVudC4kLmlkICsgJyAnICsgc2VsZWN0b3Iuc3BsaXQoIC8sXFxzKi8gKS5qb2luKCAnLCAjJyArIGVsZW1lbnQuJC5pZCArICcgJyApO1xuXHR9XG5cbmZ1bmN0aW9uIGNyZWF0ZVRtcElkKCBlbGVtZW50ICkge1xuXHRcdHZhciBoYWRJZCA9IHRydWU7XG5cblx0XHRpZiAoICFlbGVtZW50LiQuaWQgKSB7XG5cdFx0XHRlbGVtZW50LiQuaWQgPSAnY2tlX3RtcF8nICsgQ0tFRElUT1IudG9vbHMuZ2V0TmV4dE51bWJlcigpO1xuXHRcdFx0aGFkSWQgPSBmYWxzZTtcblx0XHR9XG5cblx0XHRyZXR1cm4gZnVuY3Rpb24oKSB7XG5cdFx0XHRpZiAoICFoYWRJZCApXG5cdFx0XHRcdGVsZW1lbnQucmVtb3ZlQXR0cmlidXRlKCAnaWQnICk7XG5cdFx0fTtcblx0fSIsIid1c2Ugc3RyaWN0J1xuXG52YXIgZWRpdG9yID0gcmVxdWlyZSgnLi4vZ2xvYmFscy9lZGl0b3InKS5lZGl0b3I7XG5cbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24gZ2V0Qm9keSgpIHtcbiAgdHJ5IHtcbiAgICB2YXIgZWRpdG9yID0gQ0tFRElUT1IuY3VycmVudEluc3RhbmNlO1xuICAgIHZhciBlZGl0YWJsZSA9IGVkaXRvci5lZGl0YWJsZSgpO1xuICAgIHZhciBkb2MgPSBlZGl0YWJsZS5nZXREb2N1bWVudCgpO1xuICAgIHJldHVybiBkb2MuZ2V0Qm9keSgpO1xuICB9IGNhdGNoIChleCkge1xuICAgIHJldHVybiBudWxsOyAgICAgIFxuICB9XG59IiwiJ3VzZSBzdHJpY3QnXG5cbm1vZHVsZS5leHBvcnRzID0gZnVuY3Rpb24gKGVkaXRvciwgbmVlZGxlKSB7XG4gIHZhciBzZWwgPSBlZGl0b3IuZ2V0U2VsZWN0aW9uKCk7XG4gIHZhciBlbGVtZW50ID0gc2VsLmdldFNlbGVjdGVkRWxlbWVudCgpO1xuICBpZiAoZWxlbWVudCAmJiBlbGVtZW50LmlzKG5lZWRsZSkpIHtcbiAgICByZXR1cm4gZWxlbWVudDtcbiAgfVxuXG4gIHZhciB3aWRnZXQ7XG4gIGlmIChlZGl0b3Iud2lkZ2V0cyAmJiAod2lkZ2V0ID0gZWRpdG9yLndpZGdldHMuc2VsZWN0ZWRbMF0pKSB7XG4gICAgaWYgKHdpZGdldC5lbGVtZW50LmlzKG5lZWRsZSkpIHtcbiAgICAgIHJldHVybiB3aWRnZXQuZWxlbWVudDtcbiAgICB9XG4gIH1cblxuICB2YXIgcmFuZ2UgPSBzZWwuZ2V0UmFuZ2VzKClbMF07XG4gIGlmIChyYW5nZSkge1xuICAgIHJhbmdlLnNocmluayhDS0VESVRPUi5TSFJJTktfVEVYVCk7XG4gICAgcmV0dXJuIGVkaXRvci5lbGVtZW50UGF0aChyYW5nZS5nZXRDb21tb25BbmNlc3RvcigpKS5jb250YWlucyhuZWVkbGUsIDEpO1xuICB9XG59Il19
