<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guardar'])) {
  $nombre = $_POST['nombre'] ?? '';
  $apellido = $_POST['apellido'] ?? '';
  $institucion = $_POST['institucion_educativa'] ?? '';
  $grado = $_POST['grado'] ?? '';
  $edad = $_POST['edad'] ?? 0;
  $genero = $_POST['genero'] ?? '';
  $peso = $_POST['peso'] ?? 0;
  $talla = $_POST['talla'] ?? 0;
  $hemoglobina = round(($peso / ($talla * $talla)) * 0.8, 2);

  if ($nombre && $apellido && $institucion && $grado) {
    $conn = new mysqli("localhost", "root", "", "control_salud_escolar");
    if ($conn->connect_error) {
      die("Error de conexión: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO estudiantes (nombre, apellido, institucion_educativa, grado, edad, genero, peso, talla, hemoglobina) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssisdss", $nombre, $apellido, $institucion, $grado, $edad, $genero, $peso, $talla, $hemoglobina);
    $stmt->execute();
    $stmt->close();
    $conn->close();

    echo "<script>alert('Datos guardados correctamente.'); window.location.href='index.html';</script>";
  } else {
    echo "<script>alert('Faltan campos obligatorios.'); window.history.back();</script>";
  }
}
?>
