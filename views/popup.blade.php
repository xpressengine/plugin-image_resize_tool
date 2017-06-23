<style>
    #container {margin: 0 auto; width: 800px; padding-top:15px}
    #imageWrapper { width: 100%; height: 800px;}
</style>

<div id="container">
    <div class="panel panel-default">
        <div class="panel-body">
            <div id="imageWrapper"></div>
        </div>
        <div class="panel-footer clearfix text-center">
            <input type="file" id="imageFile" accept="image/*" class="hide" />
            <button type="button" id="btnSelectImage" class="btn btn-default"><i class="xi-image-o"></i> 파일 선택</button>
            <button type="button" id="btnResetImage" class="btn btn-default"><i class="xi-redo"></i> 리셋</button>
            <button type="button" id="btnCropImage" class="btn btn-default"><i class="xi-cut"></i> 자르기</button>
            <button type="button" id="btnClose" class="btn btn-default"><i class="xi-close"></i> 닫기</button>
            <button type="button" id="btnUpload" class="btn btn-default"><i class="xi-upload"></i> 업로드</button>
            <button type="button" id="btnAppendToEditor" class="btn btn-default"><i class="xi-log-in"></i> 에디터에 넣기</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    var ImageResizer = (function () {
        var _this;

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
            },
            bindEvents: function () {
                this.$btnSelectImage.on('click', function () {
                    _this.$imageFile.trigger('click');
                });

                this.$imageFile.on('change', this.dropChagneHandler);
            },
            dropChangeHandler: function (e) {
                e.preventDefault()
                e = e.originalEvent
                var target = e.dataTransfer || e.target
                var file = target && target.files && target.files[0]
                var options = {
                    maxWidth: result.width(),
                    canvas: true,
                    pixelRatio: window.devicePixelRatio,
                    downsamplingRatio: 0.5,
                    orientation: true
                }
                if (!file) {
                    return
                }
            },
            displayImage: function (file, options) {
                currentFile = file
                if (!loadImage(file, updateResults, options)) {
                    result.children().replaceWith(
                            $('<span>' +
                                    'Your browser does not support the URL or FileReader API.' +
                                    '</span>')
                    )
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