<?php
  include('mysession.php');
  if(!session_id())
  {
    session_start();
  }

  // Include database connection
  include ('dbconnect.php');

  // Get id for current user
  $suid = intval($_SESSION['suid']);  // Convert to integer

  // CRUD: Retrieve current user using prepared statement
  $sqlc = "SELECT * FROM tb_user INNER JOIN tb_usertype ON tb_user.type_id = tb_usertype.type_id WHERE tb_user.user_id = ?";
  $stmt = mysqli_prepare($con, $sqlc);

  if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $suid);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (!$result) {
        die("Query failed: " . mysqli_error($con));
    }

    // Fetch user types
    $sqlUserTypes = "SELECT * FROM tb_usertype";
    $resultUserTypes = mysqli_query($con, $sqlUserTypes);

    if (!$resultUserTypes) {
        die("Query failed: " . mysqli_error($con));
    }

    // Display result
    include 'headeradmin.php';
  } else {
    die("Prepare statement failed: " . mysqli_error($con));
  }
?>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>User Management</h1>
      <div class="d-flex justify-content-between align-items-center">
      <nav>
          <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="adminmain.php">Home</a></li>
              <li class="breadcrumb-item active">User Management</li>
          </ol>
      </nav>

      <div class="btn-group me-2">
          <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdropAdd"><i class="bi bi-plus-circle"></i> Add</button>
          <button type="button" class="btn btn-secondary"><i class="bi bi-filetype-pdf"></i> Export</button>
      </div>
      </div>
    </div><!-- End Page Title -->

    <!-- Add Modal -->
        <div class="modal fade" id="staticBackdropAdd" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropAddLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropAddLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="registerprocess.php">
                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">User ID</label>
                    <input type="text" name="fid" class="form-control" id="exampleInputPassword1" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">Identity Card No.</label>
                    <input type="text" name="fic" class="form-control" id="exampleInputPassword1" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">First Name</label>
                    <input type="text" name="ffname" class="form-control" id="exampleInputPassword1" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">Last Name</label>
                    <input type="text" name="flname" class="form-control" id="exampleInputPassword1" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                    <input type="password" name="fpwd" class="form-control" id="exampleInputPassword1" placeholder="" autocomplete="off" required>
                    <small id="emailHelp" class="form-text text-muted">Please include with symbol</small>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">Phone No</label>
                    <input type="text" name="fphone" class="form-control" id="exampleInputPassword1" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                    <input type="email" name="femail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleTextarea" class="form-label mt-4">Address</label>
                    <textarea class="form-control" name="fadd" id="exampleTextarea" rows="3" required></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label mt-4">Position</label>
                    <input type="text" name="fposition" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label mt-4">User Type</label>
                    <select name="ftype" class="form-control" id="exampleInputEmail1" required>
                        <?php
                            while ($rowType = mysqli_fetch_array($resultUserTypes)) {
                                echo "<option value='" . $rowType['type_id'] . "'>" . $rowType['type_desc'] . "</option>";
                            }
                        ?>
                    </select>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    <!-- Edit Modal -->
        <div class="modal fade" id="editUserModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <form method="POST" action="updateuser.php">
                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">User ID</label>
                    <input type="text" name="fid" class="form-control" id="exampleInputPassword1" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">Identity Card No.</label>
                    <input type="text" name="fic" class="form-control" id="exampleInputPassword1" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">First Name</label>
                    <input type="text" name="ffname" class="form-control" id="exampleInputPassword1" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">Last Name</label>
                    <input type="text" name="flname" class="form-control" id="exampleInputPassword1" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">Password</label>
                    <input type="password" name="fpwd" class="form-control" id="exampleInputPassword1" placeholder="Password here" autocomplete="off" required>
                    <small id="emailHelp" class="form-text text-muted">We'll never share your password with anyone else.</small>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputPassword1" class="form-label mt-4">Phone No</label>
                    <input type="text" name="fphone" class="form-control" id="exampleInputPassword1" placeholder="Please include country code" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label mt-4">Email address</label>
                    <input type="email" name="femail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" required>
                  </div>
                  
                  <div class="form-group">
                    <label for="exampleTextarea" class="form-label mt-4">Address</label>
                    <textarea class="form-control" name="fadd" id="exampleTextarea" rows="3" required></textarea>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label mt-4">Position</label>
                    <input type="text" name="fposition" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="" required>
                  </div>

                  <div class="form-group">
                    <label for="exampleInputEmail1" class="form-label mt-4">User Type</label>
                    <select name="ftype" class="form-control" id="exampleInputEmail1" required>
                        <?php
                            while ($rowType = mysqli_fetch_array($resultUserTypes)) {
                                echo "<option value='" . $rowType['type_id'] . "'>" . $rowType['type_desc'] . "</option>";
                            }
                        ?>
                    </select>
                  </div>
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Update</button>
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal">Cancel</button>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">User List</h5>

              <!-- Wrap the table with a div and apply the table-responsive class -->
          <div class="table-responsive">
              <!-- Table with stripped rows -->
              <table class="table datatable">
                <thead>
                  <tr>
                    <th>
                      <b>U</b>ser ID
                    </th>
                    <th>IC</th>
                    <th>Password</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Phone No.</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Position</th>
                    <th>User Type</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                    while($row = mysqli_fetch_array($result))
                    {
                      echo"<tr>";
                      echo"<td>".$row['user_id']."</td>";
                      echo"<td>".$row['user_ic']."</td>";
                      echo"<td>".$row['user_pwd']."</td>";
                      echo"<td>".$row['u_fName']."</td>";
                      echo"<td>".$row['u_lName']."</td>";
                      echo"<td>".$row['user_phone']."</td>";
                      echo"<td>".$row['user_email']."</td>";
                      echo"<td>".$row['user_address']."</td>";
                      echo"<td>".$row['user_position']."</td>";
                      echo"<td>".$row['type_desc']."</td>";
                      echo"<td>";
                        echo '<div class="dropdown">
                          <button class="btn btn-light" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                              <i class="bi bi-three-dots-vertical"></i>
                          </button>
                          <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#editUserModal" onclick="editUser(' . $row['user_id'] . ')">Edit</a></li>
                              <li><a class="dropdown-item" href="deleteuser.php?id=' . $row['user_id'] . '">Delete</a></li>
                          </ul>
                        </div>';
                      echo"</td>";
                      echo"</tr>";
                    }
                  ?>
                </tbody>
              </table>
              <!-- End Table with stripped rows -->

            </div>
          </div>
          </div>

        </div>
      </div>
    </section>
    <?php mysqli_close($con); ?>
  </main><!-- End #main -->

<?php include 'footer.php'; ?>