<?php
header('Content-Type: application/json');

$db_file = 'ranking.db';

try {
    $db = new PDO("sqlite:$db_file");
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables if not exist
    $db->exec("CREATE TABLE IF NOT EXISTS users (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        phone TEXT UNIQUE NOT NULL
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS scores (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        user_id INTEGER NOT NULL,
        accuracy INTEGER NOT NULL,
        mistakes INTEGER NOT NULL,
        time_seconds INTEGER NOT NULL,
        total_score REAL NOT NULL,
        slug TEXT NOT NULL,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES users(id)
    )");

    $db->exec("CREATE TABLE IF NOT EXISTS issue_reports (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        slug TEXT NOT NULL,
        question_text TEXT NOT NULL,
        report_text TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    exit;
}

$action = $_GET['action'] ?? $_POST['action'] ?? '';

if ($action === 'save_score') {
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $accuracy = (int)($_POST['accuracy'] ?? 0);
    $mistakes = (int)($_POST['mistakes'] ?? 0);
    $time_seconds = (int)($_POST['time_seconds'] ?? 0);
    $slug = $_POST['slug'] ?? 'default';

    if (empty($name) || empty($phone)) {
        echo json_encode(['success' => false, 'error' => 'Nome e celular são obrigatórios.']);
        exit;
    }

    try {
        $stmt = $db->prepare("SELECT id, name FROM users WHERE phone = ?");
        $stmt->execute([$phone]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $user_id = $user['id'];
            if ($user['name'] !== $name) {
                $upd = $db->prepare("UPDATE users SET name = ? WHERE id = ?");
                $upd->execute([$name, $user_id]);
            }
        } else {
            $stmt = $db->prepare("INSERT INTO users (name, phone) VALUES (?, ?)");
            $stmt->execute([$name, $phone]);
            $user_id = $db->lastInsertId();
        }

        $total_score = ($accuracy * 100) - ($mistakes * 10) - ($time_seconds * 0.1);
        $stmt = $db->prepare("INSERT INTO scores (user_id, accuracy, mistakes, time_seconds, total_score, slug) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$user_id, $accuracy, $mistakes, $time_seconds, $total_score, $slug]);

        echo json_encode(['success' => true, 'name' => $name, 'phone' => $phone]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

} elseif ($action === 'get_ranking') {
    $slug = $_GET['slug'] ?? '';
    try {
        $query = "SELECT u.name, s.accuracy, s.mistakes, s.time_seconds, s.total_score, s.created_at 
                  FROM scores s 
                  JOIN users u ON s.user_id = u.id ";
        if (!empty($slug)) { $query .= " WHERE s.slug = :slug "; }
        $query .= " ORDER BY s.total_score DESC LIMIT 50";
        $stmt = $db->prepare($query);
        if (!empty($slug)) { $stmt->bindValue(':slug', $slug); }
        $stmt->execute();
        echo json_encode(['success' => true, 'ranking' => $stmt->fetchAll(PDO::FETCH_ASSOC)]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

} elseif ($action === 'get_top_player') {
    $slug = $_GET['slug'] ?? '';
    try {
        $stmt = $db->prepare("SELECT u.name, s.accuracy 
                              FROM scores s 
                              JOIN users u ON s.user_id = u.id 
                              WHERE s.slug = ? 
                              ORDER BY s.total_score DESC LIMIT 1");
        $stmt->execute([$slug]);
        $top = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'top' => $top]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }

} elseif ($action === 'report_issue') {
    $slug = $_POST['slug'] ?? '';
    $question = $_POST['question'] ?? '';
    $report = $_POST['report'] ?? '';
    try {
        $stmt = $db->prepare("INSERT INTO issue_reports (slug, question_text, report_text) VALUES (?, ?, ?)");
        $stmt->execute([$slug, $question, $report]);
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Ação inválida.']);
}
