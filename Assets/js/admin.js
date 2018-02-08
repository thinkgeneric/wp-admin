(function($){

  const initMediaUploader = function(optionKey) {
    let file_frame, image_data;

    if (undefined !== file_frame) {
      file_frame.open();
      return;
    }

    file_frame = wp.media.frames.file_frame = wp.media({
      frame: 'post',
      state: 'insert',
      multiple: false,
    });

    file_frame.on('insert', () => {
      // Read the JSON data returned from the media uploader
      const json = file_frame.state().get('selection').first().toJSON();
      // First, ensure that we have the URL of an image to display
      if (0 > json.url.trim().length) {
        return;
      }

      document.querySelector('[data-name="image"]').setAttribute('src', json.url);
      document.querySelector('.gearhead-file-uploader-button').classList.add('hidden');
      document.querySelector('.image-wrap').classList.remove('hidden');
      document.querySelector('input#' + optionKey).setAttribute('value', json.id);
    });

    file_frame.open();
  };

  /**
   * Display the image
   */
  const renderUploadedImage = function() {
    if ('' !== document.querySelector('.gearhead-file-uploader input[type="hidden"]').value.trim()) {
      document.querySelector('.image-wrap').classList.remove('hidden');
      document.querySelector('.gearhead-file-uploader-button').classList.add('hidden');
    }
  };

  /**
   * Reset the media uploader form
   * @param element
   */
  const resetImageForm = function(element) {
    element.querySelector('.image-wrap').classList.add('hidden');
    element.querySelector('.gearhead-file-uploader-button').classList.remove('hidden');
    element.querySelector('input').setAttribute('value', '');
    element.querySelector('[data-name="image"]').setAttribute('src', '');
  };

  $(function () {
    renderUploadedImage();

    // event listener for adding image
    $('.gearhead-file-uploader').on('click', 'a[data-name="add"]', function(event) {
      event.preventDefault();
      initMediaUploader(event.currentTarget.dataset.key);
    });

    // event listener for removing image
    $('.gearhead-file-uploader').on('click', 'a[data-name="remove"]', function (event) {
      event.preventDefault();
      resetImageForm(event.delegateTarget);
    });
  });
})(jQuery);