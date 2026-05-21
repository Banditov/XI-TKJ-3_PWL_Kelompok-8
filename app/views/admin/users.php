<title>Users | Admin Panel</title>
<link rel="stylesheet" href="/css/responsive/main.css">

<?php include __DIR__ . '/../../../app/views/layouts/partials/navbar.php'; ?>
<?php include __DIR__ . '/../../../app/helpers/basehelper.php'; ?>

<main class="md:right-0 md:top-0 md:absolute md:w-[calc(100%-16rem)] p-10 flex flex-col gap-10 grow md:mx-auto">
    <div class="w-full rounded-4xl bg-white dark:bg-[#1B1B1B] text-[#545F71] dark:text-white drop-shadow-lg p-10 post">
        <h1 class="text-4xl font-bold mb-6">Users</h1>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                <?= $_SESSION['success'];
                unset($_SESSION['success']); ?>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="border-b border-[#545F71] dark:border-[#3F3F3F]">
                        <th class="text-left p-3">Avatar</th>
                        <th class="text-left p-3">ID</th>
                        <th class="text-left p-3">Name</th>
                        <th class="text-left p-3">Email</th>
                        <th class="text-left p-3">Class</th>
                        <th class="text-left p-3">Admin</th>
                        <th class="text-left p-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr class="border-b border-[#545F71] dark:border-[#3F3F3F]">
                            <td class="p-3">
                                <img src="<?= getAvatarUrl($user['id'], $user['name']) ?>" class="w-10 h-10 object-cover rounded-full">
                            </td>
                            <td class="p-3"><?= $user['id'] ?></td>
                            <td class="p-3"><?= htmlspecialchars($user['name']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($user['email']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($user['class_name']) ?></td>
                            <td class="p-3"><?= $user['is_admin'] ? 'Yes' : 'No' ?></td>
                            <td class="p-3">
                                <div class="flex gap-2">
                                    <a href="/admin/users/<?= $user['id'] ?>/edit"
                                        class="px-3 py-1 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition text-sm">
                                        Edit
                                    </a>
                                    <?php if ($user['id'] != $_SESSION['account_id']): ?>
                                        <button onclick="deleteUser(<?= $user['id'] ?>)"
                                            class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition text-sm">
                                            Delete
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script>
    function deleteUser(userId) {
        if (confirm('Are you sure you want to delete this user? This action cannot be undone.')) {
            fetch('/admin/users/' + userId + '/delete', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                }
            }).then(response => {
                window.location.reload();
            });
        }
    }
</script>