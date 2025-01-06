<?php

function base_url($path = '')
{
    $baseUrl = '/Khawla_Boukniter-project/public';
    return $baseUrl . '/' . ltrim($path, '/');
}

function asset_url($path)
{
    return base_url('assets/' . ltrim($path, '/'));
}

function current_user()
{
    return $_SESSION['user_id'] ?? null;
}

function user_name()
{
    return $_SESSION['user_name'] ?? 'Utilisateur';
}

function user_role()
{
    return $_SESSION['user_role'] ?? '';
}

function is_authenticated()
{
    return isset($_SESSION['user_id']);
}

function is_manager()
{
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'manager';
}

function is_member()
{
    return user_role() === 'member';
}

function format_date($date)
{
    if (empty($date)) return 'Non définie';
    return date('d/m/Y', strtotime($date));
}

function get_status_color($status)
{
    return match ($status) {
        'todo' => 'warning',
        'in_progress' => 'info',
        'completed' => 'success',
        'active' => 'primary',
        'archived' => 'secondary',
        default => 'light'
    };
}

function get_status_label($status)
{
    return match ($status) {
        'todo' => 'À faire',
        'in_progress' => 'En cours',
        'completed' => 'Terminé',
        'active' => 'Actif',
        'archived' => 'Archivé',
        default => 'Inconnu'
    };
}

function get_priority_color($priority)
{
    return match ($priority) {
        'low' => 'success',
        'medium' => 'warning',
        'high' => 'danger',
        default => 'secondary'
    };
}

function get_priority_label($priority)
{
    return match ($priority) {
        'low' => 'Basse',
        'medium' => 'Moyenne',
        'high' => 'Haute',
        default => 'Non définie'
    };
}

function csrf_token()
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrf_field()
{
    return '<input type="hidden" name="csrf_token" value="' . csrf_token() . '">';
}

function verify_csrf_token($token)
{
    if (empty($_SESSION['csrf_token']) || empty($token)) {
        return false;
    }
    return hash_equals($_SESSION['csrf_token'], $token);
}

function escape_html($text)
{
    return htmlspecialchars($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

function set_flash_message($type, $message)
{
    $_SESSION[$type] = $message;
}

function get_flash_message($type)
{
    $message = $_SESSION[$type] ?? '';
    unset($_SESSION[$type]);
    return $message;
}
