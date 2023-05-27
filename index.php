<html>
  <head>
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css"
          integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS"
          crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="project2/blogproject.css">
    <style>
        h1 
        {
            font-family: Georgia, 'Times New Roman', Times, serif;
            color: palevioletred;
            text-shadow: 2px 2px 4px plum;
            text-align: center;
        }
        a {
          text-decoration: underline;
        }
        p.rightside {
          text-align: right;
        }
    </style>

    <title>Blog Posts</title>
  </head>
  <body>
    <div class="card">
      <div class="card-body">
        <h1>Welcome to Anna's Blog!</h1>
        <p class='nav-link rightside'><a href='addpost.php'>Add a post</a></p>

        <?php
            require_once('dbconnection.php');
            // Connect to the database
            $dbc = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
                    or trigger_error('Error connecting to MySQL server for' 
                    .  DB_NAME, E_USER_ERROR);
            // Query the database for all posts, ordered from newest to oldest post
            $query = "SELECT id, post_title, post_date, blog_post FROM blogPost ORDER BY id DESC";
            // Assign the result of the query
            $result = mysqli_query($dbc, $query)
                    or trigger_error('Error querying database BlogProject', 
                    E_USER_ERROR);

            // Checks if any rows were returned by the query, and if so, displays them in a table
            if (mysqli_num_rows($result) > 0) {
                    echo '<table class="table table-striped table-bordered table-hover">
                          <thead>
                              <tr>
                                <th scope="col">Blog Posts:</th>
                              </tr>
                          </thead>
                      <tbody>';

            // The while loop iterates through each row of the query result and displays it in a table row
            while($row = mysqli_fetch_assoc($result)) {
                      echo "<tr><td>"
                            . "<a class='nav-link' href='blogdetails.php?id=" . $row['id'] . "'>"
                            . $row['post_title'] . "<br/>" . $row['post_date'] . "</a><br/>" . $row['blog_post']
                            . "</td></tr>";
            }
                        echo '</tbody>
                            </table>';
                    } else {
                        echo '<h3>No Posts Found :-(</h3>';
                    }           
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
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" 
            referrerpolicy="origin"></script>
  </body>
</html>