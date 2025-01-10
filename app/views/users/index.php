<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User List</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa; /* Example background color */
        }
        .container {
            margin-top: 50px;
        }
        table {
            width: 100%;
            margin: 20px 0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Add shadow for depth */
        }
        th, td {
            border: 1px solid #dee2e6; /* Use your site's border color */
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff; /* Example header color */
            color: white; /* Header text color */
        }
        tr:hover {
            background-color: #e9ecef; /* Hover effect */
        }
        .btn {
            padding: 5px 10px;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn-primary {
            background-color: #28a745; /* Example button color */
        }
        .btn-danger {
            background-color: #dc3545; /* Delete button color */
        }
        .btn:hover {
            opacity: 0.8; /* Slightly transparent on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>User List</h1>
        <?php if (empty($users)): ?>
            <p>No users found.</p>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                            <a class="btn btn-primary" href="<?= base_url('users/' . $user['id'] . '/edit') ?>">Edit</a>
                                <form action="<?= base_url('users/' . $user['id'] . '/delete') ?>" method="POST" style="display:inline;">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>