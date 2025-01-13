<?php
header('Content-Type: application/json');

// Inclure la configuration de la base de données
require_once 'config.php';

// Obtenir la méthode HTTP
$method = $_SERVER['REQUEST_METHOD'];

// Obtenir le chemin de l'URL
$request = explode('/', trim($_SERVER['PATH_INFO'], '/'));
$resource = $request[0] ?? null;
$id = $request[1] ?? null;

// Gestion des routes
switch ($resource) {
    case 'utilisateurs':
        handleUtilisateurRoutes($method, $id, $pdo);
        break;
    case 'formations':
        handleFormationRoutes($method, $id, $pdo);
        break;
    case 'recherches':
        handleRechercheRoutes($method, $id, $pdo);
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Ressource non trouvée']);
        break;
}

// Routes pour les utilisateurs
function handleUtilisateurRoutes($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            $id ? getUtilisateur($id, $pdo) : getUtilisateurs($pdo);
            break;
        case 'POST':
            createUtilisateur($pdo);
            break;
        case 'PUT':
            $id ? updateUtilisateur($id, $pdo) : badRequest('ID requis pour la mise à jour');
            break;
        case 'DELETE':
            $id ? deleteUtilisateur($id, $pdo) : badRequest('ID requis pour la suppression');
            break;
        default:
            methodNotAllowed();
            break;
    }
}

function getUtilisateur($id, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM Utilisateur WHERE idUtilisateur = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($user ?: ['message' => 'Utilisateur introuvables']);
}

function getUtilisateurs($pdo) {
    $stmt = $pdo->query("SELECT * FROM Utilisateur");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
}

function createUtilisateur($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO Utilisateur (nom, prenom, pseudonyme, motDePasse, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$data['nom'], $data['prenom'], $data['pseudonyme'], $data['motDePasse'], $data['role']]);
    echo json_encode(['message' => 'Utilisateur créé', 'id' => $pdo->lastInsertId()]);
}

function updateUtilisateur($id, $pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("UPDATE Utilisateur SET nom = ?, prenom = ?, pseudonyme = ?, motDePasse = ?, role = ? WHERE idUtilisateur = ?");
    $stmt->execute([$data['nom'], $data['prenom'], $data['pseudonyme'], $data['motDePasse'], $data['role'], $id]);
    echo json_encode(['message' => 'Utilisateur mis à jour']);
}

function deleteUtilisateur($id, $pdo) {
    $stmt = $pdo->prepare("DELETE FROM Utilisateur WHERE idUtilisateur = ?");
    $stmt->execute([$id]);
    echo json_encode(['message' => 'Utilisateur supprimé']);
}

function handleFormationRoutes($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            $id ? getFormation($id, $pdo) : getFormations($pdo);
            break;
        case 'POST':
            createFormation($pdo);
            break;
        case 'DELETE':
            $id ? deleteFormation($id, $pdo) : badRequest('ID requis pour la suppression');
            break;
        default:
            methodNotAllowed();
            break;
    }
}

function getFormation($id, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM Formation WHERE idFormation = ?");
    $stmt->execute([$id]);
    $formation = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($formation ?: ['message' => 'Formation non trouvée']);
}

function getFormations($pdo) {
    $stmt = $pdo->query("SELECT * FROM Formation");
    $formations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($formations);
}

function createFormation($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO Formation (nom, description, prix, typeEcole, langues, uniforme, internat, tauxReussite) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $data['nom'], $data['description'], $data['prix'], $data['typeEcole'],
        $data['langues'], $data['uniforme'], $data['internat'], $data['tauxReussite']
    ]);
    echo json_encode(['message' => 'Formation créée', 'id' => $pdo->lastInsertId()]);
}

function deleteFormation($id, $pdo) {
    $stmt = $pdo->prepare("DELETE FROM Formation WHERE idFormation = ?");
    $stmt->execute([$id]);
    echo json_encode(['message' => 'Formation supprimée']);
}


function handleRechercheRoutes($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            $id ? getRecherche($id, $pdo) : getRecherches($pdo);
            break;
        case 'POST':
            createRecherche($pdo);
            break;
        default:
            methodNotAllowed();
            break;
    }
}

function getRecherche($id, $pdo) {
    $stmt = $pdo->prepare("SELECT * FROM Recherche WHERE idRecherche = ?");
    $stmt->execute([$id]);
    $recherche = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($recherche ?: ['message' => 'Recherche non trouvée']);
}

function getRecherches($pdo) {
    $stmt = $pdo->query("SELECT * FROM Recherche");
    $recherches = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($recherches);
}

function createRecherche($pdo) {
    $data = json_decode(file_get_contents('php://input'), true);
    $stmt = $pdo->prepare("INSERT INTO Recherche (idUtilisateur, dateRecherche) VALUES (?, ?)");
    $stmt->execute([$data['idUtilisateur'], $data['dateRecherche']]);
    echo json_encode(['message' => 'Recherche créée', 'id' => $pdo->lastInsertId()]);
}

// Gestion des erreurs
function badRequest($message) {
    http_response_code(400);
    echo json_encode(['message' => $message]);
}

function methodNotAllowed() {
    http_response_code(405);
    echo json_encode(['message' => 'Méthode non autorisée']);
}
?>
