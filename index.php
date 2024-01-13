<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form with File Upload</title>
  <style>
    .error {
      color: red;
    }
  </style>
</head>
<body>


<form id="myForm" action="process_form.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
 
<label for="name">Name:</label>
  <input type="text" id="name" name="name" required><br><br>

  <label for="email">Email:</label>
  <input type="email" id="email" name="email" required><br><br>

  <label for="mobile">Mobile:</label>
  <input type="tel" id="mobile" name="mobile" pattern="[0-9]{10}" required><br><br>

  <label for="message">Message:</label>
  <textarea id="message" name="message" rows="4" required></textarea><br><br>

  <label for="file">File (JPEG, max 500KB):</label>
  <input type="file" id="file" name="file" accept=".jpeg, .jpg" required><br><br>

  <span class="error" id="fileError"></span><br>

  <input type="submit" value="Submit">
</form>

<script>
  function validateForm() {
    var fileInput = document.getElementById('file');
    var fileError = document.getElementById('fileError');

    // Check if the file is a JPEG image
    var allowedExtensions = /(\.jpeg|\.jpg)$/i;
    if (!allowedExtensions.exec(fileInput.value)) {
      fileError.innerHTML = 'Only JPEG images are allowed.';
      return false;
    }

    // Check if the file size is within the limit (500KB)
    if (fileInput.files[0].size > 500 * 1024) {
      fileError.innerHTML = 'File size exceeds the limit (500KB).';
      return false;
    }

    fileError.innerHTML = '';
    return true;
  }
</script>

</body>
</html>
