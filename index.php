<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Panel Médico Escolar</title>
  <link rel="stylesheet" href="estilos.css">
  <style>
    .nav-buttons {
      display: flex;
      gap: 10px;
      margin-bottom: 20px;
    }
    .nav-buttons button {
      padding: 10px 20px;
      background-color: #3498db;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }
    .nav-buttons button:hover {
      background-color: #2980b9;
    }
    .pantalla { display: none; }
    .pantalla.activa { display: block; }
    .resumen-institucion {
      margin-top: 20px;
      padding: 15px;
      background: #f4f6f8;
      border-left: 5px solid #3498db;
      font-size: 16px;
    }
  </style>
</head>
<body>
  <div class="nav-buttons">
    <button onclick="mostrarPantalla('registro')">Registrar Estudiante</button>
    <button onclick="mostrarPantalla('indicadores')">Indicadores y Comunicaciones</button>
    <button onclick="mostrarPantalla('alertas')">Alertas Recientes</button>
  </div>

  <div id="registro" class="pantalla activa">
    <h2>Registro de Estudiantes</h2>
    <form method="POST" action="" id="formEstudiante">
      <input type="text" name="nombre" placeholder="Nombre" required>
      <input type="text" name="apellido" placeholder="Apellido" required>
      <input type="text" name="institucion_educativa" placeholder="Institución Educativa" required>
      <select name="grado" required>
        <option value="">Seleccione Grado</option>
        <option value="1° Primaria">1° Primaria</option>
        <option value="2° Primaria">2° Primaria</option>
        <option value="3° Primaria">3° Primaria</option>
        <option value="4° Primaria">4° Primaria</option>
        <option value="5° Primaria">5° Primaria</option>
        <option value="6° Primaria">6° Primaria</option>
        <option value="1° Secundaria">1° Secundaria</option>
        <option value="2° Secundaria">2° Secundaria</option>
        <option value="3° Secundaria">3° Secundaria</option>
        <option value="4° Secundaria">4° Secundaria</option>
        <option value="5° Secundaria">5° Secundaria</option>
      </select>
      <input type="number" name="edad" placeholder="Edad" required>
      <select name="genero" required>
        <option value="">Seleccione Género</option>
        <option value="Masculino">Masculino</option>
        <option value="Femenino">Femenino</option>
        <option value="Otro">Otro</option>
      </select>
      <input type="number" step="0.01" name="peso" id="peso" placeholder="Peso (kg)" required>
      <input type="number" step="0.01" name="talla" id="talla" placeholder="Talla (m)" required>
      <input type="text" name="hemoglobina" id="hemoglobina" placeholder="Hemoglobina" readonly>
      <button type="button" onclick="analizarHemoglobina()">Analizar</button>
      <button type="submit" name="guardar">Guardar</button>
    </form>
  </div>

  <div id="indicadores" class="pantalla">
    <h2>Indicadores Visuales</h2>
    <div class="graficos">
      <canvas id="grafAnemia"></canvas>
      <canvas id="grafSobrepeso"></canvas>
      <canvas id="grafMalnutricion"></canvas>
    </div>

    <h2>Resumen por Institución</h2>
    <div class="resumen-institucion">
      <?php
      $conn = new mysqli("localhost", "root", "", "control_salud_escolar");
      $resumen = $conn->query("SELECT institucion_educativa, COUNT(*) AS total FROM estudiantes GROUP BY institucion_educativa");
      while ($r = $resumen->fetch_assoc()) {
        echo "<p><strong>{$r['institucion_educativa']}</strong>: {$r['total']} estudiante(s) registrados.</p>";
      }
      ?>
    </div>

    <h2>Comunicaciones a Padres por Institución y Grado</h2>
    <div>
      <?php
      $query = "SELECT institucion_educativa, grado, COUNT(*) as total,
                       SUM(CASE WHEN hemoglobina < 12 THEN 1 ELSE 0 END) as casos_bajos
                FROM estudiantes
                GROUP BY institucion_educativa, grado";
      $result = $conn->query($query);
      while ($row = $result->fetch_assoc()) {
        $porcentaje = ($row['total'] > 0) ? ($row['casos_bajos'] / $row['total']) * 100 : 0;
        if ($porcentaje >= 30) {
          echo "<p><strong>{$row['institucion_educativa']}</strong> - {$row['grado']} tiene más del 30% de alumnos con baja hemoglobina.</p>";
        } elseif ($row['casos_bajos'] > 0) {
          echo "<p>{$row['institucion_educativa']} - {$row['grado']} presenta casos de hemoglobina baja.</p>";
        }
      }
      ?>
    </div>
  </div>

  <div id="alertas" class="pantalla">
    <h2>Alertas Médicas de Emergencia</h2>
    <table>
      <tr><th>ID</th><th>Nombre</th><th>Hemoglobina</th><th>Observación</th></tr>
      <?php
      $conn = new mysqli("localhost", "root", "", "control_salud_escolar");
      $result = $conn->query("SELECT id, nombre, apellido, hemoglobina FROM estudiantes WHERE hemoglobina < 10");
      while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['nombre']} {$row['apellido']}</td>
                <td>{$row['hemoglobina']}</td>
                <td><span style='color:red;'>Nivel crítico de hemoglobina</span></td>
              </tr>";
      }
      $conn->close();
      ?>
    </table>
  </div>

  <?php
  if (isset($_POST['guardar'])) {
    $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
    $apellido = isset($_POST['apellido']) ? $_POST['apellido'] : '';
    $institucion = isset($_POST['institucion_educativa']) ? $_POST['institucion_educativa'] : '';
    $grado = isset($_POST['grado']) ? $_POST['grado'] : '';
    $edad = isset($_POST['edad']) ? $_POST['edad'] : 0;
    $genero = isset($_POST['genero']) ? $_POST['genero'] : '';
    $peso = isset($_POST['peso']) ? $_POST['peso'] : 0;
    $talla = isset($_POST['talla']) ? $_POST['talla'] : 0;
    $hemoglobina = round(($peso / ($talla * $talla)) * 0.8, 2);

    if (!empty($nombre) && !empty($apellido) && !empty($institucion) && !empty($grado)) {
      $conn = new mysqli("localhost", "root", "", "control_salud_escolar");
      $stmt = $conn->prepare("INSERT INTO estudiantes (nombre, apellido, institucion_educativa, grado, edad, genero, peso, talla, hemoglobina) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssisdss", $nombre, $apellido, $institucion, $grado, $edad, $genero, $peso, $talla, $hemoglobina);
      $stmt->execute();
      $stmt->close();
      $conn->close();
      echo "<script>alert('Datos guardados correctamente.');</script>";
    } else {
      echo "<script>alert('Faltan campos obligatorios.');</script>";
    }
  }
  ?>

  <script>
    function analizarHemoglobina() {
      const peso = parseFloat(document.getElementById('peso').value);
      const talla = parseFloat(document.getElementById('talla').value);
      if (!isNaN(peso) && !isNaN(talla) && talla > 0) {
        const hemoglobina = ((peso / (talla * talla)) * 0.8).toFixed(2);
        document.getElementById('hemoglobina').value = hemoglobina;
      } else {
        alert('Ingrese correctamente el peso y la talla.');
      }
    }

    function mostrarPantalla(id) {
      const pantallas = document.querySelectorAll('.pantalla');
      pantallas.forEach(p => p.classList.remove('activa'));
      document.getElementById(id).classList.add('activa');
    }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="graficos.js"></script>
  <script src="asistente.js"></script>
</body>
</html>
