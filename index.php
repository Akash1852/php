<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <style>
    body {
        background-color: #f8f9fa;
    }

    .container {
        margin-top: 50px;
    }
    </style>
</head>

<body>

    <div class="container">

        <?php
        include 'conn.php';

        $db = new Data();

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['submit'])) {
                // insert
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $db->insertUser($username, $email, $password);
            } elseif (isset($_POST['update'])) {
                // update
                $id = $_POST['user_id'];
                $username = $_POST['username'];
                $email = $_POST['email'];
                $password = $_POST['password'];

                $db->updateUser($id, $username, $email, $password);
                
            }
        }

        // delete user
        if (isset($_GET['delete'])) {
            $id = $_GET['delete'];
            $db->deleteUser($id);
        }

        ?>

        <!-- add userform -->
        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username : </label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email : </label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password : </label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Add</button>
        </form>

        <hr>

        <!-- display users -->
        <h3>User List</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                
                $users = $db->getUsers();
                foreach ($users as $user) {
                    echo "<tr>
                        <td>{$user['username']}</td>
                        <td>{$user['email']}</td>
                        <td>
                            <a href='?edit={$user['id']}' class='btn btn-info btn-sm'>Edit</a>
                            <a href='?delete={$user['id']}' class='btn btn-danger btn-sm'>Delete</a>
                        </td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- update userform -->
        <?php
        if (isset($_GET['edit'])) {
            $edit_id = $_GET['edit'];
            $user = $db->getUserById($edit_id);
            ?>
        <h3>Edit User</h3>

        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">

            <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">

            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username"
                    value="<?php echo $user['username']; ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $user['email']; ?>"
                    required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password"
                    value="<?php echo $user['password']; ?>" required>
            </div>

            <button type="submit" name="update" class="btn btn-primary">Update User</button>

        </form>

        <?php
        }
        $db->closeConnection();
        ?>

    </div>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</body>

</html>