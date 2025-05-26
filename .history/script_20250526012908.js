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
  if (pregunta.toLowerCase().includes('imc')) {
    respuesta = 'El IMC es el índice de masa corporal. Un valor bajo puede indicar desnutrición.';
  } else if (pregunta.toLowerCase().includes('hemoglobina')) {
    respuesta = 'La hemoglobina baja puede ser un indicador de anemia. Se recomienda evaluación médica.';
  } else if (pregunta.toLowerCase().includes('alerta')) {
    respuesta = 'Las alertas se generan cuando un valor de IMC es menor a 18 o hemoglobina menor a 11.';
  } else {
    respuesta = 'Lo siento, aún estoy aprendiendo. Intenta con otra pregunta relacionada a salud escolar.';
  }

  chatbody.innerHTML += `<div><strong>Asistente:</strong> ${respuesta}</div>`;
  chatbody.scrollTop = chatbody.scrollHeight;
}
