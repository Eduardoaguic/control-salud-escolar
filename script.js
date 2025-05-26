document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formIndicador');
  if (form) {
    form.addEventListener('submit', (e) => {
      e.preventDefault();
      const peso = parseFloat(document.getElementById('peso').value);
      const talla = parseFloat(document.getElementById('talla').value);
      const hemoglobina = parseFloat(document.getElementById('hemoglobina').value);

      const imc = peso / (talla * talla);
      let alerta = '';

      if (imc < 18) alerta += 'IMC bajo. ';
      if (hemoglobina < 11) alerta += 'Riesgo de anemia.';

      document.getElementById('resultado').textContent = `IMC calculado: ${imc.toFixed(2)}. ${alerta}`;
    });
  }
});

function mostrarSeccion(id) {
  document.querySelectorAll('.seccion').forEach(sec => sec.classList.remove('visible'));
  document.getElementById(id).classList.add('visible');
}

function enviarPregunta() {
  const input = document.getElementById('userInput');
  const chatbody = document.getElementById('chatbody');
  const pregunta = input.value.trim();
  if (!pregunta) return;

  chatbody.innerHTML += `<div><strong>Tú:</strong> ${pregunta}</div>`;
  input.value = '';

  let respuesta = '';
  const lower = pregunta.toLowerCase();

  if (lower.includes('imc')) {
    respuesta = 'El IMC es el Índice de Masa Corporal. Un valor menor a 18 puede indicar desnutrición.';
  } else if (lower.includes('hemoglobina')) {
    respuesta = 'La hemoglobina baja puede ser un signo de anemia. Se recomienda evaluación médica.';
  } else if (lower.includes('alerta')) {
    respuesta = 'Las alertas se generan si el IMC es menor a 18 o la hemoglobina menor a 11 g/dL.';
  } else if (lower.includes('predicción')) {
    respuesta = 'La predicción se basa en datos históricos y permite priorizar zonas de riesgo por salud escolar.';
  } else {
    respuesta = 'Lo siento, aún estoy aprendiendo. Puedes preguntar sobre IMC, hemoglobina, alertas o predicción.';
  }

  chatbody.innerHTML += `<div><strong>Asistente:</strong> ${respuesta}</div>`;
  chatbody.scrollTop = chatbody.scrollHeight;
}
