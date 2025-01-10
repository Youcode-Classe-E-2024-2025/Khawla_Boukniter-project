        <div class="bg-transparent p-4 rounded shadow" style="justify-items: center;">
            <h1 style="background: linear-gradient(to right, #fb8192, #4CAF50); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold; font-size: 2rem">Edit User</h1>
            <div style="background-color: white; margin: 20px; padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); width: 60%;">
                <form action="<?= base_url('users/' . $user['id'] . '/update') ?>" method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label text-dark">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label text-dark">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </form>
            </div>
        </div>
