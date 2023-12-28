<div class="row">
  <!-- File -->
  <div class="form-group col-12">
    <label for="file" class="form-label">File</label>
    <input class="form-control" type="file" id="formFile" name="file" />
    <p id="file_error" class="text-danger"><?php if (has_error('file')) echo error('file') ?></p>
  </div>
</div>

<div class="row">
  <!-- Preview File -->
  <div class="form-group col-12">
    <label for="file" class="form-label">Preview File</label>
  </div>
  <div class="form-group col-12">
    <?php if (isset($gallery->file) && !empty($gallery->file)) : ?>
      <img id="filePreview" src="<?= base_url($gallery->file); ?>" style="height: 500px; width: 100%; margin-bottom: 10px; padding: 30px; border: var(--bs-border-width) dashed #dfe5ef; border-radius: 10px;" />
      <a style="margin-left: 20px;" href=" <?php echo base_url($gallery->file) ?>">Gallery File</a>
    <?php else : ?>
      <!-- Display a placeholder or leave this blank -->
      <img id="filePreview" style="height: 500px; width: 100%; margin-bottom: 10px; padding: 30px; border: var(--bs-border-width) dashed #dfe5ef; border-radius: 10px; display: none;" />
    <?php endif; ?>
  </div>
</div>