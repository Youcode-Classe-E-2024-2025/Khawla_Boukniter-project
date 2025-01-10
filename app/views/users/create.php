{{ ... }}
<form action="<?= base_url('users/store') ?>" method="POST">
    <div>
        <label for="name">Nom</label>
        <input type="text" id="name" name="name" required>
    </div>
    <div>
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required>
    </div>
    <div>
        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required>
    </div>
    <div>
        <label for="role">Rôle</label>
        <select id="role" name="role">
            <option value="manager">Manager</option>
            <option value="user">Utilisateur</option>
        </select>
    </div>
    <button type="submit">Ajouter</button>
</form>
{{ ... }}
