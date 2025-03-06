<?php
include '../db.php';
date_default_timezone_set("Atlantic/Azores");

$NUMERO_TICKET = $_POST['ticket'];
$RESPOSTA = $_POST['resposta'];
$UTILIZADOR = $_POST["Utilizador"];

$DATA_FECHAR_TICKET = date("Y-m-d H:i:s");
$ESTADO_TICKET = 1;

$sql = "UPDATE sugestoes_rgpc SET
    resposta = ?,
    utilizador_fechado = ?,
    data_fechado = ?,
	estado = ?
    WHERE numero_ticket = ?";

$stmt = $conn->prepare($sql);

if (!$stmt) {
	die("Erro na preparação: " . $conn->error . "<br>");
}

// Vincular os parâmetros
$stmt->bind_param(
	'sssss',
	$RESPOSTA, $UTILIZADOR, $DATA_FECHAR_TICKET, $ESTADO_TICKET, $NUMERO_TICKET
);

// Executar a instrução
if ($stmt->execute()) {
	echo '<script>alert("Resposta inserida com sucesso!")</script>';
	echo '<script>history.back()</script>';
} else {
	echo '<script>alert("Erro na execução: ' . $stmt->error . '")</script>';
	echo '<script>history.back()</script>';
}

// Fechar a instrução e a conexão
$stmt->close();
$conn->close();
?>