<?php
include '../db.php';

$sql = "SELECT * 
        FROM `denuncias` 
        WHERE `numero_ticket` = (SELECT MAX(`numero_ticket`) FROM `denuncias`)";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);
$NUMERO_TICKET = $row['numero_ticket'] + 1;

$DESCRICAO = $_POST['descricao'];
$UTILIZADOR = $_POST["Utilizador"];
$IP = $_SERVER['REMOTE_ADDR'];
$IDANOESCOLAR = $_POST["AnoEscolar"];
$ID_AZORES_ESCOLA = 1;
$ESTADO_TICKET = 0;

$userAgent = $_SERVER['HTTP_USER_AGENT'];
function getOS($userAgent) {
    if (strpos($userAgent, 'Windows') !== false) {
        return 'Windows';
    } elseif (strpos($userAgent, 'Macintosh') !== false || strpos($userAgent, 'Mac OS X') !== false) {
        return 'Mac OS';
    } elseif (strpos($userAgent, 'Linux') !== false) {
        return 'Linux';
    } elseif (strpos($userAgent, 'Android') !== false) {
        return 'Android';
    } elseif (strpos($userAgent, 'iOS') !== false) {
        return 'iOS';
    } else {
        return 'Outro';
    }
}
function getBrowser($userAgent) {
    if (strpos($userAgent, 'Firefox') !== false) {
        return 'Mozilla Firefox';
    } elseif (strpos($userAgent, 'Chrome') !== false) {
        return 'Google Chrome';
    } elseif (strpos($userAgent, 'Safari') !== false) {
        return 'Apple Safari';
    } elseif (strpos($userAgent, 'MSIE') !== false || strpos($userAgent, 'Trident') !== false) {
        return 'Internet Explorer';
    } elseif (strpos($userAgent, 'Edge') !== false) {
        return 'Microsoft Edge';
    } else {
        return 'Outro';
    }
}

$SISTEMA_OPERATIVO = getOS($userAgent);
$BROWSER = getBrowser($userAgent);

$sql = "INSERT INTO denuncias SET
    numero_ticket = ?,
	descricao = ?,
	utilizador = ?,
	ip = ?,
	sistema_operativo = ?,
	browser = ?,
	idanoescolar = ?,
	id_azores_escola = ?,
	estado = ?
	";

$stmt = $conn->prepare($sql);

if (!$stmt) {
	die("Erro na preparação: " . $conn->error . "<br>");
}

// Vincular os parâmetros
$stmt->bind_param(
	'issssssss',
	$NUMERO_TICKET, $DESCRICAO, $UTILIZADOR, $IP, $SISTEMA_OPERATIVO, $BROWSER,
	$IDANOESCOLAR, $ID_AZORES_ESCOLA, $ESTADO_TICKET
);

// Executar a instrução
if ($stmt->execute()) {
	echo '<script>alert("Denúncias inserida com sucesso!")</script>';
	echo '<script>history.back()</script>';
} else {
	echo '<script>alert("Erro na execução: ' . $stmt->error . '")</script>';
	echo '<script>history.back()</script>';
}

// Fechar a instrução e a conexão
$stmt->close();
$conn->close();
?>