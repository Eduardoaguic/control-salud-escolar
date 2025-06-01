// asistente.js

// Crear el asistente virtual y agregarlo al body
const asistente = document.createElement('div');
asistente.id = 'asistente-virtual';
asistente.innerHTML = `
  <div id="asistente-header" style="background:#3498db;color:white;padding:10px;border-radius:10px 10px 0 0;cursor:pointer;font-weight:bold;">
    🤖 Asistente Virtual
  </div>
  <div id="asistente-body" style="display:none;background:#f4f9ff;padding:10px;font-size:14px;border:1px solid #3498db;border-top:0;border-radius:0 0 10px 10px;">
    <p id="asistente-texto">
      Bienvenido al sistema. Selecciona una sección para recibir ayuda contextual.
    </p>
  </div>
`;
asistente.style.position = 'fixed';
asistente.style.bottom = '20px';
asistente.style.right = '20px';
asistente.style.width = '260px';
asistente.style.boxShadow = '0 4px 12px rgba(0, 0, 0, 0.2)';
asistente.style.borderRadius = '10px';
asistente.style.zIndex = '9999';
document.body.appendChild(asistente);

// Función para mostrar u ocultar el cuerpo del asistente
document.getElementById('asistente-header').onclick = () => {
  const cuerpo = document.getElementById('asistente-body');
  cuerpo.style.display = (cuerpo.style.display === 'none') ? 'block' : 'none';
};

// Función para actualizar el contenido del asistente según la sección
function actualizarAsistente(seccion) {
  const texto = document.getElementById('asistente-texto');
  switch (seccion) {
    case 'registro':
      texto.innerHTML = `• Ingrese los datos del estudiante.<br>
                         • Presione “Analizar” para calcular hemoglobina.<br>
                         • Luego haga clic en “Guardar”.`;
      break;
    case 'indicadores':
      texto.innerHTML = `• Visualiza los gráficos de salud.<br>
                         • Analiza el resumen por institución y grado.`;
      break;
    case 'alertas':
      texto.innerHTML = `• Aquí se listan los estudiantes con hemoglobina crítica.<br>
                         • Prioriza estos casos para atención médica urgente.`;
      break;
    default:
      texto.innerHTML = `Bienvenido al sistema. Selecciona una sección para recibir ayuda contextual.`;
  }
}

// Escuchar el cambio de sección desde la función mostrarPantalla si la llamas
window.mostrarPantalla = function (id) {
  const pantallas = document.querySelectorAll('.pantalla');
  pantallas.forEach(p => p.classList.remove('activa'));
  document.getElementById(id).classList.add('activa');
  actualizarAsistente(id);
};

