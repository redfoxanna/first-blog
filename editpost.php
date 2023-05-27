<?php
require_once('authorizeaccess.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Edit Post</title>
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
      <h1>Edit Your Post</h1>
      <nav class="nav">
        <a class="nav-link" href="index.php">Back to posts</a>
      </nav>
      <hr />
      <?php
      require_once('dbconnection.php');

      $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
        or trigger_error(
          'Error connecting to MySQL server for DB_NAME.',
          E_USER_ERROR
        );
      // Check if id selected to edit or delete 
      if (isset($_GET['id_to_edit'])) {
              $id_to_edit = $_GET['id_to_edit'];
              $id_to_delete = $_GET['id_to_edit'];
              // Query the database for the selected post to edit
              $query = "SELECT * FROM blogPost WHERE id = $id_to_edit";
              // Assign the result to $result 
              $result = mysqli_query($dbc, $query)
                      or trigger_error(
                      'Error querying database blogPost',
                      E_USER_ERROR
          );
        // Get rows that you want to edit
        if (mysqli_num_rows($result) == 1) {
                $row = mysqli_fetch_assoc($result);

                $post_title = $row['post_title'];
                $post_date = $row['post_date'];
                $blog_post = $row['blog_post'];
        }
      } elseif (
              // If edited, assign the changes
              isset($_POST['edit_blog_post'], $_POST['post_title'],
              $_POST['post_date'], $_POST['blog_post'])
              && !isset($_POST['id_to_delete'])
      ) {
              $post_title = $_POST['post_title'];
              $post_date = $_POST['post_date'];
              $blog_post = mysqli_real_escape_string($dbc, $_POST['blog_post']);
              $id_to_update = $_POST['id_to_update'];
              // Query to update the database with edited post
              $query = "UPDATE blogPost SET post_title = '$post_title', "
                      . " post_date = STR_TO_DATE('$post_date', '%Y-%m-%d'), blog_post = '$blog_post' "
                      . "WHERE id = $id_to_update";

        mysqli_query($dbc, $query)
                or trigger_error(
                'Error querying database blogPost: Failed to update blog listing',
                E_USER_ERROR
          );

        $nav_link = 'blogdetails.php?id=' . $id_to_update;

        header("Location: $nav_link");
      } elseif (isset($_POST['id_to_delete'])) {
        
        // Grab id from delete
        $id_to_delete = $_POST['id_to_delete'];

        // Delete the blog post from the database
        $query = "DELETE FROM blogPost WHERE id = $id_to_delete";
        mysqli_query($dbc, $query)
                or trigger_error('Error querying database blogPost: 
                Failed to delete blog listing', E_USER_ERROR);

        // Redirect to the index page
        header("Location: index.php");
      } else // Unintended page link
      {
        header("Location: index.php");
      }
      // Diplay form
      ?>
      <form enctype="multipart/form-data" class="needs-validation" 
            novalidate method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
        <div class="form-group row">
          <label for="post_title" class="col-sm-3 col-form-label-lg">Title</label>
          <div class="col-sm-8">
            <input type="text" class="form-control" id="post_title" name="post_title" 
                    value="<?= $post_title ?>" placeholder="Title" required>
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
        <div class="form-group row">
          <div class="col-sm-8 offset-sm-3">
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#confirm-delete">Delete
              Post</button>
            <button class="btn btn-primary" type="submit" name="edit_blog_post">Edit Post</button>
            <input type="hidden" name="id_to_update" value="<?= $id_to_edit ?>">
          </div>
        </div>
      </form>

      <!-- Modal for delete confirmation -->
      <div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Are you sure you want to delete this post?
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <form form enctype="multipart/form-data" novalidate method="POST" action="<?= $_SERVER['PHP_SELF'] ?>">
                <input type="hidden" name="id_to_delete" value="<?= $id_to_delete ?>">
                <button class="btn btn-danger" type="submit" name="delete_blog_post">Delete</button>
              </form>
            </div>
          </div>
        </div>
      </div>

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