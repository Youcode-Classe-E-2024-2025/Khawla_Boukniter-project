    <style>
        .mx-auto {
            color: black;
        }
    </style>
    <div class="mx-auto p-4">
        <h1 class="text-2xl mb-8" style="background: linear-gradient(to right, #fb8192, #4CAF50); -webkit-background-clip: text; -webkit-text-fill-color: transparent; font-weight: bold; width: fit-content; justify-self: center;">Users</h1>
        <div class="flex flex-col" data-aos="fade-up">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-50" style="background-color: #dddddd;">
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-[#66656d] uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-[#66656d] uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-[#66656d] uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-3 bg-gray-50 text-left text-xs leading-4 font-medium text-[#66656d] uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200" style="background-color: #e9e9e9;">
                                <?php foreach ($users as $user): ?>
                                    <tr data-aos="fade-up">
                                        <td class="px-6 py-2 whitespace-no-wrap"><?php echo htmlspecialchars($user['id']); ?></td>
                                        <td class="px-6 py-2 whitespace-no-wrap"><?php echo htmlspecialchars($user['name']); ?></td>
                                        <td class="px-6 py-2 whitespace-no-wrap"><?php echo htmlspecialchars($user['email']); ?></td>
                                        <td class="px-6 py-2 whitespace-no-wrap">
                                            <a class="btn btn-primary py-2" href="<?= base_url('users/' . $user['id'] . '/edit') ?>">Edit</a>
                                            <form action="<?= base_url('users/' . $user['id'] . '/delete') ?>" method="POST" style="display:inline;">
                                                <button type="submit" class="btn btn-danger py-2">Delete</button>
                                            </form>
                                            <form action="<?= base_url('users/' . $user['id'] . '/updateRole') ?>" method="POST" style="display:inline;">
                                                <select name="role" onchange="this.form.submit()" class="form-select" style="display:inline; width: auto; background-color: #e9e9e9; border: none;">
                                                    <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                                    <option value="member" <?= $user['role'] == 'member' ? 'selected' : '' ?>>Member</option>
                                                    <option value="manager" <?= $user['role'] == 'manager' ? 'selected' : '' ?>>Manager</option>
                                                </select>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>AOS.init();</script>
