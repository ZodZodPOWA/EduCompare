<?php
header('Content-Type: application/json');

// Inclure la configuration de la base de données
require_once 'config.php';

// Obtenir la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Obtenir le chemin de l'URL
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));

// Route principale
$resource = $request[0] ?? null;
$id = $request[1] ?? null; // ID optionnel pour certaines ressources

// Gestion des routes
switch ($resource) {
    case 'utilisateurs':
        handleUsers($method, $id, $pdo);
        break;
    case 'formations':
        handleFormations($method, $id, $pdo);
        break;
    case 'recherches':
        handleRecherches($method, $id, $pdo);
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Ressource non trouvée']);
        break;
}

// Gestion des utilisateurs
function handleUsers($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE idUtilisateur = ?");
                $stmt->execute([$id]);
                $user = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($user ?: ['message' => 'Utilisateur non trouvé']);
            } else {
                $stmt = $pdo->query("SELECT * FROM Utilisateur");
                $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($users);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom, pseudonyme, motDePasse, role) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$data['nom'], $data['prenom'], $data['pseudonyme'], $data['motDePasse'], $data['role']]);
            echo json_encode(['message' => 'Utilisateur créé', 'id' => $pdo->lastInsertId()]);
            break;
        case 'PUT':
            if ($id) {
                $data = json_decode(file_get_contents('php://input'), true);
                $stmt = $pdo->prepare("UPDATE Utilisateur SET nom = ?, prenom = ?, pseudonyme = ?, motDePasse = ?, role = ? WHERE idUtilisateur = ?");
                $stmt->execute([$data['nom'], $data['prenom'], $data['pseudonyme'], $data['motDePasse'], $data['role'], $id]);
                echo json_encode(['message' => 'Utilisateur mis à jour']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'ID requis pour la mise à jour']);
            }
            break;
        case 'DELETE':
            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM Utilisateur WHERE idUtilisateur = ?");
                $stmt->execute([$id]);
                echo json_encode(['message' => 'Utilisateur supprimé']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'ID requis pour la suppression']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['message' => 'Méthode non autorisée']);
            break;
    }
}

// Gestion des formations
function handleFormations($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Formation WHERE idFormation = ?");
                $stmt->execute([$id]);
                $formation = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($formation ?: ['message' => 'Formation non trouvée']);
            } else {
                $stmt = $pdo->query("SELECT * FROM Formation");
                $formations = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($formations);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO Formation (nom, description, prix, typeEcole, langues, uniforme, internat, tauxReussite) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $data['nom'], $data['description'], $data['prix'], $data['typeEcole'],
                $data['langues'], $data['uniforme'], $data['internat'], $data['tauxReussite']
            ]);
            echo json_encode(['message' => 'Formation créée', 'id' => $pdo->lastInsertId()]);
            break;
        case 'DELETE':
            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM Formation WHERE idFormation = ?");
                $stmt->execute([$id]);
                echo json_encode(['message' => 'Formation supprimée']);
            } else {
                http_response_code(400);
                echo json_encode(['message' => 'ID requis pour la suppression']);
            }
            break;
        default:
            http_response_code(405);
            echo json_encode(['message' => 'Méthode non autorisée']);
            break;
    }
}

// Gestion des recherches
function handleRecherches($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT * FROM Recherche WHERE idRecherche = ?");
                $stmt->execute([$id]);
                $recherche = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($recherche ?: ['message' => 'Recherche non trouvée']);
            } else {
                $stmt = $pdo->query("SELECT * FROM Recherche");
                $recherches = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode($recherches);
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO Recherche (idUtilisateur, dateRecherche) VALUES (?, ?)");
            $stmt->execute([$data['idUtilisateur'], $data['dateRecherche']]);
            echo json_encode(['message' => 'Recherche créée', 'id' => $pdo->lastInsertId()]);
            break;
        default:
            http_response_code(405);
            echo json_encode(['message' => 'Méthode non autorisée']);
            break;
    }
}
?>
