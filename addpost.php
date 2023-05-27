<?php
require_once('authorizeaccess.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>Add Post</title>
  <link rel="stylesheet" 
        href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
        integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" 
        crossorigin="anonymous">
  <style>
    a {
      text-decoration: underline;
    }
  </style>
</head>

<body>
  <div class="card">
    <div class="card-body">
      <h1>Add a Post</h1>
      <nav class="nav">
        <a class="nav-link" href="index.php">Back to posts</a>
      </nav>
      <hr />
      <?php
      $display_add_post_form = true;
      // Initialize to empty strings
      $post_title = "";
      $post_date = "";
      $blog_post = "";

      //Check if user clicked on add post & set all fields 
      if (
        isset($_POST['add_blog_post'], $_POST['post_title'],
                $_POST['post_date'], $_POST['blog_post'])
      ) {
        require_once('dbconnection.php');

        $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                or trigger_error(
                'Error connecting to MySQL server for' . DB_NAME,
                E_USER_ERROR
          );

        // Assign values with entered info from the form
        $post_title = $_POST['post_title'];
        $post_date = $_POST['post_date'];
        $blog_post = $blog_post = mysqli_real_escape_string($dbc, $_POST['blog_post']);

        // Query the database to add new blog post
        $query = "INSERT INTO blogPost (post_title, post_date, blog_post) "
                . "VALUES ('$post_title', STR_TO_DATE('$post_date', '%Y-%m-%d'), '$blog_post')";

        mysqli_query($dbc, $query)
                or trigger_error(
                'Error querying database blogPost: Failed to insert blog data',
                E_USER_ERROR
          );
        // Do not display the form, display the added post in a table 
        $display_add_post_form = false;
        ?>
        <h3 class="text-info">The Following Post Was Added:</h3><br />

        <h1>
          <?= "$post_title" ?>
        </h1>
        <div class="col">
          <table class="table table-striped">
            <tbody>
              <tr>
                <th scope="row">Title</th>
                <td>
                  <?= $post_title ?>
                </td>
              </tr>
              <tr>
                <th scope="row">Date</th>
                <td>
                  <?= $post_date ?>
                </td>
              </tr>
              <tr>
                <th scope="row">Post</th>
                <td>
                  <?= $blog_post ?>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <hr />
      <p>Would you like to <a href='<?= $_SERVER['PHP_SELF'] ?>'> 
              add another post?</a>?</p>
      <?php
      }

      // Display form to add post 
      if ($display_add_post_form) {
        ?>
      <form enctype="multipart/form-data" class="needs-validation" 
              novalidate method="POST"
              action="<?= $_SERVER['PHP_SELF'] ?>">
        <div class="form-group row">
          <label for="post_title" class="col-sm-3 col-form-label-lg">Title</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="post_title" 
                    name="post_title" value="<?= $post_date ?>"
                    placeholder="Title" required>
            <div class="invalid-feedback">
                    Please provide a valid title.
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="post_date" class="col-sm-3 col-form-label-lg">Date</label>
          <div class="col-sm-8">
            <input type="date" class="form-control" id="post_date" name="post_date" 
                    value="<?= $post_date ?>" placeholder="Date" required>
            <div class="invalid-feedback">
                    Please provide a valid date.
            </div>
          </div>
        </div>
        <div class="form-group row">
          <label for="blog_post" class="col-sm-3 col-form-label-lg">Post</label>
          <div class="col-sm-8">
            <textarea id="default" class="form-control" name="blog_post" 
                    placeholder="Post" required><?= $blog_post ?></textarea>
            <div class="invalid-feedback">
                    Please provide a valid post.
            </div>
          </div>
        </div>
        <button class="btn btn-primary" type="submit" 
                name="add_blog_post">Add Post</button>
      </form>

      <script>
        // JavaScript for disabling form submissions if there are invalid fields
        (function () {
          'use strict';
          window.addEventListener('load', function () {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function (form) {
              form.addEventListener('submit', function (event) {
                  if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                }
                form.classList.add('was-validated');
              }, false);
            });
          }, false);
        })();
      </script>
      <?php
      } // Display add post form
      ?>
  </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
          integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo"
          crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
          integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
          crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
          integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
          crossorigin="anonymous"></script>

</body>

</html>