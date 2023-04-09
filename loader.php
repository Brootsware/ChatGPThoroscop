<?php
if(!isset($_POST["submitusername"])){
header("index.html");
}
?>


<!DOCTYPE html>
<html>
<head>
  <title>Form with Loading Gif</title>
  <style>
    /* CSS for loading gif */
    #loading-gif {
      display: none;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
  </style>
</head>
<body>
  <h1>Form with Loading Gif</h1>
  <form id="my-form">
    <label for="name">Name:</label>
    <input type="text" name="name" id="name">
    <button type="submit">Submit</button>
  </form>
  <div id="loading-gif">
    <img src="assets/img/giphy.gif" alt="Loading...">
  </div>
  <script>
    const form = document.getElementById('my-form');
    const loadingGif = document.getElementById('loading-gif');

    form.addEventListener('submit', (event) => {
      event.preventDefault();
      loadingGif.style.display = 'block';

      // Submit the form using your preferred method, such as fetch or XMLHttpRequest
      // In this example, we're just setting a timeout to simulate a delay
      setTimeout(() => {
        // alert('Form submitted!');
        loadingGif.style.display = 'none';
      }, 5000);
    });
  </script>

</body>
</html>