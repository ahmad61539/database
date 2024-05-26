<?php
include 'config.php';

// Tambah data
if(isset($_POST['add'])){
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "INSERT INTO users (name, email) VALUES ('$name', '$email')";
    $conn->query($sql);
    header('location: index.php');
}

// Hapus data
if(isset($_GET['delete'])){
    $id = $_GET['delete'];
    $sql = "DELETE FROM users WHERE id=$id";
    $conn->query($sql);
    header('location: index.php');
}

// Ambil data untuk update
if(isset($_GET['edit'])){
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM users WHERE id=$id");
    $row = $result->fetch_assoc();
    $edit_name = $row['name'];
    $edit_email = $row['email'];
}

// Update data
if(isset($_POST['update'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sql = "UPDATE users SET name='$name', email='$email' WHERE id=$id";
    $conn->query($sql);
    header('location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple Website</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>User Management</h1>

        <form action="index.php" method="POST" class="form">
            <input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" name="name" value="<?php echo isset($edit_name) ? $edit_name : ''; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo isset($edit_email) ? $edit_email : ''; ?>" required>
            </div>
            <div class="form-group">
                <?php if(isset($id)): ?>
                    <button type="submit" name="update" class="btn">Update</button>
                <?php else: ?>
                    <button type="submit" name="add" class="btn">Add</button>
                <?php endif; ?>
            </div>
        </form>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM users";
                $result = $conn->query($sql);
                while($row = $result->fetch_assoc()):
                ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td>
                        <a href="index.php?edit=<?php echo $row['id']; ?>" class="btn">Edit</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</body>
</html>