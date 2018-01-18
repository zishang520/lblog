(function(factory) {
    if (typeof define === 'function' && define.amd) {
        define(['jquery'], factory);
    } else if (typeof exports === 'object') {
        // Node / CommonJS
        factory(require('jquery'));
    } else {
        factory(jQuery);
    }
})(function($) {

    'use strict';

    var console = window.console || { log: function() {} };

    function CropAvatar($element) {
        this.$container = $element;

        this.$avatarView = this.$container.find('.picture');
        this.$btn = this.$avatarView.find('.btn');
        this.$avatar = this.$avatarView.find('img');
        this.$avatarModal = $('#avatar-modal');
        this.$loading = $('.alert-laoding');
        this.$picturefile = this.$avatarView.find('#picturefile');
        this.$avatarForm = this.$avatarModal.find('.avatar-form');
        this.$avatarUpload = this.$avatarForm.find('.avatar-upload');
        this.$avatarSrc = this.$avatarForm.find('.avatar-src');
        this.$avatarData = this.$avatarForm.find('.avatar-data');
        this.$avatarInput = this.$avatarForm.find('.avatar-input');
        this.$avatarSave = this.$avatarForm.find('.avatar-save');
        this.$avatarBtns = this.$avatarForm.find('.avatar-btns');

        this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');
        this.$avatarPreview = this.$avatarModal.find('.avatar-preview');

        this.init();
    }

    CropAvatar.prototype = {
        constructor: CropAvatar,
        support: {
            fileList: !!$('<input type="file">').prop('files'),
            blobURLs: !!window.URL && URL.createObjectURL,
            formData: !!window.FormData
        },

        init: function() {
            this.support.datauri = this.support.fileList && this.support.blobURLs;

            if (!this.support.formData) {
                this.initIframe();
            }

            this.initTooltip();
            this.initModal();
            this.addListener();
        },

        addListener: function() {
            this.$avatarView.on('click', $.proxy(this.click, this));
            this.$avatarInput.on('change', $.proxy(this.change, this));
            this.$avatarForm.on('submit', $.proxy(this.submit, this));
            this.$avatarBtns.on('click', $.proxy(this.rotate, this));
        },

        initTooltip: function() {
            this.$avatarView.tooltip({
                placement: 'right'
            });
        },

        initModal: function() {
            this.$avatarModal.modal({
                show: false
            });
        },

        initPreview: function() {
            var inimg = this.$avatarWrapper.find('img.cropper-hidden');
            // this.$avatar.attr('src');//默认获取图片
            var url = (inimg.length == 1) ? inimg.attr('src') : '';
            url == '' || this.$avatarPreview.empty().html('<img src="' + url + '">');
        },

        initIframe: function() {
            var target = 'upload-iframe-' + (new Date()).getTime(),
                $iframe = $('<iframe>').attr({
                    name: target,
                    src: ''
                }),
                _this = this;

            // Ready ifrmae
            $iframe.one('load', function() {

                // respond response
                $iframe.on('load', function() {
                    var data;

                    try {
                        data = $(this).contents().find('body').text();
                    } catch (e) {
                        console.log(e.message);
                    }

                    if (data) {
                        try {
                            data = $.parseJSON(data);
                        } catch (e) {
                            console.log(e.message);
                        }

                        _this.submitDone(data);
                    } else {
                        _this.submitFail('Image upload failed!');
                    }

                    _this.submitEnd();

                });
            });

            this.$iframe = $iframe;
            this.$avatarForm.attr('target', target).after($iframe.hide());
        },

        click: function() {
            this.$avatarModal.modal('show');
            this.initPreview();
        },

        change: function() {
            var files,
                file;

            if (this.support.datauri) {
                files = this.$avatarInput.prop('files');

                if (files.length > 0) {
                    file = files[0];

                    if (this.isImageFile(file)) {
                        if (this.url) {
                            URL.revokeObjectURL(this.url); // Revoke the old one
                        }

                        this.url = URL.createObjectURL(file);
                        this.startCropper();
                    }
                }
            } else {
                file = this.$avatarInput.val();

                if (this.isImageFile(file)) {
                    this.syncUpload();
                }
            }
        },

        submit: function() {
            var files,
                file;
            if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
                this.alert('请选择你要上传的图片');
                return false;
            }
            files = this.$avatarInput.prop('files');
            if (files.length > 0) {
                file = files[0];
            }
            if (!this.isImageFile(file)) {
                this.alert('图片格式不正确');
                return false;
            }
            if (parseInt(file.size) >= 2097152) {
                this.alert('图片不能超过2MB,当前大小' + this.SizeConvert(parseInt(file.size)));
                return false;
            }
            if (this.support.formData) {
                this.ajaxUpload();
                return false;
            }
            return false;
        },

        rotate: function(e) {
            var data;

            if (this.active) {
                data = $(e.target).data();

                if (data.method) {
                    this.$img.cropper(data.method, data.option);
                }
            }
        },

        isImageFile: function(file) {
            if (file.type) {
                return /^image\/\w+$/.test(file.type);
            } else {
                return /\.(jpg|jpeg|png|gif)$/.test(file);
            }
        },

        startCropper: function() {
            var _this = this;

            if (this.active) {
                this.$img.cropper('replace', this.url);
            } else {
                this.$img = $('<img src="' + this.url + '">');
                this.$avatarWrapper.empty().html(this.$img);
                this.$img.cropper({
                    preview: this.$avatarPreview.selector,
                    strict: false,
                    aspectRatio: 1 / 1,
                    autoCropArea: 1,
                    viewMode: 1,
                    crop: function(data) {
                        var json = [
                            '{"x":' + data.x,
                            '"y":' + data.y,
                            '"height":' + data.height,
                            '"width":' + data.width,
                            '"rotate":' + data.rotate + '}'
                        ].join();

                        _this.$avatarData.val(json);
                    }
                });

                this.active = true;
            }
        },

        stopCropper: function() {
            if (this.active) {
                this.$img.cropper('destroy');
                this.$img.remove();
                this.active = false;
            }
        },

        ajaxUpload: function() {
            var url = this.$avatarForm.attr('action'),
                data = new FormData(this.$avatarForm[0]),
                _this = this;

            $.ajax(url, {
                type: 'post',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,

                beforeSend: function() {
                    _this.submitStart();
                },

                success: function(data) {
                    _this.submitDone(data);
                    _this.$avatarSave.button('reset');
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    _this.submitFail(textStatus || errorThrown);
                },
                // complete: function() {
                //     _this.submitEnd();
                // }
            });
        },

        syncUpload: function() {
            this.$avatarSave.click();
        },

        submitStart: function() {
            this.$avatarSave.button('loading');
            // this.$loading.fadeIn();
        },

        submitDone: function(data) {
            if ($.isPlainObject(data)) {
                if (data.status) {
                    this.path = data.url;
                    if (this.support.datauri || this.uploaded) {
                        this.uploaded = false;
                        this.cropDone();
                    } else {
                        this.uploaded = true;
                        this.$avatarSrc.val(this.path);
                        this.startCropper();
                    }
                    this.$avatarInput.val('');
                } else if (data.message) {
                    this.alert(data.message);
                }
            } else {
                this.alert('Failed to response');
            }
        },

        submitFail: function(msg) {
            this.alert(msg);
        },

        submitEnd: function() {
            this.$avatarSave.button('reset');
            // this.$loading.fadeOut();
        },

        cropDone: function() {
            this.$avatarForm.get(0).reset();
            console.log(this.path);
            this.$avatar.attr('src', this.path + '?' + Math.random());
            // this.$avatar.html('<img src="' + this.url + '" style="box-shadow: #BDC3C7 0px 0px 5px;margin: 5px;/display: block;max-width: 230px;">');
            this.$picturefile.val(this.url);
            this.stopCropper();
            this.$avatarModal.modal('hide');
        },

        alert: function(msg) {
            var _this = this;
            _this.submitStart();
            window.ShowMsg('<span class="text text-warning">' + msg + '</span>', true, function() {
                _this.submitEnd();
            });
        },

        SizeConvert: function(byte) {
            var size, bytesize, bytes = parseInt(byte);
            if (bytes >= 1073741824) {
                bytesize = parseInt((bytes / 1073741824) * 1000) / 1000;
                size = bytesize + " GB";
            } else if (bytes >= 1048576) {
                bytesize = parseInt((bytes / 1048576) * 1000) / 1000;
                size = bytesize + " MB";
            } else if (bytes >= 1024) {
                bytesize = parseInt((bytes / 1024) * 1000) / 1000;
                size = bytesize + " KB";
            } else {
                size = bytes + " Byte";
            }
            return size;
        }
    };

    $(function() {
        return new CropAvatar($('#crop-avatar'));
    });

});
