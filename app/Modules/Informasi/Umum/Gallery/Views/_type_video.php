<div class="row">
  <!-- Title -->
  <div class="form-group col-12 col-lg-6">
    <label for="file" class="form-label">Video URL</label>
    <input type="text" hx-target="#file_error" hx-post="<?= site_url($adminLink . 'validateField/file') ?>" name="file" class="form-control" autocomplete="file" value="<?= old('file', $gallery->file ?? '') ?>">
    <p id="file_error" class="text-danger"><?php if (has_error('file')) echo error('file') ?></p>
  </div>
</div>
