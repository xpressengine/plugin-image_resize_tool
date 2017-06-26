<style>
    #container {margin: 0 auto; width: 800px; padding-top:15px}
    #imageWrapper { width: 100%; height: 800px;}
    img {max-width: 100%;}
    .infoArea { position:relative; width: 100%; height: 40px; }
    .image_size { position: absolute; bottom: 0; right: 0; }
</style>

<div id="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div id="imageWrapper"></div>
            <div class="infoArea">
                <div class="image_size"></div>
            </div>
        </div>
        <div class="panel-footer clearfix text-center">
            <div class="row">
                <input type="file" id="imageFile" accept="image/*" class="hide" />
                <button type="button" id="btnSelectImage" class="btn btn-default"><i class="xi-image-o"></i> 파일 선택</button>
                &nbsp;
                <button type="button" id="btnToggleResize" class="btn btn-default" disabled="disabled"><i class="xi-image-o"></i> Resize</button>
                &nbsp;
                <button type="button" id="btnToggleCrop" class="btn btn-default" disabled="disabled"><i class="xi-image-o"></i> Crop</button>
                <button type="button" id="btnCropImage" class="btn btn-default" disabled="disabled"><i class="xi-cut"></i> 자르기</button>
                &nbsp;
                <button type="button" id="btnClose" class="btn btn-default"><i class="xi-close"></i> 닫기</button>
                <button type="button" id="btnResetImage" class="btn btn-default" disabled="disabled"><i class="xi-redo"></i> 리셋</button>
                <button type="button" id="btnUpload" class="btn btn-default" disabled="disabled"><i class="xi-upload"></i> 업로드</button>
                <button type="button" id="btnAppendToEditor" class="btn btn-default" disabled="disabled"><i class="xi-log-in"></i> 에디터에 넣기</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    var ImageResizer = (function () {
        var _this;
        var _result;
        var _size = {
            width: 0,
            height: 0
        };

        var _$cropper = null;

        var _resizeMode = false;
        var _cropMode = false;

        return {
            init: function () {
                _this = this;
                this.cache();
                this.bindEvents();

                return this;
            },
            cache: function () {
                this.$imageFile = $('#imageFile');
                this.$btnSelectImage = $('#btnSelectImage');
                this.$btnResetImage = $('#btnResetImage');
                this.$btnCropImage = $('#btnCropImage');
                this.$btnClose = $('#btnClose');
                this.$btnUpload = $('#btnUpload');
                this.$btnAppendToEditor = $('#btnAppendToEditor');
                this.$btnToggleResize = $('#btnToggleResize');
                this.$btnToggleCrop = $('#btnToggleCrop');

            },
            bindEvents: function () {
                this.$imageFile.on('change', this.changeFile);
                this.$btnSelectImage.on('click', function () {
                    _this.$imageFile.trigger('click');
                });
                this.$btnToggleResize.on('click', this.setResizeMode);
                this.$btnToggleCrop.on('click', this.setCropMode);
                this.$btnCropImage.on('click', this.cropImage);
                this.$btnResetImage.on('click', this.reset);
                this.$btnClose.on('click', function () {
                    //TODO::confirm
                    self.close();
                });
            },
            cropImage: function () {
                var cropData = _$cropper.cropper('getCropBoxData');

                console.log(cropData);
                /**
                 left: 257.7337031900139
                 top: 71
                 width: 216.53259361997226
                 height: 666
                 * */

                //TODO:: image to canvas
                //$('.cropper-canvas > img')
            },
            setCropMode: function () {
                if(_cropMode) {
                    _cropMode = false;
//                    $('img').cropper('destroy');
                    _$cropper.cropper('destroy');

                    var canvas = $('<canvas id="targetCanvas" />')[0];
                    var ctx = canvas.getContext('2d');
                    var imgWidth = $('#targetImage').width();
                    var imgHeight = $('#targetImage').height();
                    canvas.width = imgWidth;
                    canvas.height = imgHeight;

                    ctx.drawImage($('#targetImage')[0], 0, 0, imgWidth, imgHeight);

                    $('#imageWrapper').html(canvas);

                    _this.setButtonDisabledStatus({
                        select: false,
                        toggleResize: false,
                        toggleCrop: false,
                        crop: true,
                        close: false,
                        reset: false,
                        upload: false,
                        append: true
                    });

                } else {
                    _cropMode = true;

                    var src = $('#targetCanvas')[0].toDataURL();
                    var width = $('#targetCanvas').width();
                    var height = $('#targetCanvas').height();
                    var $img = $('<img id="targetImage" src="' + src + '" />').css({
                        width: width, height: height
                    });

                    $('#imageWrapper').html($img);

                    _$cropper = $('#targetImage').cropper({
                        strict: true,
                    });

                    _this.setButtonDisabledStatus({
                        select: true,
                        toggleResize: true,
                        toggleCrop: false,
                        crop: false,
                        close: false,
                        reset: false,
                        upload: true,
                        append: true
                    });
                }
            },
            reset: function () {
                if(_result) {
                    var $image = $('<img src="' + _result + '">').css({width: _size.width, height: _size.height});
                    _resizeMode = false;
                    _cropMode = false;

                    $('#imageWrapper').html($image);
                }
            },
            setResizeMode: function () {
                var $this = $(this);

                if(_resizeMode) {
                    _resizeMode = false;

                    $('#targetImage').resizable("destroy");

                    var canvas = $('<canvas id="targetCanvas" />')[0];
                    var ctx = canvas.getContext('2d');
                    var imgWidth = $('#targetImage').width();
                    var imgHeight = $('#targetImage').height();
                    canvas.width = imgWidth;
                    canvas.height = imgHeight;

                    ctx.drawImage($('#targetImage')[0], 0, 0, imgWidth, imgHeight);

                    $('#imageWrapper').html(canvas);

                    _this.setButtonDisabledStatus({
                        select: false,
                        toggleResize: false,
                        toggleCrop: false,
                        crop: true,
                        close: false,
                        reset: false,
                        upload: false,
                        append: true
                    });
                } else {
                    _resizeMode = true;

                    var src = $('#targetCanvas')[0].toDataURL();
                    var width = $('#targetCanvas').width();
                    var height = $('#targetCanvas').height();
                    var $img = $('<img id="targetImage" src="' + src + '" />').css({
                        width: width, height: height
                    });

                    $('#imageWrapper').html($img);

                    var options = {
                        containment: "#imageWrapper",
                        resize: function (e, ui) {
                            var width = ui.size.width;
                            var height = ui.size.height;

                            $('.image_size').text(width + ' x ' + height);
                        }
                    };

                    $('#targetImage').resizable(options);

                    _this.setButtonDisabledStatus({
                        select: true,
                        toggleResize: false,
                        toggleCrop: true,
                        crop: true,
                        close: true,
                        reset: true,
                        upload: true,
                        append: true
                    });
                }
            },
            changeFile: function (e) {
                e.preventDefault();
                var target = e.target;
                var file = target && target.files && target.files[0];

                if(file) {
                    var reader = new FileReader();

                    reader.onload = function (e) {
                        var result = e.target.result;
                        var img = new Image();

                        img.src = _result =  result;
                        img.onload = function () {
                            var imgWidth = this.width;
                            var imgHeight = this.height;

                            _size.width = imgWidth;
                            _size.height = imgHeight;

                            $('.image_size').text(imgWidth + ' x ' + imgHeight);

                            var $image = $('<img id="targetImage" src="' + result + '" />').css({
                                width: imgWidth,
                                height: imgHeight
                            });

                            $('#imageWrapper').html($image);

                            var canvas = $('<canvas id="targetCanvas" />')[0];
                            var ctx = canvas.getContext('2d');
                            canvas.width = imgWidth;
                            canvas.height = imgHeight;

                            ctx.drawImage($('#targetImage')[0], 0, 0, imgWidth, imgHeight);

                            $('#imageWrapper').html(canvas);

                            _this.setButtonDisabledStatus({
                                select: false,
                                toggleResize: false,
                                toggleCrop: false,
                                crop: true,
                                close: false,
                                reset: false,
                                upload: false,
                                append: true
                            });

                        }
                    }

                    reader.readAsDataURL(target.files[0]);
                }
            },
            /**
             * @param {object} obj
             * <pre>
             *     select
             *     reset
             *     crop
             *     close
             *     upload
             *     append
             *
             *     true, false
             * </pre>
             * @description 버튼 상태 변경
             * */
            setButtonDisabledStatus: function (obj) {
                for(var command in obj) {
                    //var command = obj[prop].command;
                    var status = obj[command];
                    var $target = $();

                    switch(command) {
                        case 'toggleResize':
                            $target = _this.$btnToggleResize;
                            break;
                        case 'toggleCrop':
                            $target = _this.$btnToggleCrop;
                            break;
                        case 'select':
                            $target = _this.$btnSelectImage;
                            break;
                        case 'reset':
                            $target = _this.$btnResetImage;
                            break;
                        case 'crop':
                            $target = _this.$btnCropImage;
                            break;
                        case 'close':
                            $target = _this.$btnClose;
                            break;
                        case 'upload':
                            $target = _this.$btnUpload;
                            break;
                        case 'append':
                            $target = _this.$btnAppendToEditor;
                            break;
                    }

                    $target.attr('disabled', status);
                }

            },
            getEmptyTemplate: function () {
                return [
                    ''
                ];
            }
        }
    })().init();

</script>